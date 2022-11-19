<?php

namespace App\Http\Controllers;

use App\Helpers\PaynowHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class MainController extends Controller
{
    public function index(PaynowHelper $pay)
    {
        $pay->makePaymentMobile('unique','jarai.samuel@gmail.com',[['SSN Request',1]]);
        return view('pages.home');
    }

    public function getSSN()
    {
        $client = new Client();
        $url['get-token']='https://selfservice.nssa.org.zw/EmployeeSignup/FindPerson';
        $url['form-action'] = 'https://selfservice.nssa.org.zw/EmployeeSignup/GetPersonDetails';
//        $response = $client->get($url['get-token']);

//        dd($tree->filterXPath('//a/@href')->text());

        $response = $client->post(
            $url['form-action'],
            ['form_params' => ['criteria' => 'NID', 'searchText' =>'632105381Q43']]
        );
        $tree=new Crawler($response->getBody()->getContents());
        try{
            $SSN=$tree->filterXPath('//h6')->text();
            $SSN=substr($SSN,6);
            if(strlen($SSN)==8){
                dd($SSN);
            }

        }
        catch (\Exception $e){
            dd($e->getMessage());
        }


    }
}
