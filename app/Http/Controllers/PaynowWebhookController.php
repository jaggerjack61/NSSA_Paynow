<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PaynowWebhookController extends Controller
{
    public function resultUrl(Request $request)
    {
        $fptr = fopen('myfile1.json', 'w');
        fwrite($fptr, json_encode($request->all()));
        fclose($fptr);
        $data=$request->all();
        if($data['error']){

        }
        else{
            $client = new Client();

            while(1==1){
                $response=$client->get($data['pollurl'])->getBody()->getContents();
                parse_str($response,$output);
                if($output['status']=='Paid'){
                    //payment successful
                }
                elseif($output['status']=='Sent'){
                    //payment failed
                    sleep(1);
                }
                elseif($output['status']=='Failed'){

                }
                elseif($output['status']=='Cancelled'){

                }
                elseif($output['status']=='Cancelled'){

                }
            }

//            $fptr = fopen('myfile2.txt', 'w');
//            fwrite($fptr, $output['status'].$output['reference'].$output['paynowreference']);
//            fclose($fptr);
        }

    }
    public function returnUrl(Request $request)
    {

    }
}
