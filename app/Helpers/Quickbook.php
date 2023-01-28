<?php

namespace App\Helpers;

use Exception;
use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Facades\payment as QuickbookPayment;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Item;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Helpers\users as UserHelper;
use App\Models\User;
use App\Models\Product;
use App\Models\Applicant;
use App\Models\Quickbook as QuickModel;
use App\Models\payment as PaymentDetails;
use App\Constant;
use Carbon\Carbon;
use Session;
use DB;
use App\Mail\ExceptionMail;
use Mail;
use PhpParser\Node\Stmt\Switch_;

class Quickbook
{

    public static function getAuthUrl()
    {
        $quickbook = QuickModel::first();

        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.client_id') : config('services.quickbook.client_id'),
            'ClientSecret' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.client_secret') : config('services.quickbook.client_secret'),
            'accessTokenKey' => $quickbook['access_token'],
            'refreshTokenKey' => $quickbook['refresh_token'],
            'QBORealmID' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.QBORealmID') : config('services.quickbook.QBORealmID'),
            'baseUrl' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? "Development" : "production"
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();
        return $authUrl;
    }

    public static function connectQucikBook()
    {
        $quickbook = QuickModel::first();
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.client_id') : config('services.quickbook.client_id'),
            'ClientSecret' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.client_secret') : config('services.quickbook.client_secret'),
            'accessTokenKey' => $quickbook['access_token'],
            'refreshTokenKey' => $quickbook['refresh_token'],
            'QBORealmID' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.QBORealmID') : config('services.quickbook.QBORealmID'),
            'baseUrl' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? "Development" : "production"
        ));
        $dataService->setLogLocation(public_path() . "/QBLog");
        $dataService->throwExceptionOnError(true);
        return $dataService;
    }


    public static function createInvoice($paymentType)
    {
        try {
            $dataService = self::connectQucikBook();

            $dataService->setLogLocation(public_path() . "/QBLog");
            $customer = $dataService->Query("select * from Customer Where PrimaryEmailAddr='" . Auth::user()->email . "'");
            $dataService->throwExceptionOnError(true);
            $paymentDetails = PaymentDetails::where('id', Session::get('paymentId'))->first();
            $error = $dataService->getLastError();
            if ($customer) {
                $customerExist = $dataService->FindbyId('Customer', $customer[0]->Id);
                if (Auth::user()->middle_name || Auth::user()->sur_name) {
                    $customeNameDetails = [
                        'GivenName' => Auth::user()->name,
                        'MiddleName' => Auth::user()->middle_name,
                        'FamilyName' => Auth::user()->sur_name,
                        "FullyQualifiedName" =>  Auth::user()->name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->sur_name,
                        'DisplayName'  => Auth::user()->name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->sur_name,
                    ];
                    $thecustomerResourceObj = Customer::update($customerExist, $customeNameDetails);
                    $dataService->Update($thecustomerResourceObj);
                }
            } else {
                $customerExist = $dataService->Query("select * from Customer Where GivenName='" . Auth::user()->name . "'");
                $customer = Customer::create([
                    "Notes" =>  "Applicant",
                    "Title" => ((Auth::user()->sex == 'MALE') ? 'Mr. ' : ((Auth::user()->sex == 'FEMALE') ? 'Miss ' : '')),
                    "GivenName" => ($customerExist) ? Auth::user()->name . ' ' . UserHelper::getAlphabeticRandomString() : Auth::user()->name,
                    "MiddleName" =>  Auth::user()->middle_name,
                    "FamilyName" => Auth::user()->sur_name,
                    "FullyQualifiedName" => ($customerExist) ? Auth::user()->name . ' ' . UserHelper::getAlphabeticRandomString() : Auth::user()->name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->sur_name,
                    "CompanyName" =>  Auth::user()->company_name,
                    "DisplayName" => ($customerExist) ? Auth::user()->name . ' ' . UserHelper::getAlphabeticRandomString() : Auth::user()->name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->sur_name,
                    "PrimaryPhone" =>  [
                        "FreeFormNumber" => Auth::user()->phone_number
                    ],
                    "PrimaryEmailAddr" =>  [
                        "Address" => Auth::user()->email
                    ]
                ]);
                $customer = $dataService->Add($customer);
            }
            $apply = DB::table('applications')
                ->select('applications.*', 'pricing_plans.total_price as planTotal', 'pricing_plans.first_payment_price as planFirstPrice', 'pricing_plans.submission_payment_price as  planSecondPrice', 'pricing_plans.second_payment_price as  planThirdPrice')
                ->join('pricing_plans', 'pricing_plans.id', '=', 'applications.pricing_plan_id')
                ->where('applications.destination_id', Session::get('myproduct_id'))
                ->where('applications.client_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->first();
            $destination = product::find($apply->destination_id);
            $unitPrice = 0;
            $paidAmount = 0;
            $tax = 0;
            if ($paymentType == 'First Payment') {
                $unitPrice = $apply->planFirstPrice;
                $tax = $apply->first_payment_vat;
            } else if ($paymentType == 'Second Payment') {
                $unitPrice = $apply->planSecondPrice;
                $tax = $apply->submission_payment_vat;
            } else if ($paymentType == 'Third Payment') {
                $unitPrice = $apply->planThirdPrice;
                $tax = $apply->second_payment_vat;
            }
            $destinationName = strtolower($destination->name);
            $productObj = null;
            switch ($destinationName) {
                case Constant::poland:
                    if ($paymentType == 'First Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Photocopy Cv, Passport - Poland'");
                    } else if ($paymentType == 'Second Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Typing for Visa Application - Poland'");
                    } else if ($paymentType == 'Third Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Travel Documents Submission - Poland'");
                    }
                    if ($paymentDetails->payment_type ==  'Full-Outstanding Payment') {
                        $FullFirstPayment = $dataService->Query("select * from Item Where Name='Photocopy Cv, Passport - Poland'");
                        $FullFirstPaymentProduct = $dataService->FindbyId('Item', $FullFirstPayment[0]->Id);
                        $FullSecondPayment = $dataService->Query("select * from Item Where Name='Typing for Visa Application - Poland'");
                        $FullSecondPaymentProduct = $dataService->FindbyId('Item', $FullSecondPayment[0]->Id);
                        $FullThirdPayment = $dataService->Query("select * from Item Where Name='Travel Documents Submission - Poland'");
                        $FullThirdPaymentProduct = $dataService->FindbyId('Item', $FullThirdPayment[0]->Id);
                    } else {
                        if($productObj[0]) {
                            $updatItem = $dataService->FindbyId('Item', $productObj[0]->Id);
                        } else {
                            $updatItem = self::createNewItem($paymentDetails, $destinationName, $unitPrice, $dataService);
                        }
                    }
                    break;
                case Constant::czech:
                    if ($paymentType == 'First Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Photocopy - CV, Passport - Czech Republic'");
                    } else if ($paymentType == 'Second Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Typing for Visa Application - Czech Republic'");
                    } else if ($paymentType == 'Third Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Travel Documents Submission - Czech Republic'");
                    }
                    if ($paymentDetails->payment_type ==  'Full-Outstanding Payment') {
                        $FullFirstPayment = $dataService->Query("select * from Item Where Name='Photocopy - CV, Passport - Czech Republic'");
                        $FullFirstPaymentProduct = $dataService->FindbyId('Item', $FullFirstPayment[0]->Id);
                        $FullSecondPayment = $dataService->Query("select * from Item Where Name='Typing for Visa Application - Czech Republic'");
                        $FullSecondPaymentProduct = $dataService->FindbyId('Item', $FullSecondPayment[0]->Id);
                        $FullThirdPayment = $dataService->Query("select * from Item Where Name='Travel Documents Submission - Czech Republic'");
                        $FullThirdPaymentProduct = $dataService->FindbyId('Item', $FullThirdPayment[0]->Id);
                    } else {
                        if($productObj[0]) {
                            $updatItem = $dataService->FindbyId('Item', $productObj[0]->Id);
                        } else {
                            $updatItem = self::createNewItem($paymentDetails, $destinationName, $unitPrice, $dataService);
                        }
                    }
                    break;
                case Constant::malta:
                    if ($paymentType == 'First Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Photocopy - CV, Passport - Malta'");
                    } else if ($paymentType == 'Second Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Typing for Visa Application - Malta'");
                    } else if ($paymentType == 'Third Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Travel Documents Submission - Malta'");
                    }
                    if ($paymentDetails->payment_type ==  'Full-Outstanding Payment') {
                        $FullFirstPayment = $dataService->Query("select * from Item Where Name='Photocopy - CV, Passport - Malta'");
                        $FullFirstPaymentProduct = $dataService->FindbyId('Item', $FullFirstPayment[0]->Id);
                        $FullFirstPaymentProductChange = [
                            'Taxable' => true
                        ];
                        $dataService->Update(Item::update($FullFirstPaymentProduct, $FullFirstPaymentProductChange));
                        $FullSecondPayment = $dataService->Query("select * from Item Where Name='Typing for Visa Application - Malta'");
                        $FullSecondPaymentProduct = $dataService->FindbyId('Item', $FullSecondPayment[0]->Id);
                        $FullSecondPaymentProductChange = [
                            'Taxable' => true
                        ];
                        $dataService->Update(Item::update($FullSecondPaymentProduct, $FullSecondPaymentProductChange));
                        $FullThirdPayment = $dataService->Query("select * from Item Where Name='Travel Documents Submission - Malta'");
                        $FullThirdPaymentProduct = $dataService->FindbyId('Item', $FullThirdPayment[0]->Id);
                        $FullThirdPaymentProductChange = [
                            'Taxable' => true
                        ];
                        $dataService->Update(Item::update($FullThirdPaymentProduct, $FullThirdPaymentProductChange));
                    } else {
                        if ($productObj) {
                            $updatItem = $dataService->FindbyId('Item', $productObj[0]->Id);
                        } else {
                            $updatItem = self::createNewItem($paymentDetails, $destinationName, $unitPrice, $dataService);
                        }
                    }
                    break;
                case Constant::canada:
                    if ($paymentType == 'First Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Photocopy Cv, Passport - Canada'");
                    } else if ($paymentType == 'Second Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Typing for Visa Application - Canada'");
                    } else if ($paymentType == 'Third Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Travel Documents Sumitted  Canada'");
                    }
                    if ($paymentDetails->payment_type ==  'Full-Outstanding Payment') {
                        $FullFirstPayment = $dataService->Query("select * from Item Where Name='Photocopy Cv, Passport - Canada'");
                        $FullFirstPaymentProduct = $dataService->FindbyId('Item', $FullFirstPayment[0]->Id);
                        $FullFirstPaymentProductChange = [
                            'Taxable' => true
                        ];
                        $dataService->Update(Item::update($FullFirstPaymentProduct, $FullFirstPaymentProductChange));
                        $FullSecondPayment = $dataService->Query("select * from Item Where Name='Typing for Visa Application - Canada'");
                        $FullSecondPaymentProduct = $dataService->FindbyId('Item', $FullSecondPayment[0]->Id);
                        $FullSecondPaymentProductChange = [
                            'Taxable' => true
                        ];
                        $dataService->Update(Item::update($FullSecondPaymentProduct, $FullSecondPaymentProductChange));
                        $FullThirdPayment = $dataService->Query("select * from Item Where Name='Travel Documents Sumitted  Canada'");
                        $FullThirdPaymentProduct = $dataService->FindbyId('Item', $FullThirdPayment[0]->Id);
                        $FullThirdPaymentProductChange = [
                            'Taxable' => true
                        ];
                        $dataService->Update(Item::update($FullThirdPaymentProduct, $FullThirdPaymentProductChange));
                    } else {
                        if($productObj[0]) {
                            $updatItem = $dataService->FindbyId('Item', $productObj[0]->Id);
                        } else {
                            $updatItem = self::createNewItem($paymentDetails, $destinationName, $unitPrice, $dataService);
                        }
                    }
                    break;
                case Constant::germany:
                    if ($paymentType == 'First Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Photocopy- CV, Passport - Germany'");
                    } else if ($paymentType == 'Second Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Typing for Visa Application - Germany'");
                    } else if ($paymentType == 'Third Payment') {
                        $productObj = $dataService->Query("select * from Item Where Name='Travel Documents Submission - Germany'");
                    }
                    if ($paymentDetails->payment_type ==  'Full-Outstanding Payment') {
                        $FullFirstPayment = $dataService->Query("select * from Item Where Name='Photocopy- CV, Passport - Germany'");
                        $FullFirstPaymentProduct = $dataService->FindbyId('Item', $FullFirstPayment[0]->Id);
                        $FullFirstPaymentProductChange = [
                            'Taxable' => true
                        ];
                        $dataService->Update(Item::update($FullFirstPaymentProduct, $FullFirstPaymentProductChange));
                        $FullSecondPayment = $dataService->Query("select * from Item Where Name='Typing for Visa Application - Germany'");
                        $FullSecondPaymentProduct = $dataService->FindbyId('Item', $FullSecondPayment[0]->Id);
                        $FullSecondPaymentProductChange = [
                            'Taxable' => true
                        ];
                        $dataService->Update(Item::update($FullSecondPaymentProduct, $FullSecondPaymentProductChange));
                        $FullThirdPayment = $dataService->Query("select * from Item Where Name='Travel Documents Sumitted  Canada'");
                        $FullThirdPaymentProduct = $dataService->FindbyId('Item', $FullThirdPayment[0]->Id);
                        $FullThirdPaymentProductChange = [
                            'Taxable' => true
                        ];
                        $dataService->Update(Item::update($FullThirdPaymentProduct, $FullThirdPaymentProductChange));
                    } else {
                        if($productObj[0]) {
                            $updatItem = $dataService->FindbyId('Item', $productObj[0]->Id);
                        } else {
                            $updatItem = self::createNewItem($paymentDetails, $destinationName, $unitPrice, $dataService);
                        }
                    }
                    break;
                default:
                    $updatItem = self::createNewItem($paymentDetails, $destinationName, $unitPrice, $dataService);
            }
            $paidAmount = $paymentDetails->paid_amount;
            if ($paymentDetails->payment_type ==  'Full-Outstanding Payment') {
            } else {
                $productChange = [
                    'UnitPrice' => $unitPrice,
                    'Taxable' => true
                ];
                if ($productObj) {
                    $theResourceObj = Item::update($updatItem, $productChange);
                    $dataService->Update($theResourceObj);
                } else {
                    $updatItem = self::createNewItem($paymentDetails, $destinationName, $unitPrice, $dataService);
                }
            }
            $coupon = DB::table('coupons')
                ->where('location', '=', $apply->embassy_country)
                ->where('employee_id', '=', Session::get('myproduct_id'))
                ->where('active_from', '<=', date('Y-m-d'))
                ->where('active_until', '>=', date('Y-m-d'))
                ->where('active', '=', 1)
                ->first();
            if ($paymentDetails->payment_type ==  'Full-Outstanding Payment') {
                $firstPaymentDone = PaymentDetails::where('application_id', $apply->id)
                    ->where('payment_type', 'First Payment')
                    ->where('paid_amount', '!=', null)
                    ->where('invoice_no', '!=', null)
                    ->where('invoice_id', '!=', null)
                    ->first();
                if ($firstPaymentDone) {
                    $remainingPayment = $firstPaymentDone->payable_amount - $firstPaymentDone->paid_amount;
                    if ($remainingPayment == 0) {
                    } else {
                        self::firstPaymentBalanceDue($paymentType, $apply, $paymentDetails, $customer, $dataService, $remainingPayment);
                    }
                    if ($apply->second_payment_price > 0) {
                        $theResourceObj = Invoice::create([
                            "Line" => [
                                [
                                    "Description" => $FullSecondPaymentProduct->Description,
                                    "Amount" => $apply->planSecondPrice,
                                    "DetailType" => "SalesItemLineDetail",
                                    "SalesItemLineDetail" => [
                                        "TaxCodeRef" => [
                                            "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 4 : 12, //'TAX
                                        ],
                                        "ItemRef" =>
                                        [
                                            "value" => $FullSecondPaymentProduct->Id, //$updatSecondItem->Id
                                            "name" => $FullSecondPaymentProduct->Name,  //$updatSecondItem->Name
                                            // "Description" => $updatSecondItem->Description
                                        ],
                                        'UnitPrice' => $apply->planSecondPrice,
                                        'Qty' => 1.0
                                    ]
                                ],
                                [
                                    "Description" => $FullThirdPaymentProduct->Description,
                                    "Amount" => $apply->planThirdPrice,
                                    "DetailType" => "SalesItemLineDetail",
                                    "SalesItemLineDetail" =>
                                    [
                                        "TaxCodeRef" => [
                                            "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 4 : 12, //'TAX
                                        ],
                                        "ItemRef" =>
                                        [
                                            "value" => $FullThirdPaymentProduct->Id, //$updatThirdItem->Id
                                            "name" => $FullThirdPaymentProduct->Name,
                                            // "Description" => $updatThirdItem->Description
                                        ],
                                        'UnitPrice' => $apply->planThirdPrice,
                                        'Qty' => 1.0
                                    ]
                                ],
                                [
                                    "DetailType" => "DiscountLineDetail",
                                    "DiscountLineDetail"  => [
                                        "PercentBased" => true,
                                        "DiscountPercent" => ($destination->full_payment_discount) ?? 0,
                                    ]
                                ]
                            ],
                            "ApplyTaxAfterDiscount" => true,
                            "Deposit" => $apply->total_paid - $remainingPayment,
                            "AutoDocNumber" => true,

                            "TxnTaxDetail" => [
                                "TxnTaxCodeRef" => [
                                    "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 0 : 5,  // tax rate
                                    "name" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 'EX Exempt' : "SR Standard Rated (DXB)", // tax rate name
                                ],
                                "TotalTax" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 0 : $apply->total_vat,
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
                        $theResourceObj = Invoice::create([
                            "Line" => [
                                [
                                    "Description" => $FullSecondPaymentProduct->Description,
                                    "Amount" => $apply->planSecondPrice,
                                    "DetailType" => "SalesItemLineDetail",
                                    "SalesItemLineDetail" => [
                                        "TaxCodeRef" => [
                                            "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 4 : 12, //'TAX
                                        ],
                                        "ItemRef" =>
                                        [
                                            "value" => $FullSecondPaymentProduct->Id,
                                            "name" => $FullSecondPaymentProduct->Name,
                                            // "Description" => $updatSecondItem->Description
                                        ],
                                        'UnitPrice' => $apply->planSecondPrice,
                                        'Qty' => 1.0
                                    ]
                                ],
                            ],
                            "Deposit" => $apply->total_paid - $remainingPayment,
                            "AutoDocNumber" => true,

                            "TxnTaxDetail" => [
                                "TxnTaxCodeRef" => [
                                    "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 0 : 5,  // tax rate
                                    "name" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 'EX Exempt' : "SR Standard Rated (DXB)", // tax rate name
                                ],
                                "TotalTax" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 0 : $apply->total_vat,
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
                    }
                } else {
                    if ($apply->second_payment_price > 0) {
                        $theResourceObj = Invoice::create([
                            "Line" => [
                                [
                                    "Description" => $FullFirstPaymentProduct->Description,
                                    "Amount" => $apply->planFirstPrice,
                                    "DetailType" =>
                                    "SalesItemLineDetail",
                                    "SalesItemLineDetail" =>
                                    [
                                        "TaxCodeRef" => [
                                            "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 4 : 12, //'TAX
                                        ],
                                        "ItemRef" =>
                                        [
                                            "value" => $FullFirstPaymentProduct->Id,
                                            "name" => $FullFirstPaymentProduct->Name,
                                            // "Description" => $updatFirstItem->Description
                                        ],
                                        'UnitPrice' => $apply->planFirstPrice,
                                        'Qty' => 1.0
                                    ]
                                ],
                                [
                                    "Description" => $FullSecondPaymentProduct->Description,
                                    "Amount" => $apply->planSecondPrice,
                                    "DetailType" => "SalesItemLineDetail",
                                    "SalesItemLineDetail" => [
                                        "TaxCodeRef" => [
                                            "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 4 : 12, //'TAX
                                        ],
                                        "ItemRef" =>
                                        [
                                            "value" => $FullSecondPaymentProduct->Id,
                                            "name" => $FullSecondPaymentProduct->Name
                                            // "Description" => $updatSecondItem->Description
                                        ],
                                        'UnitPrice' => $apply->planSecondPrice,
                                        'Qty' => 1.0
                                    ]
                                ],
                                [
                                    "Description" => $FullThirdPaymentProduct->Description,
                                    "Amount" => $apply->planThirdPrice,
                                    "DetailType" => "SalesItemLineDetail",
                                    "SalesItemLineDetail" =>
                                    [
                                        "TaxCodeRef" => [
                                            "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 4 : 12, //'TAX
                                        ],
                                        "ItemRef" =>
                                        [
                                            "value" => $FullThirdPaymentProduct->Id,
                                            "name" => $FullThirdPaymentProduct->Name,
                                            // "Description" => $updatThirdItem->Description
                                        ],
                                        'UnitPrice' => $apply->planThirdPrice,
                                        'Qty' => 1.0
                                    ]
                                ],
                                [
                                    "DetailType" => "DiscountLineDetail",
                                    "DiscountLineDetail"  => [
                                        "PercentBased" => true,
                                        "DiscountPercent" => ((Session::get('discountapplied') == 1) ? ($coupon->amount) : (($destination->full_payment_discount) ?? 0)),
                                    ]
                                ]
                            ],
                            "ApplyTaxAfterDiscount" => true,
                            "Deposit" => $apply->total_paid,
                            "AutoDocNumber" => true,

                            "TxnTaxDetail" => [
                                "TxnTaxCodeRef" => [
                                    "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 0 : 5,  // tax rate
                                    "name" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 'EX Exempt' : "SR Standard Rated (DXB)", // tax rate name
                                ],
                                "TotalTax" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 0 : $apply->total_vat,
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
                        $theResourceObj = Invoice::create([
                            "Line" => [
                                [
                                    "Description" => $FullFirstPaymentProduct->Description,
                                    "Amount" => $apply->planFirstPrice,
                                    "DetailType" =>
                                    "SalesItemLineDetail",
                                    "SalesItemLineDetail" =>
                                    [
                                        "TaxCodeRef" => [
                                            "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 4 : 12, //'TAX
                                        ],
                                        "ItemRef" =>
                                        [
                                            "value" => $FullFirstPaymentProduct->Id,
                                            "name" => $FullFirstPaymentProduct->Name,
                                            // "Description" => $updatFirstItem->Description
                                        ],
                                        'UnitPrice' => $apply->planFirstPrice,
                                        'Qty' => 1.0
                                    ]
                                ],
                                [
                                    "Description" => $FullFirstPaymentProduct->Description,
                                    "Amount" => $apply->planSecondPrice,
                                    "DetailType" => "SalesItemLineDetail",
                                    "SalesItemLineDetail" => [
                                        "TaxCodeRef" => [
                                            "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 4 : 12, //'TAX
                                        ],
                                        "ItemRef" =>
                                        [
                                            "value" => $FullSecondPaymentProduct->Id,
                                            "name" => $FullSecondPaymentProduct->Name,
                                        ],
                                        'UnitPrice' => $apply->planSecondPrice,
                                        'Qty' => 1.0
                                    ]
                                ],
                                [
                                    "DetailType" => "DiscountLineDetail",
                                    "DiscountLineDetail"  => [
                                        "PercentBased" => true,
                                        "DiscountPercent" => ((Session::get('discountapplied') == 1) ? ($coupon->amount) : (($destination->full_payment_discount) ?? 0)),
                                        // "DiscountPercent" => ($destination->full_payment_discount) ? ((Session::get('discountapplied') == 1) ? ($coupon->amount + $destination->full_payment_discount) : $destination->full_payment_discount) : 0,
                                    ]
                                ]
                            ],
                            "ApplyTaxAfterDiscount" => true,
                            "Deposit" => $apply->total_paid,
                            "AutoDocNumber" => true,

                            "TxnTaxDetail" => [
                                "TxnTaxCodeRef" => [
                                    "value" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 0 : 5,  // tax rate
                                    "name" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 'EX Exempt' : "SR Standard Rated (DXB)", // tax rate name
                                ],
                                "TotalTax" => ($apply->total_vat == 0 || $apply->total_vat == null) ? 0 : $apply->total_vat,
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
                    }
                }
            } else {
                if ($paymentType == 'First Payment') {
                    $firstPaymentDue = PaymentDetails::where('application_id', $apply->id)
                        ->where('payment_type', $paymentType)
                        ->where('paid_amount', '!=', null)
                        ->where('invoice_id', '!=', null)
                        ->where('invoice_no', '!=', null)
                        ->first();
                    if ($firstPaymentDue) {
                        $remainingPayment = $firstPaymentDue->payable_amount - $firstPaymentDue->paid_amount;
                        self::firstPaymentBalanceDue($paymentType, $apply, $paymentDetails, $customer, $dataService, $remainingPayment);
                    } else {
                        self::quickBook($dataService, $coupon, $unitPrice, $updatItem, $paidAmount, $tax, $customer, $paymentDetails, $apply);
                    }
                } elseif ($paymentType == 'Second Payment' || $paymentType == 'Third Payment') {
                    self::quickBook($dataService, $coupon, $unitPrice, $updatItem, $paidAmount, $tax, $customer, $paymentDetails, $apply);
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
        } catch (Exception $exception) {
            return \Redirect::route('myapplication')->with('error', $exception->getMessage());
        }
    }

    private static function quickBook($dataService, $coupon, $unitPrice, $updatItem, $paidAmount, $tax, $customer, $paymentDetails, $application)
    {
        if (Session::get('discountapplied') == 1) {
            $theResourceObj = Invoice::create([
                "Line" => [
                    [
                        "Description" => $updatItem->Description,
                        "Amount" => $unitPrice,
                        "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => [
                            "TaxCodeRef" => [
                                "value" => ($tax == 0 || $tax == null) ? 4 : 12, //'TAX
                            ],
                            "ItemRef" => [
                                "value" => $updatItem->Id,
                                "name" => $updatItem->Name
                            ],
                            'UnitPrice' => $unitPrice,
                            'Qty' => 1.0
                        ]
                    ],
                    [
                        "DetailType" => "DiscountLineDetail",
                        "DiscountLineDetail"  => [
                            "PercentBased" => true,
                            "DiscountPercent" => $coupon->amount
                        ]

                    ]
                ],
                "Deposit" => $paidAmount,
                "AutoDocNumber" => true,

                // no tax due to free zone

                "TxnTaxDetail" => [
                    "TxnTaxCodeRef" => [
                        "value" => ($tax == 0 || $tax == null) ? 0 : 5,  // tax rate
                        "name" => ($tax == 0 || $tax == null) ? 'EX Exempt' : "SR Standard Rated (DXB)", // tax rate name
                    ],
                    "TotalTax" => ($tax == 0 || $tax == null) ? 0 : $tax,
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
        } else {
            $theResourceObj = Invoice::create([
                "Line" => [
                    [
                        "Description" => $updatItem->Description,
                        "Amount" => $unitPrice,
                        "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => [
                            "TaxCodeRef" => [
                                "value" =>  ($tax == 0 || $tax == null) ? 4 : 12, //'TAX',
                            ],
                            "ItemRef" => [
                                "value" => $updatItem->Id,
                                "name" => $updatItem->Name
                            ],
                            'UnitPrice' => $unitPrice,
                            'Qty' => 1.0
                        ]
                    ]
                ],
                "Deposit" => $paidAmount,
                "AutoDocNumber" => true,
                // no tax due to free zone
                "TxnTaxDetail" => [
                    "TxnTaxCodeRef" => [
                        "value" => ($tax == 0 || $tax == null) ? 0 : 5,  // tax rate
                        "name" => ($tax == 0 || $tax == null) ? 'EX Exempt' : "SR Standard Rated (DXB)", // tax rate name
                    ],
                    "TotalTax" => ($tax == 0 || $tax == null) ? 0 : $tax,
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

    public static function updateTokenAccess()
    {
        try {
            $quickbook = QuickModel::first();
            $dataService = DataService::Configure(array(
                'auth_mode' => 'oauth2',
                'ClientID' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.client_id') : config('services.quickbook.client_id'),
                'ClientSecret' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.client_secret') : config('services.quickbook.client_secret'),
                'RedirectURI' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.oauth_redirect_uri') : config('services.quickbook.oauth_redirect_uri'),
                'scope' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.oauth_scope') : config('services.quickbook.oauth_scope'),
                'accessTokenKey' => $quickbook['access_token'],
                'refreshTokenKey' => $quickbook['refresh_token'],
                'QBORealmID' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.QBORealmID') : config('services.quickbook.QBORealmID'),
                'baseUrl' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? "Development" : "production"
            ));
            
            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();
            $dataService->updateOAuth2Token($refreshedAccessTokenObj);
            if ($quickbook) {
                if (Carbon::now()->addMinutes(10)->format('Y/m/d H:i:s')  >= $quickbook['access_token_expires_in']) {

                    $quickbook->access_token = $refreshedAccessTokenObj->getAccessToken();
                    $quickbook->refresh_token = $refreshedAccessTokenObj->getRefreshToken();
                    $quickbook->refresh_token_expires_in = $refreshedAccessTokenObj->getRefreshTokenExpiresAt();
                    $quickbook->access_token_expires_in =  $refreshedAccessTokenObj->getAccessTokenExpiresAt();
                    $quickbook->realmId = $refreshedAccessTokenObj->getRealmID();
                    $quickbook->save();
                }
            } else {
                $quickbook = new QuickModel();
                $quickbook->access_token = $refreshedAccessTokenObj->getAccessToken();
                $quickbook->refresh_token = $refreshedAccessTokenObj->getRefreshToken();
                $quickbook->refresh_token_expires_in = $refreshedAccessTokenObj->getRefreshTokenExpiresAt();
                $quickbook->access_token_expires_in =  $refreshedAccessTokenObj->getAccessTokenExpiresAt();
                $quickbook->realmId = $refreshedAccessTokenObj->getRealmID();
                $quickbook->save();
            }
        } catch (Exception $exception) {
            return \Redirect::route('myapplication')->with('error', $exception->getMessage());
        }
    }

    private static function firstPaymentBalanceDue($paymentType, $apply, $paymentDetails, $customer, $dataService, $remainingPayment = 0)
    {
        $prevInvoice  =  PaymentDetails::where('application_id', $apply->id)
            ->where('payment_type', 'First Payment')
            ->where('invoice_id', '!=', null)
            ->where('invoice_no', '!=', null)
            ->first();
        $paymentObj = \QuickBooksOnline\API\Facades\Payment::create([
            "TotalAmt" =>  $paymentDetails->invoice_amount,
            "UnappliedAmt" => 0.00,
            "CustomerRef" => ($customer->Id) ??  $customer[0]->Id,
            "PrivateNote" => $paymentDetails->bank_reference_no,
            "PaymentRefNum" => $paymentDetails->bank_reference_no,
            "Line" => [
                [
                    "Amount" => $remainingPayment,
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
    }

    private static function createNewItem($paymentDetails, $destinationName, $unitPrice, $dataService)
    {
        $Item = Item::create([
            "Name" => $paymentDetails->payment_type . '-' . $destinationName. '-' . Carbon::now()->format('YmdHis'),
            "Description" => $paymentDetails->payment_type . '-' . $destinationName,
            "Active" => true,
            "FullyQualifiedName" => $paymentDetails->payment_type . '-' . $destinationName,
            "Taxable" => true,
            "UnitPrice" => $unitPrice,
            "Type" => "Service",
            "IncomeAccountRef" => [
                "value" => 1,
                "name" => "Services"
            ]
        ]);
        $resultingObj = $dataService->Add($Item);
        return $Item;
    }
}
