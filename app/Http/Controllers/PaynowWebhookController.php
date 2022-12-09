<?php

namespace App\Http\Controllers;

use App\Models\ClientRequest;
use App\Models\Payment;
use App\Models\WhatsappSetting;
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
        $details=ClientRequest::where('phone',$request['reference'])->latest()->first();
        $payment=new Payment();
        $payment->reference=$request['reference'];
        $payment->unique_id=$request['paynowreference'];
        $payment->amount=WhatsappSetting::first()->amount;
        $payment->details_id=$details->details->id;
        $payment->client_requests_id=$details->id;
        $payment->status=$request['status'];
        $payment->poll_url=$request['pollurl'];
        $payment->save();

            if($request['status']=='Paid'){
                $ssn=$details->details->ssn;
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
