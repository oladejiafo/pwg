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
            'ClientID' => "AB5mLL6k7Ls4UUZnk5kZ957ExGbszzam5Oelx2hi8K9VdqO4Ac",
            'ClientSecret' => "pcEIASrqn7ly0J23i7dedorked8ZiQPeEHJDRfPh",
            'accessTokenKey' =>
            'eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..19GAF5ZHQHFy0RI7LF7YHQ.VVSUbvUI2RhmIj1xrYOCbwUfOdBaeGOy6CRRZKfaD2S1DebfJ-o7e2cubMlZi8XW311mznp09-PbvLpyW6WokZ769fHbY-dmLNgRKEZIS7xF7f9TYhE-1jTPm5XndSvCAA8bMhjyz_Z9WcPD3iZHceW7sGTYlof9EOjrLvpxjMze5axa_7ksyGbHppw3YkRO35-fK6nVBN6ghX64XR9FF_L4LGUSaDUbzteXX0j_kj2ELqX-45S5f39w_xnsWoTAKKbsV9gbn4xRe65LFGQR5rWj0ttJrFuPal2PbHzSR8_LfNb12ANnXT3NtQNdD-GQXCYmnnyR7N84Q57LA5Hy3arPEcT-aKegjTuHQw81ZDRZfx407qpwzY4e3dmeoJJbOGcfQLtSwzJdS6uzI43ZVqdaKObgar2q-nBJA1kRKG_cUQmwp-icIigrCMPGD-DIb0tXSPeQcwz_JJS-UdB7ddWnedV_IEImLEUxQkG5iOIJTZu8mjR3o8Eu99Xb_wPpCTfLxwZ8-_6jzXf5p__f11QGmWVlju22NYMftpLAUullasglSAZI2d7TAU2IY3D3GhKMRx71Re7vcQ13wRzs4fzebYhVL7ad75sD2xnr-5_K7ZwiRLzXskFJYEyQOWnOS92LuqZ8Kf1g_P6cEFUr7Ul0W33Iop-BWt2CUH-IBu-_OGBjyTVJfqSrgoUz23pAho4YhE_g_CcPg_OEwU-B1JLEnevX2-WGBiLm2HUj0NjvsGF-v_mG7VryAjXAUVDn.KeO8zhYQlsMVsNi79sNyVA',
            'refreshTokenKey' => "AB11672917222Gr7RV9Dhy9LEu0ThhBf0pcqfcu2qIWKZuwDrn",
            'QBORealmID' => "4620816365244502690",
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
                "Title" => (Auth::user()->sex == 'MALE') ? 'Mr. ' : 'Miss ',
                "GivenName" =>  Auth::user()->name,
                "MiddleName" =>  Auth::user()->middle_name,
                "FamilyName" =>  Auth::user()->sur_name,
                "FullyQualifiedName" =>  Auth::user()->name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->sur_name,
                "CompanyName" =>  Auth::user()->company_name,
                "DisplayName" =>   Auth::user()->name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->sur_name,
                "PrimaryPhone" =>  [
                    "FreeFormNumber" => Auth::user()->phone_number
                ],
                "PrimaryEmailAddr" =>  [
                    "Address" => Auth::user()->email
                ]
            ]);
            $resultingCustomerObj = $dataService->Add($customer);
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
            $paidAmount = $apply->first_payment_paid;
            $tax = $apply->first_payment_vat;
        } else if ($paymentType == 'Second Payment') {
            $unitPrice = $apply->second_payment_price - $apply->second_payment_vat;
            $paidAmount = $apply->second_payment_paid ;
            $tax = $apply->second_payment_vat;
        } else if ($paymentType == 'Third Payment') {
            $unitPrice = $apply->third_payment_price - $apply->third_payment_vat;
            $paidAmount = $apply->third_payment_paid;
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
        // dd($taxes);
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
                            "value" => "NON"
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
                "value" => $customer[0]->Id
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
