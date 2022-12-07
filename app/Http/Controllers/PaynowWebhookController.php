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

                if($request['status']=='Paid'){
                    $ssn=ClientRequest::where('phone',$request['reference'])->latest()->first()->details->ssn;
                    $msg->sendMsgText2($request['reference'],'Your SSN is '.$ssn);
                    $fptr = fopen('status.txt', 'w');
                    fwrite($fptr, 'Paid');
                    fclose($fptr);

                }
                elseif($request['status']=='Sent'){
                    $fptr = fopen('status.txt', 'w');
                    fwrite($fptr, 'Sent');
                    fclose($fptr);
                    sleep(1);
                }
                elseif($request['status']=='Failed'){

                    $msg->sendMsgText2($request['reference'],'Transaction failed.');
                    $fptr = fopen('status.txt', 'w');
                    fwrite($fptr, 'Failed');
                    fclose($fptr);


                }
                elseif($request['status']=='Cancelled'){
                    $msg->sendMsgText2($request['reference'],'The transaction has been cancelled.');
                    $fptr = fopen('status.txt', 'w');
                    fwrite($fptr, 'Cancelled');
                    fclose($fptr);

                }
                elseif($request['status']=='Insufficient funds'){
                    $msg->sendMsgText2($request['reference'],'You have an insufficient balance.');
                    $fptr = fopen('status.txt', 'w');
                    fwrite($fptr, 'Insufficient funds');
                    fclose($fptr);

                }

        return response('',200);


    }
    public function returnUrl(Request $request)
    {

    }
}
