<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class MainController extends Controller
{
    public function index()
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
        $SSN=$tree->filterXPath('//h6')->text();
        $SSN=substr($SSN,6);
        dd($SSN);

        dd(($tree->filterXPath('//h6')->text()),'hie');
        return view('pages.home',compact('response'));
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
        dd(($tree->filterXPath('//h6')->text()));
    }
}
