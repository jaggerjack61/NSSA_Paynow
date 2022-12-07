<?php

namespace App\Http\Controllers;

use App\Helpers\PaynowHelper;
use App\Models\Detail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class MainController extends Controller
{
    public function index(PaynowHelper $pay)
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
}
