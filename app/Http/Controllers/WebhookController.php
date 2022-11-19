<?php

namespace App\Http\Controllers;

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
        return $settings->bearer_token;
    }

    public function webhookId():string
    {
        $settings=WhatsappSetting::first();
        return $settings->whatsapp_id;
    }


    public function webhookReceiver(Request $request)
    {

        $fptr = fopen('myfile.json', 'w');
        fwrite($fptr, json_encode($request->all()));
        fclose($fptr);
        $arr = $request->all();




        if(array_key_exists('messages',$arr['entry'][0]['changes'][0]['value'])){
            $this->phone=$arr['entry'][0]['changes'][0]['value']['messages'][0]['from'] ?? 'no number';

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

    }

    public function handleList($arr)
    {

    }

    public function handleButton($arr)
    {

    }
}
