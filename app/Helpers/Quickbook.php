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
use App\Models\payment;
use Session;
use DB;

class Quickbook
{

    public static function connectQucikBook()
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
        $dataService->throwExceptionOnError(true);

        return $dataService;
    }


    public static function createInvoice($paymentType)
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
        $paymentDetails = Payment::where('id', Session::get('paymentId'))->first();
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
            $customer = $dataService->Add($customer);
        }

        // $item = $dataService->Query("select * from Item");
        $productObj = $dataService->Query("select * from Item Where Name='Concrete'");
        $updatItem = $dataService->FindbyId('Item', $productObj[0]->Id);
        $apply = DB::table('applications')
            ->where('destination_id', '=', Session::get('myproduct_id'))
            ->where('client_id', '=', Auth::id())
            ->first();
        $unitPrice = 0;
        $paidAmount = 0;
        $tax = 0;

        // if ($paymentDetails->payment_type ==  'Full-Outstanding Payment') {
        //     $unitPrice = $apply->total_price - $apply->total_vat;
        //     $paidAmount = $paymentDetails->total_paid;
        //     $tax = $apply->total_vat;
        // } else {
            if ($paymentType == 'First Payment') {
                $unitPrice = $apply->first_payment_price - $apply->first_payment_vat;
                $paidAmount = $apply->first_payment_paid;
                $tax = $apply->first_payment_vat;
            } else if ($paymentType == 'Second Payment') {
                $unitPrice = $apply->second_payment_price - $apply->second_payment_vat;
                $paidAmount = $apply->first_payment_paid;
                $tax = $apply->second_payment_vat;
            } else if ($paymentType == 'Third Payment') {
                $unitPrice = $apply->third_payment_price - $apply->third_payment_vat;
                $paidAmount = $apply->third_payment_paid;
                $tax = $apply->third_payment_vat;
            }
        // }

        $productChange = [
            'UnitPrice' => $unitPrice,
            'Taxable' => true,
            'SalesTaxIncluded' => 200
        ];
        if ($productObj) {
            $theResourceObj = Item::update($updatItem, $productChange);
            $dataService->Update($theResourceObj);
        }

        $coupon = DB::table('coupons')
            ->where('location', '=', $apply->embassy_country)
            ->where('employee_id', '=', Session::get('myproduct_id'))
            ->where('active_from', '<=', date('Y-m-d'))
            ->where('active_until', '>=', date('Y-m-d'))
            ->where('active', '=', 1)
            ->first();

        if ($paymentDetails->invoice_no && $paymentDetails->invoice_id) {
            $oldInvoice = $dataService->FindById("Invoice", $paymentDetails->invoice_id);
            $invoiceChange = [
                "Deposit" => $paidAmount,
            ];
            $theInvoiceObj = Invoice::update($oldInvoice, $invoiceChange);
            $invoiceData = $dataService->Update($theInvoiceObj);
        } else {
            if ($paymentDetails->payment_type ==  'Full-Outstanding Payment') {
                $theResourceObj = Invoice::create([
                    "Line" => [
                        [
                            "Amount" => $unitPrice,
                            "DetailType" => 'SalesItemLineDetail',
                            'SalesItemLineDetail' => [
                                "ItemRef" => [
                                    "value" => $productObj[0]->Id,
                                    "name" => $updatItem->Name,
                                    "Description" => $updatItem->Description
                                ],
                                "TaxCodeRef" => [
                                    "value" => "Tax"
                                ],
                                'UnitPrice' => $unitPrice,
                                'Qty' => 1.0
                            ],

                        ]
                    ],
                    "Line" => [
                        [
                            "Amount" => $unitPrice,
                            "DetailType" => 'SalesItemLineDetail',
                            'SalesItemLineDetail' => [
                                "ItemRef" => [
                                    "value" => $productObj[0]->Id,
                                    "name" => $updatItem->Name,
                                    "Description" => $updatItem->Description
                                ],
                                "TaxCodeRef" => [
                                    "value" => "Tax"
                                ],
                                'UnitPrice' => $unitPrice,
                                'Qty' => 1.0
                            ],

                        ]
                    ],
                    "Line" => [
                        [
                            "Amount" => $unitPrice,
                            "DetailType" => 'SalesItemLineDetail',
                            'SalesItemLineDetail' => [
                                "ItemRef" => [
                                    "value" => $productObj[0]->Id,
                                    "name" => $updatItem->Name,
                                    "Description" => $updatItem->Description
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
                    "TxnTaxDetail" => [
                        "TxnTaxCodeRef" => [
                            "value" => "5",  // tax rate
                            "name" => "VAT" // tax rate name
                        ],
                        "TotalTax" => $tax,
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
            } else {
                if ($coupon) {
                    $theResourceObj = Invoice::create([
                        "Line" => [
                            [
                                "Amount" => $unitPrice,
                                "DetailType" => 'SalesItemLineDetail',
                                'SalesItemLineDetail' => [
                                    "ItemRef" => [
                                        "value" => $productObj[0]->Id,
                                        "name" => $updatItem->Name,
                                        "Description" => $updatItem->Description
                                    ],
                                    "TaxCodeRef" => [
                                        "value" => "Tax"
                                    ],
                                    'UnitPrice' => $unitPrice,
                                    'Qty' => 1.0
                                ],

                            ], [

                                "DetailType" => "DiscountLineDetail",
                                "DiscountLineDetail"  => [
                                    "PercentBased" => true,
                                    "DiscountPercent" => $coupon->amount
                                ]

                            ]
                        ],
                        "Deposit" => $paidAmount,
                        "TxnTaxDetail" => [
                            "TxnTaxCodeRef" => [
                                "value" => "5",  // tax rate
                                "name" => "VAT" // tax rate name
                            ],
                            "TotalTax" => $tax,
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
                } else {
                    $theResourceObj = Invoice::create([
                        "Line" => [
                            [
                                "Amount" => $unitPrice,
                                "DetailType" => 'SalesItemLineDetail',
                                'SalesItemLineDetail' => [
                                    "ItemRef" => [
                                        "value" => $productObj[0]->Id,
                                        "name" => $updatItem->Name,
                                        "Description" => $updatItem->Description
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
                        "TxnTaxDetail" => [
                            "TxnTaxCodeRef" => [
                                "value" => "5",  // tax rate
                                "name" => "VAT" // tax rate name
                            ],
                            "TotalTax" => $tax,
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
                }
            }
            $invoiceData = $dataService->Add($theResourceObj);
            $paymentDetails->invoice_no = $invoiceData->DocNumber;
            $paymentDetails->invoice_id = $invoiceData->Id;
            $paymentDetails->save();
        }
        if ($error) {
            echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
            echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
            echo "The Response message is: " . $error->getResponseBody() . "\n";
            return $error->getResponseBody();
        } else {
            return  true;
        }
    }
}
