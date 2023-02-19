<?php

namespace App\Http\Controllers;

use App\Helpers\PaynowHelper;
use App\Models\Card;
use App\Models\Detail;
use App\Models\Registration;
use App\Models\SiteMessage;
use App\Models\WhatsappSetting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class MainController extends Controller
{
    public function index()
    {
        return view('index');
        // $pay->makePaymentMobile('unique','jarai.samuel@gmail.com',[['SSN Request',1]]);
        // return view('pages.home');
    }
    public function showWhatsapp()
    {
        return view('welcome');
        // $pay->makePaymentMobile('unique','jarai.samuel@gmail.com',[['SSN Request',1]]);
        // return view('pages.home');
    }

    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function getSSN($ID)
    {
        //$ID='632105381Q43';

        $client = new Client();
        $url['get-token']='https://selfservice.nssa.org.zw/EmployeeSignup/FindPerson';
        $url['form-action'] = 'https://selfservice.nssa.org.zw/EmployeeSignup/GetPersonDetails';
//        $response = $client->get($url['get-token']);

//        dd($tree->filterXPath('//a/@href')->text());

        $response = $client->post(
            $url['form-action'],
            ['form_params' => ['criteria' => 'NID', 'searchText' =>$ID]]
        );
        $tree=new Crawler($response->getBody()->getContents());

////        $tree->filter('.float-right')->each(function ($node) {
////            $text = $node->filter('.text-sm')->text();
////            echo $text;
////        });
//        dd($text);
        try{
            $SSN=$tree->filterXPath('//h6')->text();
            $SSN=substr($SSN,6);
            if(strlen($SSN)==8){
                $text=[];
                $text=$tree->filter('.float-right')->each(function ($node) {
                    return $node->text();
                });
                $text[2]=$SSN;

                Detail::create([
                    'id_number'=>$ID,
                    'ssn'=>$SSN,
                    'firstname'=>$text[0],
                    'lastname'=>$text[1]
                ]);
                //return $details;


                //dd($SSN);
            }

        }
        catch (\Exception $e){
            return array('not','found','error');
            dd($e->getMessage());
        }


    }

    public function test(){
        $pay=new PaynowHelper();
        $pay->makePaymentMobile('263775361584','catchesystems263@gmail.com','0774444444','ecocash');
        return view('welcome');
    }

    public function showSettings()
    {
        $settings=WhatsappSetting::first();
        return view('pages.settings',compact('settings'));
    }

    public function setSettings(Request $request)
    {
     $settings=WhatsappSetting::first();
     $settings->amount_check=$request->amount_check;
     $settings->amount_register=$request->amount_register;
     $settings->amount_card=$request->amount_card;
     $settings->save();
     return back();
    }

    public function showReports()
    {

        return view('pages.reports');
    }

    public function showPolicy()
    {
        return view('pages.privacy-policy');
    }

    public function showRegistrations()
    {
        $registrations=Registration::where('payment','complete')->paginate(30);
        return view('pages.registrations',compact('registrations'));
    }
    public function register(Registration $id)
    {
        $id->status='registered';
        $id->save();
        return back();
    }
    public function unregister(Registration $id)
    {
        $id->status='complete';
        $id->save();
        return back();
    }

    public function saveMessage(Request $request)
    {
        try{
            $data=$request->validate([
                'message' =>'required',
                'name'=>'required',
                'email'=>'required'
            ]);
            SiteMessage::create($data);
            return back()->with('success','it worked');
        }
        catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function showMessages()
    {
        $messages=SiteMessage::paginate(30);
        return view('pages.messages',compact('messages'));
    }
    public function attend(SiteMessage $id)
    {
        $id->status='attended';
        $id->save();
        return back()->with('success',$id->name.' has been attended.');
    }

    public function showCards()
    {
        $cards=Card::paginate(30);
        return view('pages.cards',compact('cards'));
    }
    public function finish(Card $id)
    {
        $id->status='finished';
        $id->save();
        return back()->with('success','This card has been marked as completed.');
    }




}
