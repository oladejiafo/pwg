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
use App\Models\Product;
use Session;
use DB;

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
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => config('app.client_id'),
            'ClientSecret' => config('app.client_secret'),
            'accessTokenKey' => config('app.accessTokenKey'),
            'refreshTokenKey' => config('app.refreshTokenKey'),
            'QBORealmID' => config('app.QBORealmID'),
            'baseUrl' => "Development"
        ));
        $dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");
        $customer = $dataService->Query("select * from Customer Where PrimaryEmailAddr='" . Auth::user()->email . "'");
        $dataService->throwExceptionOnError(true);
        $error = $dataService->getLastError();
        if ($customer) {
        } else {
            $customer = Customer::create([
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
            $customer = $dataService->Add($customer);
        }

        $item = $dataService->Query("select * from Item ");
        $productObj = $dataService->Query("select * from Item Where Name='Concrete'");
        // dd($productObj);
        // dd($productObj[0]->Id);
        $updatItem = $dataService->FindbyId('Item', $productObj[0]->Id);

        $apply = DB::table('applications')
            ->where('destination_id', '=', Session::get('myproduct_id'))
            ->where('client_id', '=', Auth::id())
            ->first();
        $unitPrice = 0;
        $paidAmount = 0;
        $tax = 0;
        if ($paymentType == 'First Payment') {
            $unitPrice = $apply->first_payment_price - $apply->first_payment_vat;
            // $paidAmount = $apply->first_payment_paid - $apply->first_payment_vat;
            $paidAmount = $apply->first_payment_paid;
            $tax = $apply->first_payment_vat;
        } else if ($paymentType == 'Second Payment') {
            $unitPrice = $apply->second_payment_price - $apply->second_payment_vat;
            // $paidAmount = $apply->second_payment_paid - $apply->second_payment_vat;
            $paidAmount = $apply->first_payment_paid;
            $tax = $apply->second_payment_vat;
        } else if ($paymentType == 'Third Payment') {
            $unitPrice = $apply->third_payment_price - $apply->third_payment_vat;
            // $paidAmount = $apply->third_payment_paid - $apply->third_payment_vat;
            $paidAmount = $apply->first_payment_paid;
            $tax = $apply->third_payment_vat;
        } 
        // dd($unitPrice, $paidAmount);
        $productChange = [
            'UnitPrice' => $unitPrice,
            'Taxable' => true,
            'SalesTaxIncluded' => 200
        ];
        if ($productObj) {
            $theResourceObj = Item::update($updatItem, $productChange);
            $dataService->Update($theResourceObj);
        }
        $invoice = $dataService->Query("select * from Invoice");
        $taxes =  $dataService->Query("select * From TaxCode");
        // dd($invoice[0]);
        $theResourceObj = Invoice::create([
            "Line" => [
                [
                    "Amount" => $unitPrice,
                    "DetailType" => 'SalesItemLineDetail',
                    'SalesItemLineDetail' => [
                        "ItemRef" => [
                            "value" => $productObj[0]->Id,
                            "name" => $updatItem->Name
                        ],
                        "TaxCodeRef" => [
                            "value" => "Tax"
                        ], 
                        'UnitPrice' => $unitPrice,
                        'Qty' => 1.0
                    ],
                    
                ]
            ],
            "Deposit" => $paidAmount,
            // "Balance" => $paidAmount,
            "TxnTaxDetail" => [
                "TxnTaxCodeRef" => [
                  "value" => "5",  // tax rate
                  "name" => "VAT" // tax rate name
                ], 
                "TotalTax" => $tax, 
                // "TaxLine" => [
                //   [
                //     "DetailType" => "TaxLineDetail", 
                //     "TaxLineDetail" => [
                //       "TaxPercent" => 5, 
                //       "TaxRateRef" => [
                //         "value" => "3"
                //       ], 
                //       "PercentBased" => true
                //     ]
                //   ]
                // ]
            ],
            "CustomerRef" => [
                "value" => ($customer->Id) ??  $customer[0]->Id
            ],
            "BillEmail" => [
                "Address" => Auth::user()->email
            ],
            "BillEmailCc" => [
                "Address" => "a@intuit.com"
            ],
            "BillEmailBcc" => [
                "Address" => "v@intuit.com"
            ]
        ]);
        $invoiceData = $dataService->Add($theResourceObj);
        $invoice = $dataService->FindById("Invoice", $invoiceData->Id);

        $filename = $paymentType."Invoice.pdf";
        $pdfData = $dataService->DownloadPDF($invoice, null, true);

        // Send the file to the browser.
        header('Content-Type: application/pdf');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        echo $pdfData;
        // dd($invoiceData);
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
