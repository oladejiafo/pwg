<?php

namespace App\Helpers;

use Exception;
use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Item;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;


class Quickbook
{

    public function connectQucikBook()
    {
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => config('app.client_id'),
            'ClientSecret' =>  config('app.client_secret'),
            'RedirectURI' => config('app.oauth_redirect_uri'),
            'scope' => config('app.oauth_scope'),
            'baseUrl' => "development"
        ));
        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

        return $authUrl;
    }

    public function createInvoice($paymentType)
    {
        $result = self::invoiceAndBilling($paymentType);
        dd($result);
    }



    public static function invoiceAndBilling($paymentType)
    {
        
        // try {

        //     $token = 'eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..WcYelUdJq0REiCh4VkYUFQ.pTqg5dex27bbcVqjliD3rELeticpT6JYUQXRU5ubp3oEyOjbJoqIt9HmMwaeuMXfx6UzDK5JuqkYQX4SoZKx7Wnn3SgdflekARUQTiXYD4YLkK1IVEr1VJI_0-a2InpXZG6uadCH_tKfn7prE75cWEeFx1jJo_T8w1OGIoFyk_yO5VIwnQmEbv3LMxTAgGh3KU-qF1-aYlAQXn3BhVKCSo4NXbYa1FVxjHS1Mspgk7dblUVFRDvZKG-nwemm0BMOcbc2Tmi4aMuhI3d13vlmbON3AYiNBDYN-rawRqZC-F6fxIT2JI-kNzWr5gOtuDckeENmB5Dq-kL2wO0-RH-NzXlOgzrw1YkxUI0lnJ9sKL2YEI3JG8BJQqFuV-zc21cxSktvbZpl1Q7B6K-pn3OHc7JacYs1UFTiJhstPd0bY3iueZRm4PpFwr19rWU4P09cxNiPh5OCfLxAN59zQTV_W01SXr2RkZt4vsrE-ukzfTMFlpTSQUH0WAhrpIbJw74PVDdYIKhUu9rp5ZfKHADMqVnPqL1c0-GkMl3yHJlkusYbeDXMKGNgUBsDhxaVein_OMnBWHgw5PnbLQh-cymgAqwA2YaueIqMjT0wq0MyAolCLImzhXSxrrovl2T5spo5Wrh2eVmqa6ixv5cOecXB4YEAihpcvIT0DLxw3BwZcKQk2h7xDnQJtSRCn7ngKGL4oo2yDlPwJ1DSN6Xh3-__ZDaH7cKqUZS3cqOZNLPHURBHoRytv-QszO60tXa2R73_.CoLeVJBP_9zH5MlfyIowjg';
        //     $selectQ = "select * from Customer Where PrimaryEmailAddr= 'evilkingw@myemail.com'";
        //     $client = new Client();
        //     $response = $client->get("https://sandbox-quickbooks.api.intuit.com/v3/company/4620816365244502690/query?query=" .$selectQ, [
        //         'headers' => [
        //             'Authorization' => 'Bearer eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..WcYelUdJq0REiCh4VkYUFQ.pTqg5dex27bbcVqjliD3rELeticpT6JYUQXRU5ubp3oEyOjbJoqIt9HmMwaeuMXfx6UzDK5JuqkYQX4SoZKx7Wnn3SgdflekARUQTiXYD4YLkK1IVEr1VJI_0-a2InpXZG6uadCH_tKfn7prE75cWEeFx1jJo_T8w1OGIoFyk_yO5VIwnQmEbv3LMxTAgGh3KU-qF1-aYlAQXn3BhVKCSo4NXbYa1FVxjHS1Mspgk7dblUVFRDvZKG-nwemm0BMOcbc2Tmi4aMuhI3d13vlmbON3AYiNBDYN-rawRqZC-F6fxIT2JI-kNzWr5gOtuDckeENmB5Dq-kL2wO0-RH-NzXlOgzrw1YkxUI0lnJ9sKL2YEI3JG8BJQqFuV-zc21cxSktvbZpl1Q7B6K-pn3OHc7JacYs1UFTiJhstPd0bY3iueZRm4PpFwr19rWU4P09cxNiPh5OCfLxAN59zQTV_W01SXr2RkZt4vsrE-ukzfTMFlpTSQUH0WAhrpIbJw74PVDdYIKhUu9rp5ZfKHADMqVnPqL1c0-GkMl3yHJlkusYbeDXMKGNgUBsDhxaVein_OMnBWHgw5PnbLQh-cymgAqwA2YaueIqMjT0wq0MyAolCLImzhXSxrrovl2T5spo5Wrh2eVmqa6ixv5cOecXB4YEAihpcvIT0DLxw3BwZcKQk2h7xDnQJtSRCn7ngKGL4oo2yDlPwJ1DSN6Xh3-__ZDaH7cKqUZS3cqOZNLPHURBHoRytv-QszO60tXa2R73_.CoLeVJBP_9zH5MlfyIowjg',
        //             'Accept' => 'application/json',
        //             'Content-type' => 'text/plain'
        //         ],
        //     ]);
        //     dd($response);

        // } catch (Exception $e) {
        //     dd($e->getMessage());
        // }
        // die;

        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => "AB5mLL6k7Ls4UUZnk5kZ957ExGbszzam5Oelx2hi8K9VdqO4Ac",
            'ClientSecret' => "pcEIASrqn7ly0J23i7dedorked8ZiQPeEHJDRfPh",
            'accessTokenKey' =>
            'eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..OKs2WEIEASLQoLLqu8WaUA.bhtQlN-FH5p0lEOucII0ePkuFBabWPVs1TQbqAHuVQH-kY-dFMieYe0E0-K9ry57zK0i6xtcMMTFH4Q99AVxVrK55KHxKR4mdL6jjd-X9JKj-aL0f8q50DSxnAtIZ3NQoqkfhSDiboqQwlOi9SSmGjBZ7uzPbTpg7NhzT4Ys7WToqSaNJA_QRVknbeWCCe5UZk-IKrQThKU9me2zEIfrpLaaBlUBBKzEvHgKGPwGDPw2KR6ITZTU-SWsN7nlSDt2YXtvZ4phZinWsn_mpVa2ZtWtZKWiWwOyZMS1USHpjze9NwxCfjYihHcZRyEoOoAWrNfuE3Jm5hfp5ifADtGcU-JchwdCG0eFlbjAwCx1z6ut69SqmMTAKNVCUvB25Rwn3AB1RpEF3psNihopB7M8dkX5ICyoCwZPFom9y1Zd4P4N5Qf5qED2dhax9vS-XcM-NVpj2RKuZNTBS8a27Xi2oWvj9gMuxoUulGhhb369zW6dfvZkZGTHIDpZf5xRZTS6oSEZLpbvTpsbLZ9FBVDo1IW0M2xKvOJwtBaQONGZuhSWU6dmbIb6cvK7asqlCgSH5DOKgV6ZhqvXcRZ8TgFQ4AwLTjRbWjavkE5eJ6VaspPXi_lWvAHNUXyhLY7d7INa2Yw0CMbv8ZVjPoMgoWrGqxKWLhg5p-VGN92u0naZg6vRr3Ye3dYFzWdBb829vWDGxfOrC4c9vbobm222ayBHQnQJQ8zQr25UDlM_t4jhlvkjPTinr1Qe3pd63LBhFo9T.xBPZeI7EHGG-s0TleyIx6w',
            'refreshTokenKey' => "AB11672661489rn7jQkKLPKjs7Gvn9TQmZXLgCVDTaH2Hrzi5f",
            'QBORealmID' => "4620816365244502690",
            'baseUrl' => "Development"
        ));
        $dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");
        $customer = $dataService->Query("select * from Customer Where PrimaryEmailAddr='".Auth::user()->email."'");
        $dataService->throwExceptionOnError(true);
        $error = $dataService->getLastError();
        if($customer){
            
        } else {
            $customerObj = Customer::create([
               "Notes" =>  "Applicant",
               "Title"=>  (Auth::user()->sex == 'MALE') ? 'Mr. ': 'Miss ',
               "GivenName"=>  Auth::user()->name,
               "MiddleName"=>  Auth::user()->middle_name,
               "FamilyName"=>  Auth::user()->sur_name,
               "FullyQualifiedName"=>  Auth::user()->name .' '. Auth::user()->middle_name .' '. Auth::user()->sur_name,
               "CompanyName"=>  Auth::user()->company_name,
               "DisplayName"=>   Auth::user()->name .' '. Auth::user()->middle_name .' '. Auth::user()->sur_name,
               "PrimaryPhone"=>  [
                   "FreeFormNumber"=> Auth::user()->phone_number
               ],
               "PrimaryEmailAddr"=>  [
                   "Address" => Auth::user()->email
               ]
              ]);
              $resultingCustomerObj = $dataService->Add($customerObj);
        }
        $productName = Product::find(Session::get('myproduct_id'));
        $product = $dataService->Query("select * from Item Where Name='".$paymentType.'-'.$productName."'");

        // dd($product);
        // die;
        $theResourceObj = Invoice::create([
            "Line" => [
                [
                    "Amount" => 100.00,
                    "DetailType" => "SalesItemLineDetail",
                    "SalesItemLineDetail" => [
                        "ItemRef" => [
                            "value" => 20,
                            "name" => "Hours"
                        ],
                        'UnitPrice' => 100.00,
                        'Qty' => 1.0
                    ]
                ]
            ],
            "CustomerRef" => [
                "value" => 59
            ],
            "BillEmail" => [
                "Address" => "Familiystore@intuit.com"
            ],
            "BillEmailCc" => [
                "Address" => "a@intuit.com"
            ],
            "BillEmailBcc" => [
                "Address" => "v@intuit.com"
            ]
        ]);
        $resultingObj = $dataService->Add($theResourceObj);


        $error = $dataService->getLastError();
        if ($error) {
            echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
            echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
            echo "The Response message is: " . $error->getResponseBody() . "\n";
            return $error->getResponseBody();
        } else {
            // echo "Created Id={$resultingObj->Id}. Reconstructed response body:\n\n";
            // $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingObj, $urlResource);
            // echo $xmlBody . "\n";
            echo "Created Id={$theResourceObj->Id}. Reconstructed response body:\n\n";
            $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($theResourceObj, $urlResource);
            echo $xmlBody . "\n";
            return $xmlBody;
        }
    }
}
