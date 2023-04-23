<?php

namespace App\Http\Controllers;

use App\Helpers\PaynowHelper;
use App\Models\Card;
use App\Models\Client;
use App\Models\ClientRequest;
use App\Models\Detail;
use App\Models\Registration;
use App\Models\WhatsappSetting;
use Illuminate\Http\Request;

class AdvancedWebhookController extends Controller
{
    public $phone;
    public $company = 'PRMB';
    public $pay;
    public $settings;

    public function __construct()
    {
        $this->pay = new PaynowHelper();
        $this->settings = WhatsappSetting::first();
    }


    public function webhookSetup(Request $request)
    {

        $mode = $request->hub_mode;
        $token = $request->hub_verify_token;
        $challenge = $request->hub_challenge;
        if ($mode and $token) {
            return response($challenge, 200);
        }
        return response('', 404);

    }

    public function webhookToken(): string
    {

        return $this->settings->token;
    }

    public function webhookId(): string
    {

        return $this->settings->phoneId;
    }

    public function transactionAmount(): float
    {

        return $this->settings->amount_check;
    }

    public function registrationAmount(): float
    {

        return $this->settings->amount_register;
    }

    public function cardAmount(): float
    {

        return $this->settings->amount_card;
    }


    public function webhookReceiver(Request $request)
    {


        response('', 200);
        $arr = $request->all();

        if (array_key_exists('messages', $arr['entry'][0]['changes'][0]['value'])) {
            $this->phone = $arr['entry'][0]['changes'][0]['value']['messages'][0]['from'] ?? 'no number';
            $client = Client::where('phone', $this->phone)->first();
            if (!$client) {
                Client::create([
                    'phone' => $this->phone,
                ]);
                Registration::create([
                    'phone' => $this->phone
                ]);
            }

            if (array_key_exists('text', $arr['entry'][0]['changes'][0]['value']['messages'][0])) {
                $this->handleMsg($arr);
            } elseif (array_key_exists('interactive', $arr['entry'][0]['changes'][0]['value']['messages'][0])) {
                if (array_key_exists('button_reply', $arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive'])) {
                    $this->handleButton($arr);

                } elseif (array_key_exists('list_reply', $arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive'])) {
                    $this->handleList($arr);

                }
            } elseif (array_key_exists('image', $arr['entry'][0]['changes'][0]['value']['messages'][0])) {
//                $fptr1 = fopen('myfilex.txt', 'w');
//                fwrite($fptr1, $arr['entry'][0]['changes'][0]['value']['messages'][0]['image']['id'].json_encode($arr['entry'][0]['changes'][0]['value']['messages'][0]['image']));
//                fclose($fptr1);

                $this->handleImage($arr);

                //return response('',200);
            }

        }


        return response('', 200);
    }

    public function handleImage($arr)
    {

        $mediaId = $arr['entry'][0]['changes'][0]['value']['messages'][0]['image']['id'];
        $url = $this->retrieveMediaUrl($mediaId);

        $client = Client::where('phone', $this->phone)->first();


        if ($client->status == 'none') {

            $this->sendMsgText('Thanks for the pic ,but please select from our list of menu items');
        } elseif ($client->status == 'apply_pic') {
            //save image of id here
            $this->downloadMedia($url, 'id');

            $client->update([
                'status' => 'none'
            ]);
            $client->save();
            Card::where('phone', $this->phone)->update(['status' => 'complete']);
            $this->sendMsgText('Your application has been submitted, we will have your card ready in 5 to 7 business days. Have a nice day.');


        }


    }

    public function handleMsg($arr)
    {
        $message = $arr['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        $client = Client::where('phone', $this->phone)->first();
        if ($message == 'chadhonzwa') {
            Client::where('status', '!=', null)->update(['status' => 'none']);
            $this->sendMsgText("User statuses have been reset");
            return True;
        }
        if ($client->status == 'none' and $client->reg->terms_conditions == 'accepted') {
            $this->sendMsgInteractive([$this->company, 'Welcome to Pilon Records Management Bureau, how can we help you today?', 'Click Below'],
                [['id' => 'check_registration', 'title' => 'View NSSA Status'], ['id' => 'register', 'title' => 'NSSA Registration'], ['id' => 'apply_card', 'title' => 'Portal Registration']]);


        } elseif ($client->status == 'none' and $client->reg->terms_conditions == 'rejected') {
            $this->sendMsgInteractive([
                $this->company,
                'Welcome to Pilon Records Management Bureau NSSA registration bot. Pilon Records Management Bureau is a third party organization assisting with NSSA registration only. To view our privacy policy visit https://recordsmanager.co.zw/policy. Do you accept our terms and conditions?',
                'Get started'],
                [['id' => 'accept', 'title' => 'Accept'], ['id' => 'no', 'title' => 'Reject']]);

        } elseif ($client->status == 'ID') {
            $message = str_replace('-', '', $message);
            $pattern = '/[0-9]{9}[A-Z]{1}[0-9]{2}/i';
            $pattern2 = '/[0-9]{8}[A-Z]{1}[0-9]{2}/i';
            if (preg_match($pattern, $message) or preg_match($pattern2, $message)) {
                $details = Detail::where('id_number', $message)->first();
                if ($details) {
                    $req = new ClientRequest();
                    $req->phone = $this->phone;
                    $req->details_id = $details->id;
                    $req->save();
                    $this->sendMsgInteractive([$this->company, 'Congratulations!! ' . $details->firstname . ' ' . $details->lastname . ' you are registered with NSSA. To view your SSN ( Social Security Number ) for a fee of RTGS:$' . $this->transactionAmount() . ' select one of the payment methods below. Type anything to cancel and return home.', 'Select Payment'],
                        [['id' => 'ecocash', 'title' => 'Eco Cash'], ['id' => 'onewallet', 'title' => 'One Wallet'], ['id' => 'telecash', 'title' => 'Telecash']]);
                    //$this->sendMsgText($ssnNo[2]);
                    $client->status = 'none';
                    $client->save();
                } else {

                    $ssn = new MainController();
                    $ssn->getSSN($message);
                    $details = Detail::where('id_number', $message)->first();
                    if ($details) {
                        $req = new ClientRequest();
                        $req->phone = $this->phone;
                        $req->details_id = $details->id;
                        $req->save();
                        $pattern = '/[0-9]{7}[A-Z]{1}/i';
                        if (preg_match($pattern, $details->ssn)) {
                            $this->sendMsgInteractive([$this->company, 'Congratulations!! ' . $details->firstname . ' ' . $details->lastname . ' you are registered with NSSA. To view your SSN ( Social Security Number ) for a fee of RTGS:$' . $this->transactionAmount() . ' select one of the payment methods below. Type anything to cancel and return home.', 'Select Payment'],
                                [['id' => 'ecocash', 'title' => 'Eco Cash'], ['id' => 'onewallet', 'title' => 'One Wallet'], ['id' => 'telecash', 'title' => 'Telecash']]);
                            //$this->sendMsgText($ssnNo[2]);
                            $client->status = 'none';
                            $client->save();
                        }
                    } else {
                        $this->sendMsgInteractive([$this->company, 'You are not registered with NSSA. Would you like us to register with NSSA for a fee of RTGS $' . $this->registrationAmount(), 'Get started'],
                            [['id' => 'register_fname', 'title' => 'YES'], ['id' => 'no', 'title' => 'NO']]);
                        $client->status = 'none';
                        $client->save();
                    }
                }


            } else {
                $this->sendMsgInteractive([$this->company,
                    'Enter your ID in the form 123456789X00', 'Check Status'],
                    [['id' => 'no', 'title' => 'Cancel']]);
            }

        } elseif ($client->status == 'ecocash') {
            $pattern = '/[0-9]{10}/i';
            if (preg_match($pattern, $message)) {
                $client->status = 'none';
                $client->save();
                $pay = new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobile($this->phone, 'catchesystems263@gmail.com', $message, 'ecocash');

            } else {
                $this->sendMsgInteractive([$this->company, 'Please enter a valid Eco Cash number', 'Payment'],
                    [['id' => 'no', 'title' => 'Cancel']]);

            }

        } elseif ($client->status == 'onewallet') {
            $pattern = '/[0-9]{10}/i';
            if (preg_match($pattern, $message)) {
                $client->status = 'none';
                $client->save();
                $pay = new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobile($this->phone, 'catchesystems263@gmail.com', $message, 'onewallet');

            } else {
                $this->sendMsgInteractive([$this->company, 'Please enter a valid One Wallet number', 'Payment'],
                    [['id' => 'no', 'title' => 'Cancel']]);
            }

        } elseif ($client->status == 'telecash') {
            $pattern = '/[0-9]{10}/i';
            if (preg_match($pattern, $message)) {
                $client->status = 'none';
                $client->save();
                $pay = new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobile($this->phone, 'catchesystems263@gmail.com', $message, 'telecash');

            } else {
                $this->sendMsgInteractive([$this->company, 'Please enter a valid Telecash number', 'Payment'],
                    [['id' => 'no', 'title' => 'Cancel']]);
            }

        } elseif ($client->status == 'reg_ecocash') {
            $pattern = '/[0-9]{10}/i';
            if (preg_match($pattern, $message)) {
                $client->status = 'none';
                $client->save();
                $pay = new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobileReg($this->phone . 'r', 'catchesystems263@gmail.com', $message, 'ecocash');

            } else {
                $this->sendMsgInteractive([$this->company, 'Please enter a valid Eco Cash number', 'Payment'],
                    [['id' => 'no', 'title' => 'Cancel']]);

            }

        } elseif ($client->status == 'reg_onewallet') {
            $pattern = '/[0-9]{10}/i';
            if (preg_match($pattern, $message)) {
                $client->status = 'none';
                $client->save();
                $pay = new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobileReg($this->phone . 'r', 'catchesystems263@gmail.com', $message, 'onewallet');

            } else {
                $this->sendMsgInteractive([$this->company, 'Please enter a valid One Wallet number', 'Payment'],
                    [['id' => 'no', 'title' => 'Cancel']]);
            }

        } elseif ($client->status == 'reg_telecash') {
            $pattern = '/[0-9]{10}/i';
            if (preg_match($pattern, $message)) {
                $client->status = 'none';
                $client->save();
                $pay = new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobileReg($this->phone . 'r', 'catchesystems263@gmail.com', $message, 'telecash');

            } else {
                $this->sendMsgInteractive([$this->company, 'Please enter a valid Telecash number', 'Payment'],
                    [['id' => 'no', 'title' => 'Cancel']]);
            }

        } elseif ($client->status == 'apply_ecocash') {
            $pattern = '/[0-9]{10}/i';
            if (preg_match($pattern, $message)) {
                $client->status = 'none';
                $client->save();
                $pay = new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobileApply($this->phone . 'c', 'catchesystems263@gmail.com', $message, 'ecocash');

            } else {
                $this->sendMsgInteractive([$this->company, 'Please enter a valid Eco Cash number', 'Payment'],
                    [['id' => 'no', 'title' => 'Cancel']]);

            }

        } elseif ($client->status == 'apply_onewallet') {
            $pattern = '/[0-9]{10}/i';
            if (preg_match($pattern, $message)) {
                $client->status = 'none';
                $client->save();
                $pay = new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobileApply($this->phone . 'c', 'catchesystems263@gmail.com', $message, 'onewallet');

            } else {
                $this->sendMsgInteractive([$this->company, 'Please enter a valid One Wallet number', 'Payment'],
                    [['id' => 'no', 'title' => 'Cancel']]);
            }

        } elseif ($client->status == 'apply_telecash') {
            $pattern = '/[0-9]{10}/i';
            if (preg_match($pattern, $message)) {
                $client->status = 'none';
                $client->save();
                $pay = new PaynowHelper();
                $this->sendMsgText('Please wait');
                $pay->makePaymentMobileApply($this->phone . 'c', 'catchesystems263@gmail.com', $message, 'telecash');

            } else {
                $this->sendMsgInteractive([$this->company, 'Please enter a valid Telecash number', 'Payment'],
                    [['id' => 'no', 'title' => 'Cancel']]);
            }

        } elseif ($client->status == 'register_fname') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->first_names = $message;
            $reg->save();
            $client->status = 'register_lname';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter your last name.', 'Registration 2/10'],
                [['id' => 'no', 'title' => 'Cancel']]);

        } elseif ($client->status == 'register_lname') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->last_name = $message;
            $reg->save();
            $client->status = 'register_dob';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter your date of birth in the format dd/mm/yyyy.', 'Registration 3/10'],
                [['id' => 'no', 'title' => 'Cancel']]);

        } elseif ($client->status == 'register_dob') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->dob = $message;
            $reg->save();
            $client->status = 'register_id';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter your ID number in the format 123456789A00', 'Registration 4/10'],
                [['id' => 'no', 'title' => 'Cancel']]);

        } elseif ($client->status == 'register_id') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->id_number = $message;
            $reg->save();
            $client->status = 'register_email';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter your email address.', 'Registration 5/10'],
                [['id' => 'no', 'title' => 'Cancel']]);

        } elseif ($client->status == 'register_email') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->email = $message;
            $reg->save();
            $client->status = 'register_company';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter the name of the last company you worked at or are currently working at.', 'Registration 6/10'],
                [['id' => 'no', 'title' => 'Cancel']]);

        } elseif ($client->status == 'register_company') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->company = $message;
            $reg->save();
            $client->status = 'register_position';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter the title of the position you held at this company.', 'Registration 7/10'],
                [['id' => 'no', 'title' => 'Cancel']]);

        } elseif ($client->status == 'register_position') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->occupation = $message;
            $reg->save();
            $client->status = 'register_salary';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter the salary you made and the currency eg $500 USD or $75000 RTGS.', 'Registration 8/10'],
                [['id' => 'no', 'title' => 'Cancel']]);

        } elseif ($client->status == 'register_salary') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->salary = $message;
            $reg->save();
            $client->status = 'register_start_date';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter the day you began employment at the company in the format dd/mm/yyyy.', 'Registration 9/10'],
                [['id' => 'no', 'title' => 'Cancel']]);

        } elseif ($client->status == 'register_start_date') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->start_date = $message;
            $reg->save();
            $client->status = 'register_end_date';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter the day you end employment at the company or press the currently employed button if you are still at this company.', 'Registration 10/10'],
                [['id' => 'current', 'title' => 'Currently Employed'], ['id' => 'no', 'title' => 'Cancel']]);

        } elseif ($client->status == 'register_end_date') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->end_date = $message;
            $reg->status = 'complete';
            $reg->save();
            $client->status = 'none';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please select a payment method from the list below and we will register you with NSSA for a fee of RTGS $' . $this->registrationAmount() . ' .', 'Payment'],
                [['id' => 'reg_ecocash', 'title' => 'Ecocash'], ['id' => 'reg_telecash', 'title' => 'Telecash'], ['id' => 'reg_onewallet', 'title' => 'onewallet']]);

        } elseif ($client->status == 'apply_ssn') {

            $card = Card::where('phone', $this->phone)->first();
            if ($card) {
                $card->name = $message;
                $card->phone = $this->phone;
                $card->status = 'pending';
            } else {
                Card::create([
                    'name' => $message,
                    'phone' => $this->phone,
                    'status' => 'pending'
                ]);
                $client->status = 'apply_id';
                $client->save();
                $this->sendMsgInteractive([$this->company, 'Please send your id number in the form 123456789A10.', 'Apply'],
                    [['id' => 'no', 'title' => 'Cancel']]);
            }

        } elseif ($client->status == 'apply_id') {
            $message = str_replace('-', '', $message);
            $pattern = '/[0-9]{9}[A-Z]{1}[0-9]{2}/i';
            $pattern2 = '/[0-9]{8}[A-Z]{1}[0-9]{2}/i';
            if (preg_match($pattern, $message) or preg_match($pattern2, $message)) {
                $card = Card::where('phone', $this->phone)->first();
                $card->id_number = $message;
                $card->save();
                $client->status = 'apply_email';
                $client->save();
                $this->sendMsgInteractive([$this->company, 'Please send your email address. If you do not have one we can create one for you.', 'Apply'],
                    [['id' => 'no_email', 'title' => 'Create for me'],['id' => 'no', 'title' => 'Cancel']]);

            } else {
                $this->sendMsgInteractive([$this->company, 'Please enter a valid ID number.', 'Apply'],
                    [['id' => 'no', 'title' => 'Cancel']]);
            }

        } elseif ($client->status == 'apply_email') {

            $card = Card::where('phone', $this->phone)->first();
            $card->email = $message;
            $card->save();
            $client->status = 'apply_employer';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter the name of your current or last employer.', 'Apply'],
                [['id' => 'no', 'title' => 'Cancel']]);


        }
        elseif ($client->status == 'apply_employer') {

            $card = Card::where('phone', $this->phone)->first();
            $card->employer_name = $message;
            $card->save();
            $client->status = 'apply_employer_number';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter the phone number of your current or last employer.', 'Apply'],
                [['id' => 'no', 'title' => 'Cancel']]);


        }

        elseif ($client->status == 'apply_employer_number') {

            $card = Card::where('phone', $this->phone)->first();
            $card->employer_number = $message;
            $card->save();
            $client->status = 'none';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please select a payment method from the list below and we will register your NSSA portal access for a fee of RTGS $' . $this->cardAmount() . ' .', 'Payment'],
                [['id' => 'apply_ecocash', 'title' => 'Ecocash'], ['id' => 'apply_telecash', 'title' => 'Telecash'], ['id' => 'apply_onewallet', 'title' => 'Onewallet']]);


        }

    }

    public function handleList($arr)
    {

    }
    //23114017f80
    //631555305g50
    public function handleButton($arr)
    {
        $client = Client::where('phone', $this->phone)->first();
        if ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'check_registration') {

            $client->status = 'ID';
            $client->save();
            $this->sendMsgInteractive([$this->company,
                'Enter your ID in the form 123456789X00', 'Check Status'],
                [['id' => 'no', 'title' => 'Cancel']]);

        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'no') {
            $client->status = 'none';
            $client->save();
            $this->sendMsgText('Have a nice day!');
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'no_email') {
            $client->status = 'apply_employer';
            $client->save();
            $card = Card::where('phone',$this->phone)->first();
            $card->email = 'NO EMAIL/CREATE';
            $card->save();
            $this->sendMsgInteractive([$this->company, 'Please enter the name of your current or last employer.', 'Apply'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'ecocash') {
            $client->status = 'ecocash';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter a valid Eco Cash number', 'Payment'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'onewallet') {
            $client->status = 'onewallet';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter a valid One Wallet number', 'Payment'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'telecash') {
            $client->status = 'telecash';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter a valid Telecash number', 'Payment'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'accept') {
            $reg = Registration::where('phone', $client->phone)->first();
            $reg->terms_conditions = 'accepted';
            $reg->save();
            $this->sendMsgInteractive([$this->company, 'Welcome to Pilon Records Management Bureau, how can we help you today?', 'Click Below'],
                [['id' => 'check_registration', 'title' => 'View NSSA Status'], ['id' => 'register', 'title' => 'NSSA Registration'], ['id' => 'apply_card', 'title' => 'Portal Registration']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'register') {
            $this->sendMsgInteractive([$this->company, 'Would you like us to register you with NSSA for a fee of RTGS $' . $this->registrationAmount(), 'Get started'],
                [['id' => 'register_fname', 'title' => 'YES'], ['id' => 'no', 'title' => 'NO']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'register_fname') {
            $client->status = 'register_fname';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter your first names.', 'Registration 1/10'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'current') {
            $reg = Registration::where('phone', $this->phone)->first();
            $reg->end_date = 'NA/Currently Employed';
            $reg->status = 'complete';
            $reg->save();
            $client->status = 'register_complete';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please select a payment method from the list below and we will register you with NSSA for a fee of RTGS $' . $this->registrationAmount() . ' .', 'Payment'],
                [['id' => 'reg_ecocash', 'title' => 'Ecocash'], ['id' => 'reg_telecash', 'title' => 'Telecash'], ['id' => 'reg_onewallet', 'title' => 'onewallet']]);

        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'reg_ecocash') {
            $client->status = 'reg_ecocash';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter a valid Eco Cash number', 'Payment'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'reg_onewallet') {
            $client->status = 'reg_onewallet';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter a valid One Wallet number', 'Payment'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'reg_telecash') {
            $client->status = 'reg_telecash';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter a valid Telecash number', 'Payment'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'apply_ecocash') {
            $client->status = 'apply_ecocash';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter a valid Eco Cash number', 'Payment'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'apply_onewallet') {
            $client->status = 'apply_onewallet';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter a valid One Wallet number', 'Payment'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'apply_telecash') {
            $client->status = 'apply_telecash';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter a valid Telecash number', 'Payment'],
                [['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'apply_card') {
            $client->status = 'apply_card_ssn';
            $client->save();
            $this->sendMsgInteractive([$this->company, '*Disclaimer* Only individuals registered with NSSA can apply for portal registration. The registration costs RTGS $' . $this->cardAmount() . '. If you are unsure whether or not you are registered with NSSA hit the check now button otherwise hit the register portal button. ', 'Apply'],
                [['id' => 'check_registration', 'title' => 'Check Now'], ['id' => 'apply_card_ssn', 'title' => 'Register Portal'], ['id' => 'no', 'title' => 'Cancel']]);
        } elseif ($arr['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'] == 'apply_card_ssn') {
            $client->status = 'apply_ssn';
            $client->save();
            $this->sendMsgInteractive([$this->company, 'Please enter your full name.', 'Apply'],
                [['id' => 'no', 'title' => 'Cancel']]);
        }
    }

    public function sendMsgText($textMsg)
    {
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->webhookToken()
        ];
        $body = '{
                "messaging_product": "whatsapp",
                "preview_url": false,
                "recipient_type": "individual",
                "to": "' . $this->phone . '",
                "type": "text",
                "text": {
                    "body": "' . $textMsg . '"
                }
            }';

        $request = new \GuzzleHttp\Psr7\Request('POST', 'https://graph.facebook.com/v13.0/' . $this->webhookId() . '/messages', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }

    public function sendMsgText2($phone, $textMsg)
    {
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->webhookToken()
        ];
        $body = '{
                "messaging_product": "whatsapp",
                "preview_url": false,
                "recipient_type": "individual",
                "to": "' . $phone . '",
                "type": "text",
                "text": {
                    "body": "' . $textMsg . '"
                }
            }';

        $request = new \GuzzleHttp\Psr7\Request('POST', 'https://graph.facebook.com/v13.0/' . $this->webhookId() . '/messages', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }

    public function sendMsgInteractive($text, $buttons)
    {
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->webhookToken()
        ];
        $buttonJson = '';
        foreach ($buttons as $button) {
            $buttonJson .= '{
                          "type": "reply",
                          "reply": {
                            "id": "' . $button['id'] . '",
                            "title": "' . $button['title'] . '"
                          }
                        },';
        }
//        $fptr = fopen('myfile5.txt', 'w');
//        fwrite($fptr, $buttonJson);
//        fclose($fptr);
        $body = '{
                  "recipient_type": "individual",
                  "messaging_product": "whatsapp",
                  "to": "' . $this->phone . '",
                  "type": "interactive",
                  "interactive": {
                    "type": "button",
                    "header": {
                      "type": "text",
                      "text": "' . $text[0] . '"
                    },
                    "body": {
                      "text": "' . $text[1] . '"
                    },
                    "footer": {
                      "text": "' . $text[2] . '"
                    },
                    "action": {
                      "buttons": [
                        ' . $buttonJson . '
                      ]
                    }
                  }
                }';
        $request = new \GuzzleHttp\Psr7\Request('POST', 'https://graph.facebook.com/v14.0/' . $this->webhookId() . '/messages', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }

    public function retrieveMediaUrl($id)
    {


        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->webhookToken()
        ];

        $request = new \GuzzleHttp\Psr7\Request('GET', 'https://graph.facebook.com/v14.0/' . $id, $headers, '');
        $res = $client->sendAsync($request)->wait();
        $mediaArray = json_decode($res->getBody(), true);
        return $mediaArray['url'];


    }


    public function downloadMedia($url, $name)
    {
        $fptr = fopen('myfilex.txt', 'w');
        fwrite($fptr, $url);
        fclose($fptr);
        $card = Card::where('phone', $this->phone)->latest()->first();

        $client = new \GuzzleHttp\Client();
        if (!(file_exists('clients/' . $card->SSN . '/'))) {
            mkdir('clients/' . $card->SSN, 0755, true);
        }

        $card = Card::where('phone', $this->phone)->latest()->first();

        $resource = fopen('clients/' . $card->SSN . '/' . $name . '.jpg', 'w');

        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->webhookToken(),
                'Cache-Control' => 'no-cache',
                'Content-Type' => 'application/jpeg'
            ],
            'sink' => $resource,
        ]);
        fclose($resource);

    }

}
