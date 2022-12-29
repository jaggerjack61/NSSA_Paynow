<?php

namespace App\Http\Controllers;

use App\Helpers\PaynowHelper;
use App\Models\Client;
use App\Models\ClientRequest;
use App\Models\Detail;
use App\Models\Registration;
use App\Models\WhatsappSetting;
use Illuminate\Http\Request;

class AdvancedWebhookController extends Controller
{
    public $phone;
    public $company ='PRMB';
    public $pay;

    public function __construct()
    {
        $this->pay=New PaynowHelper();
    }


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

    public function transactionAmount():float
    {
        $settings=WhatsappSetting::first();
        return $settings->amount_check;
    }

    public function registrationAmount():float
    {
        $settings=WhatsappSetting::first();
        return $settings->amount_register;
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
                Registration::create([
                    'phone'=>$this->phone
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
        if($client->status=='none' and $client->reg->terms_conditions=='accepted'){
            $this->sendMsgInteractive([$this->company,'Welcome to Pilon Records Management Bureau, how can we help you today?','Click Below'],
                [['id'=>'check_registration','title'=>'View NSSA Status'],['id'=>'register','title'=>'Register']]);


        }
        elseif($client->status=='none' and $client->reg->terms_conditions=='rejected'){
            $this->sendMsgInteractive([
                $this->company,
                'Welcome Pilon Records Management Bureau NSSA registration bot. Pilon Records Management Bureau is a third party organization that is not affiliated with NSSA. To view our privacy policy visit https://recordsmanager.co.zw/policy. Do you accept our terms and conditions?',
                'Get started'],
                [['id'=>'accept','title'=>'Accept'], ['id'=>'no','title'=>'Reject']  ]);

        }
        elseif($client->status=='ID'){
            $message=str_replace('-','',$message);
            $pattern='/[0-9]{9}[A-Z]{1}[0-9]{2}/i';
            $pattern2='/[0-9]{8}[A-Z]{1}[0-9]{2}/i';
            if(preg_match($pattern, $message) or preg_match($pattern2, $message)){
                $details=Detail::where('id_number',$message)->first();
                if($details){
                    $req=new ClientRequest();
                    $req->phone=$this->phone;
                    $req->details_id=$details->id;
                    $req->save();
                    $this->sendMsgInteractive([$this->company,'Congratulations!! '.$details->firstname.' '.$details->lastname.' you are registered with NSSA. To view your SSN ( Social Security Number ) for a fee of RTGS:$'.$this->transactionAmount().' select one of the payment methods below. Type anything to cancel and return home.','Select Payment'],
                        [['id'=>'ecocash','title'=>'Eco Cash'], ['id'=>'onewallet','title'=>'One Wallet'], ['id'=>'telecash','title'=>'Telecash']  ]);
                    //$this->sendMsgText($ssnNo[2]);
                    $client->status='none';
                    $client->save();
                }
                else{

                    $ssn=new MainController();
                    $ssn->getSSN($message);
                    $details=Detail::where('id_number',$message)->first();
                    if($details){
                        $req=new ClientRequest();
                        $req->phone=$this->phone;
                        $req->details_id=$details->id;
                        $req->save();
                        $pattern='/[0-9]{7}[A-Z]{1}/i';
                        if(preg_match($pattern, $details->ssn)){
                            $this->sendMsgInteractive(['SSN Look Up','Hie '.$details->firstname.' '.$details->lastname.' we found your SSN please select a payment method','Select Payment'],
                                [['id'=>'ecocash','title'=>'Eco Cash'], ['id'=>'onemoney','title'=>'One Money'], ['id'=>'telecash','title'=>'Telecash']  ]);
                            //$this->sendMsgText($ssnNo[2]);
                            $client->status='none';
                            $client->save();
                        }
                    }
                    else{
                        $this->sendMsgInteractive([$this->company,'You are not registered with NSSA. Would you like us to register with NSSA for a fee of RTGS $'.$this->registrationAmount(),'Get started'],
                            [['id'=>'register_name','title'=>'YES'], ['id'=>'no','title'=>'NO']  ]);
                        $client->status='none';
                        $client->save();
                    }
                }


            }

            else{
                $this->sendMsgInteractive([$this->company,
                    'Enter your ID in the form 123456789X00','Check Status'],
                    [['id'=>'no','title'=>'Cancel']]);
            }

        }
        elseif($client->status=='ecocash'){
            $pattern='/[0-9]{10}/i';
            if(preg_match($pattern, $message)) {
                $client->status='none';
                $client->save();
                $pay=new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobile($this->phone,'catchesystems263@gmail.com',$message,'ecocash');

            }
            else{
                $this->sendMsgInteractive(['Bureau of Records','Please enter a valid Eco Cash number','Payment'],
                    [['id'=>'no','title'=>'Cancel']]);

            }

        }
        elseif($client->status=='onewallet'){
            $pattern='/[0-9]{10}/i';
            if(preg_match($pattern, $message)) {
                $client->status='none';
                $client->save();
                $pay=new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobile($this->phone,'catchesystems263@gmail.com',$message,'onewallet');

            }
            else{
                $this->sendMsgInteractive(['Bureau of Records','Please enter a valid One Wallet number','Payment'],
                    [['id'=>'no','title'=>'Cancel']]);
            }

        }
        elseif($client->status=='telecash'){
            $pattern='/[0-9]{10}/i';
            if(preg_match($pattern, $message)) {
                $client->status='none';
                $client->save();
                $pay=new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobile($this->phone,'catchesystems263@gmail.com',$message,'telecash');

            }
            else{
                $this->sendMsgInteractive(['Bureau of Records','Please enter a valid Telecash number','Payment'],
                    [['id'=>'no','title'=>'Cancel']]);
            }

        }
    }

    public function handleList($arr)
    {

    }
    //23114017f80
    //631555305g50
    public function handleButton($arr)
    {
        $client=Client::where('phone',$this->phone)->first();
        if($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id']=='check_registration'){

            $client->status='ID';
            $client->save();
            $this->sendMsgInteractive([$this->company,
                'Enter your ID in the form 123456789X00','Check Status'],
                [['id'=>'no','title'=>'Cancel']]);

        }
        elseif($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id']=='no'){
            $client->status='none';
            $client->save();
            $this->sendMsgText('Understandable have a nice day.');
        }
        elseif($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id']=='ecocash'){
            $client->status='ecocash';
            $client->save();
            $this->sendMsgInteractive(['Bureau of Records','Please enter a valid Eco Cash number','Payment'],
                [['id'=>'no','title'=>'Cancel']]);
        }
        elseif($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id']=='onewallet'){
            $client->status='onewallet';
            $client->save();
            $this->sendMsgInteractive(['Bureau of Records','Please enter a valid One Wallet number','Payment'],
                [['id'=>'no','title'=>'Cancel']]);
        }
        elseif($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id']=='telecash'){
            $client->status='telecash';
            $client->save();
            $this->sendMsgInteractive(['Bureau of Records','Please enter a valid Telecash number','Payment'],
                [['id'=>'no','title'=>'Cancel']]);
        }
        elseif($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id']=='accept'){
            $reg=Registration::where('phone',$client->phone)->first();
            $reg->terms_conditions='accepted';
            $reg->save();
            $this->sendMsgInteractive([$this->company,'Welcome to Pilon Records Management Bureau, how can we help you today?','Click Below'],
                [['id'=>'check_registration','title'=>'View NSSA Status'],['id'=>'register','title'=>'Register']]);
        }
        elseif($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id']=='register') {
            $this->sendMsgInteractive([$this->company,'Would you like us to register you with NSSA for a fee of RTGS $'.$this->registrationAmount(),'Get started'],
                [['id'=>'register_name','title'=>'YES'], ['id'=>'no','title'=>'NO']  ]);
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

    public function sendMsgText2($phone,$textMsg)
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
                "to": "'.$phone.'",
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
