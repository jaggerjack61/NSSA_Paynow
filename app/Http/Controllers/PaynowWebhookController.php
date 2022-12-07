<?php

namespace App\Http\Controllers;

use App\Models\ClientRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PaynowWebhookController extends Controller
{
    public function resultUrl(Request $request)
    {
        $msg=new WebhookController();
        $fptr = fopen('myfile1.json', 'w');
        fwrite($fptr, json_encode($request->all()));
        fclose($fptr);
        $data=$request->all();
        if(array_key_exists('error',$data)){
            $fptr = fopen('status.txt', 'w');
            fwrite($fptr, 'Error');
            fclose($fptr);
        }
        else{
            $client = new Client();

            while(1==1){
                $response=$client->get($data['pollurl'])->getBody()->getContents();
                parse_str($response,$output);
                if($output['status']=='Paid'){
                    $ssn=ClientRequest::where('phone',$output['reference'])->latest()->first()->details->ssn;
                    $msg->sendMsgText2($output['reference'],$ssn);
                    $fptr = fopen('status.txt', 'w');
                    fwrite($fptr, 'Paid');
                    fclose($fptr);
                    break;
                }
                elseif($output['status']=='Sent'){
                    $fptr = fopen('status.txt', 'w');
                    fwrite($fptr, 'Sent');
                    fclose($fptr);
                    sleep(1);
                }
                elseif($output['status']=='Failed'){

                    $msg->sendMsgText2($output['reference'],'failed');
                    $fptr = fopen('status.txt', 'w');
                    fwrite($fptr, 'Failed');
                    fclose($fptr);
                    break;

                }
                elseif($output['status']=='Cancelled'){
                    $msg->sendMsgText2($output['reference'],'cancelled');
                    $fptr = fopen('status.txt', 'w');
                    fwrite($fptr, 'Cancelled');
                    fclose($fptr);
                    break;
                }
                elseif($output['status']=='Insufficient funds'){
                    $fptr = fopen('status.txt', 'w');
                    fwrite($fptr, 'Insufficient funds');
                    fclose($fptr);
                    break;
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
