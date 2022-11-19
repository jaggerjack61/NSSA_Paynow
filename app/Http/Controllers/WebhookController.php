<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\WhatsappSetting;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public $phone;
    public $company ='Virl Micro-Finance';


    public function webhookSetup(Request $request)
    {

        $mode=$request->hub_mode;
        $token=$request->hub_verify_token;
        $challenge=$request->hub_challenge;
        if($mode and $token){
            return response ($challenge, 200);
        }
        return response('',404);

    }

    public function webhookToken():string
    {
        $settings=WhatsappSetting::first();
        return $settings->token;
    }

    public function webhookId():string
    {
        $settings=WhatsappSetting::first();
        return $settings->phoneId;
    }


    public function webhookReceiver(Request $request)
    {



        response('',200);
        $arr=$request->all();

        if(array_key_exists('messages',$arr['entry'][0]['changes'][0]['value'])){
            $this->phone=$arr['entry'][0]['changes'][0]['value']['messages'][0]['from'] ?? 'no number';
            $client=Client::where('phone',$this->phone)->first();
            if(!$client){
                Client::create([
                    'phone'=>$this->phone,
                ]);
            }

            if(array_key_exists('text',$arr['entry'][0]['changes'][0]['value']['messages'][0])){
                $this->handleMsg($arr);
            }
            elseif(array_key_exists('interactive',$arr['entry'][0]['changes'][0]['value']['messages'][0])) {
                if (array_key_exists('button_reply', $arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive'])) {
                    $this->handleButton($arr);

                }
                elseif(array_key_exists('list_reply', $arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive'])) {
                    $this->handleList($arr);

                }
            }

        }




        return response('',200);
    }

    public function handleMsg($arr)
    {
        $message=$arr['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        $client=Client::where('phone',$this->phone)->first();
        if($client->status=='none'){
            $this->sendMsgInteractive(['SSN Look Up','Would you like to find out your SSN','Get started'],
            [['id'=>'yes','title'=>'YES'], ['id'=>'no','title'=>'NO']  ]);

        }
        elseif($client->status=='ID'){
            $ssn=new MainController();
            $this->sendMsgText($ssn->getSSN($message));
            $client->status='none';
            $client->save();
        }
    }

    public function handleList($arr)
    {

    }

    public function handleButton($arr)
    {
        $client=Client::where('phone',$this->phone)->first();
        if($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id']=='yes'){

            $client->status='ID';
            $client->save();
            $this->sendMsgText('Enter your Id in the form 641777505X59');
        }
        elseif($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id']=='no'){
            $this->sendMsgText('Understandable have a nice day.');
        }
    }

    public function sendMsgText($textMsg)
    {
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->webhookToken()
        ];
        $body = '{
                "messaging_product": "whatsapp",
                "preview_url": false,
                "recipient_type": "individual",
                "to": "'.$this->phone.'",
                "type": "text",
                "text": {
                    "body": "'. $textMsg .'"
                }
            }';

        $request = new \GuzzleHttp\Psr7\Request('POST', 'https://graph.facebook.com/v13.0/'.$this->webhookId().'/messages', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }

    public function sendMsgInteractive($text,$buttons)
    {
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->webhookToken()
        ];
        $buttonJson='';
        foreach($buttons as $button) {
            $buttonJson .= '{
                          "type": "reply",
                          "reply": {
                            "id": "'.$button['id'].'",
                            "title": "'.$button['title'].'"
                          }
                        },';
        }
//        $fptr = fopen('myfile5.txt', 'w');
//        fwrite($fptr, $buttonJson);
//        fclose($fptr);
        $body = '{
                  "recipient_type": "individual",
                  "messaging_product": "whatsapp",
                  "to": "'.$this->phone.'",
                  "type": "interactive",
                  "interactive": {
                    "type": "button",
                    "header": {
                      "type": "text",
                      "text": "'.$text[0].'"
                    },
                    "body": {
                      "text": "'.$text[1].'"
                    },
                    "footer": {
                      "text": "'.$text[2].'"
                    },
                    "action": {
                      "buttons": [
                        '.$buttonJson.'
                      ]
                    }
                  }
                }';
        $request = new \GuzzleHttp\Psr7\Request('POST', 'https://graph.facebook.com/v14.0/'.$this->webhookId().'/messages', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }


}
