<?php

namespace App\Helpers;

use Exception;
use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Facades\payment;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Quickbook as QuickModel;
use App\Models\payment as PaymentDetails;
use Session;
use DB;

class Quickbook
{

    public static function connectQucikBook()
    {
        $quickbook = QuickModel::first();
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => config('app.client_id'),
            'ClientSecret' => config('app.client_secret'),
            'accessTokenKey' => $quickbook['access_token'],
            'refreshTokenKey' => $quickbook['refresh_token'],
            'QBORealmID' => config('app.QBORealmID'),
            'baseUrl' => "Development"
        ));
        $dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");
        $dataService->throwExceptionOnError(true);

        return $dataService;
    }


    public static function createInvoice($paymentType)
    {
        $dataService = self::connectQucikBook();
        $dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");
        $customer = $dataService->Query("select * from Customer Where PrimaryEmailAddr='" . Auth::user()->email . "'");
        $dataService->throwExceptionOnError(true);
        $paymentDetails = PaymentDetails::where('id', Session::get('paymentId'))->first();
        $error = $dataService->getLastError();
        if ($customer) {
        } else {
            $customer = Customer::create([
                "Notes" =>  "Applicant",
                "Title" => ((Auth::user()->sex == 'MALE') ? 'Mr. ' : ((Auth::user()->sex == 'FEMALE') ? 'Miss ' : ' ')),
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

        // $payment = $dataService->Query("select * from Payment");
        $productObj = $dataService->Query("select * from Item Where Name='Concrete'");
        $updatItem = $dataService->FindbyId('Item', $productObj[0]->Id);
        $apply = DB::table('applications')
            ->select('applications.*', 'pricing_plans.total_price as planTotal', 'pricing_plans.first_payment_price as planFirstPrice', 'pricing_plans.second_payment_price as  planSecondPrice', 'pricing_plans.third_payment_price as  planThirdPrice')
            ->join('pricing_plans', 'pricing_plans.id', '=', 'applications.pricing_plan_id')
            ->where('applications.destination_id', Session::get('myproduct_id'))
            ->where('applications.client_id', Auth::id())
            ->first();
        $unitPrice = 0;
        $paidAmount = 0;
        $tax = 0;

        if ($paymentType == 'First Payment') {
            $unitPrice = $apply->first_payment_price - $apply->first_payment_vat;
            $tax = $apply->first_payment_vat;
        } else if ($paymentType == 'Second Payment') {
            $unitPrice = $apply->second_payment_price - $apply->second_payment_vat;
            $tax = $apply->second_payment_vat;
        } else if ($paymentType == 'Third Payment') {
            $unitPrice = $apply->third_payment_price - $apply->third_payment_vat;
            $tax = $apply->third_payment_vat;
        }
        $paidAmount = $paymentDetails->paid_amount;
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

        if ($paymentDetails->payment_type ==  'Full-Outstanding Payment') {
            $destination = product::find($apply->destination_id);
            $theResourceObj = Invoice::create([
                "Line" => [
                    [
                        "Description" => 'First payment',
                        "Amount" => $apply->planFirstPrice,
                        "DetailType" =>
                        "SalesItemLineDetail",
                        "SalesItemLineDetail" =>
                        [
                            "ItemRef" =>
                            [
                                "value" => 1,
                                "name" => 'First payment'
                            ],
                            'UnitPrice' => $apply->planFirstPrice,
                            'Qty' => 1.0
                        ]
                    ],
                    [
                        "Description" => 'Second Payment',
                        "Amount" => $apply->planSecondPrice,
                        "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => [
                            "ItemRef" =>
                            [
                                "value" => 2,
                                "name" => 'Second Payment'
                            ],
                            'UnitPrice' => $apply->planSecondPrice,
                            'Qty' => 1.0
                        ]
                    ],
                    [
                        "Description" => 'Third Payment',
                        "Amount" => $apply->planThirdPrice,
                        "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" =>
                        [
                            "ItemRef" =>
                            [
                                "value" => 3,
                                "name" => "Hours"
                            ],
                            'UnitPrice' => $apply->planThirdPrice,
                            'Qty' => 1.0
                        ]
                    ],
                    [
                        "DetailType" => "DiscountLineDetail",
                        "DiscountLineDetail"  => [
                            "PercentBased" => true,
                            "DiscountPercent" => $destination->full_payment_discount,
                        ]
                    ]
                ],
                "ApplyTaxAfterDiscount" => true,
                "Deposit" => $apply->total_paid,
                "TxnTaxDetail" => [
                    "TxnTaxCodeRef" => [
                        "value" => "5",  // tax rate
                        "name" => "VAT" // tax rate name
                    ],
                    "TotalTax" => $apply->total_vat,
                ],
                "PaymentRefNum" => $paymentDetails->bank_reference_no,
                "CustomerMemo" => [
                    "value" => $paymentDetails->bank_reference_no,
                ],
                "PrivateNote" => $paymentDetails->bank_reference_no,
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
            $paymentDetails->invoice_no = $invoiceData->DocNumber;
            $paymentDetails->invoice_id = $invoiceData->Id;
            $paymentDetails->save();
        } else {
            if ($paymentType == 'First Payment') {
                $firstPaymentDue = PaymentDetails::where('application_id', $apply->id)
                    ->where('payment_type', $paymentType)
                    ->where('paid_amount', '!=', null)
                    ->count();
                // dd($firstPaymentDue);
                if ($firstPaymentDue > 1) {
                    $prevInvoice  =  PaymentDetails::where('application_id', $apply->id)
                        ->where('payment_type', $paymentType)
                        ->first();
                    $paymentObj = Payment::create([

                        "TotalAmt" =>  $paymentDetails->invoice_amount,

                        "UnappliedAmt" => 0.00,

                        "CustomerRef" => ($customer->Id) ??  $customer[0]->Id,
                        "PrivateNote" => $paymentDetails->bank_reference_no,
                        "PaymentRefNum" => $paymentDetails->bank_reference_no,
                        "Line" => [

                            [

                                "Amount" => $paymentDetails->invoice_amount,

                                "LinkedTxn" => [

                                    [

                                        "TxnId" => $prevInvoice->invoice_id,

                                        "TxnType" => "Invoice"

                                    ],

                                ],

                            ]

                        ]

                    ]);
                    $resultingObj = $dataService->Add($paymentObj);
                    $paymentDetails->invoice_id = $resultingObj->Id;
                    $paymentDetails->save();
                } else {
                    self::quickBook($dataService, $coupon, $unitPrice, $productObj, $updatItem, $paidAmount, $tax, $customer, $paymentDetails);
                }
            } elseif ($paymentType == 'Second Payment' || $paymentType == 'Third Payment') {
                self::quickBook($dataService, $coupon, $unitPrice, $productObj, $updatItem, $paidAmount, $tax, $customer, $paymentDetails);
            }
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

    private static function quickBook($dataService, $coupon, $unitPrice, $productObj, $updatItem, $paidAmount, $tax, $customer, $paymentDetails)
    {
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

                    ],
                    [
                        "DetailType" => "DiscountLineDetail",
                        "DiscountLineDetail"  => [
                            "PercentBased" => true,
                            "DiscountPercent" => $coupon->amount
                        ]

                    ]
                ],
                "ApplyTaxAfterDiscount" => true,
                "Deposit" => $paidAmount,
                "TxnTaxDetail" => [
                    "TxnTaxCodeRef" => [
                        "value" => "5",  // tax rate
                        "name" => "VAT" // tax rate name
                    ],
                    "TotalTax" => $tax,
                ],
                "PaymentRefNum" => $paymentDetails->bank_reference_no,
                "CustomerMemo" => [
                    "value" => $paymentDetails->bank_reference_no,
                ],
                "PrivateNote" => $paymentDetails->bank_reference_no,
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
                        "Description" => $updatItem->Description,
                        "Amount" => $unitPrice,
                        "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => [
                            "ItemRef" => [
                                "value" => $productObj[0]->Id,
                                "name" => $updatItem->Name
                            ],
                            "TaxCodeRef" => [
                                "value" => "Tax"
                            ],
                            'UnitPrice' => $unitPrice,
                            'Qty' => 1.0
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
                "PaymentRefNum" => $paymentDetails->bank_reference_no,

                "CustomerRef" => [
                    "value" => ($customer->Id) ??  $customer[0]->Id
                ],
                "CustomerMemo" => [
                    "value" => $paymentDetails->bank_reference_no,
                ],
                "PrivateNote" => $paymentDetails->bank_reference_no,
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
        $invoiceData = $dataService->Add($theResourceObj);
        $paymentDetails->invoice_no = $invoiceData->DocNumber;
        $paymentDetails->invoice_id = $invoiceData->Id;
        $paymentDetails->save();
    }
}
