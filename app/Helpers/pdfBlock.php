<?php

namespace App\Helpers;

use Codedge\Fpdf\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use App\Models\product;
use App\Models\User;
use App\Models\Applicant;
use App\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Constant;
use \setasign\Fpdi\PdfParser\StreamReader;
use App\Helpers\users as UserHelper;
use Spatie\PdfToImage\Pdf;
use Exception;
use Imagick;
use ImagickDraw;
use ImagickPixel;
use Carbon\Carbon;

class pdfBlock
{
    public static function pdfBlock($fileUrl)
    {
        $pdf = new \setasign\Fpdi\Fpdi();
        
        $fileContent = file_get_contents($fileUrl, 'rb');
        $pagecount = $pdf->setSourceFile(StreamReader::createByString($fileContent));

        for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {

            $pdf->AddPage();
            $template = $pdf->importPage($pageNo);

            // use the imported page and place it at point 20,30 with a width of 170 mm
            $pdf->useTemplate($template);
            $pdf->SetFont('Arial', 'B', '9');

            $rand = UserHelper::getRandomString();
            // //mask
            $mask = "user/images/mask2.jpg";
            if ($pageNo == 1){
                $pdf->SetXY(145, 21);
                $pdf->Write(2, $rand);
                $pdf->Image($mask, 145, 19, 50, 4, 'JPG');
                $pdf->SetXY(22, 57);
                $pdf->Write(2, $rand);
                $pdf->Image($mask, 22, 56, 35, 5, 'JPG');
                $pdf->SetXY(145, 58);
                $pdf->Write(2, $rand);
                $pdf->Image($mask, 145, 56, 40, 5, 'JPG');
                $pdf->SetXY(107, 81);
                $pdf->Write(2, $rand);
                $pdf->Image($mask, 107, 79, 35, 5, 'JPG');
                $pdf->SetXY(21, 151);
                $pdf->Write(2, $rand);
                $pdf->Image($mask, 21, 149, 90, 4, 'JPG');
            }
        }
        $newFileName = 'workpermit' . Auth::id() . '-' . UserHelper::getRandomString() . '-' . '.pdf';
        $destination_file = 'Applications/Contracts/workPermit/' . $newFileName;
        $theString = $pdf->Output('S');
        Storage::disk(env('MEDIA_DISK'))->put($destination_file, $theString, 'public');
        return $destination_file;
    }


    public static function mapDetails($originalPdf, $destination_file, $product, $package, $client)
    {

        $pdf = new \setasign\Fpdi\Fpdi();
        $pagecount = $pdf->setSourceFile($originalPdf);

        for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {

            $pdf->AddPage();
            $template = $pdf->importPage($pageNo);
            // $client = User::find(Auth::id());
            // use the imported page and place it at point 20,30 with a width of 170 mm
            $pdf->useTemplate($template, 10, 10, 200);
            //Select Arial italic 8
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->SetTextColor(0, 0, 0);

            if ($pageNo == 1 && ($product == Constant::poland || $product == Constant::germany)) {
                //Date
                $pdf->SetXY(35, 40);
                $pdf->Write(2, date('d/m/Y'));

                //Place
                $pdf->SetXY(35, 54);
                $pdf->Write(2, 'DUBAI, UAE');

                //Representative
                // $pdf->SetXY(27, 56 );
                // $pdf->Write(2, 'UAE');

                //Name
                $pdf->SetXY(70, 115);
                $pdf->Write(2, $client->name . ' ' . $client->sur_name);

                // //Nationality
                // $pdf->SetXY(70, 129);
                // $pdf->Write(2, '[Nationality]');                

                // //Passport
                // $pdf->SetXY(70, 143 );
                // $pdf->Write(2, "[PASSPORT]");                                

                //Phone
                $pdf->SetXY(70, 155.5);
                $pdf->Write(2, $client->phone_number);

                //email
                $pdf->SetXY(70, 168);
                $pdf->Write(2, $client->email);
            } else if ($pageNo == 1 && $product == Constant::czech) {
                //Date
                $pdf->SetXY(32, 28.3);
                $pdf->Write(2, date('d/m/Y'));

                //Place
                $pdf->SetXY(32, 42.3);
                $pdf->Write(2, 'DUBAI, UAE');

                //Name
                $pdf->SetXY(70, 104);
                $pdf->Write(2, $client->name . ' ' . $client->sur_name);

                //Nationality
                $pdf->SetXY(70, 118);
                $pdf->Write(2, '');

                //Passport
                $pdf->SetXY(70, 132);
                $pdf->Write(2, '');

                //Phone
                $pdf->SetXY(70, 145);
                $pdf->Write(2, $client->phone_number);

                //email
                $pdf->SetXY(70, 160);
                $pdf->Write(2, $client->email);
            } else if ($pageNo == 1 && $product == Constant::malta) {
                //Date
                $pdf->SetXY(28, 22);
                $pdf->Write(2, date('d/m/Y'));

                //Place
                $pdf->SetXY(67, 22);
                $pdf->Write(2, 'DUBAI, UAE');

                // //mask
                // $mask = "user/images/mask2.jpg";
                // $pdf->SetProtection(array('print'));
                // $pdf->Image($mask, 85, 39, 15, 4, 'JPG');

                //Name
                $pdf->SetXY(65, 68.5);
                $pdf->Write(2, $client->name . ' ' . $client->sur_name);

                //Phone
                $pdf->SetXY(45, 93);
                $pdf->Write(2, $client->phone_number);

                //email
                $pdf->SetXY(50, 99);
                $pdf->Write(2, $client->email);
            } else if ($pageNo == 1 && $product == Constant::canada) {
                // if ($package == Constant::CanadaExpressEntry) {
                //     //Date
                //     $pdf->SetXY(30, 40);
                //     $pdf->Write(2, date('d/m/Y'));

                //     //Place
                //     $pdf->SetXY(30, 54);
                //     $pdf->Write(2, 'DUBAI, UAE');

                //     //Name
                //     $pdf->SetXY(65, 116);
                //     $pdf->Write(2, $client->name . ' ' . $client->sur_name);

                //     //Phone
                //     $pdf->SetXY(65, 155);
                //     $pdf->Write(2, $client->phone_number);

                //     //email
                //     $pdf->SetXY(65, 169);
                //     $pdf->Write(2, $client->email);
                // } else if ($package == Constant::CanadaStudyPermit) {
                //     //Date
                //     $pdf->SetXY(30, 40);
                //     $pdf->Write(2, date('d/m/Y'));

                //     //Place
                //     $pdf->SetXY(30, 54);
                //     $pdf->Write(2, 'DUBAI, UAE');

                //     //Name
                //     $pdf->SetXY(65, 113);
                //     $pdf->Write(2, $client->name . ' ' . $client->sur_name);

                //     //Phone
                //     $pdf->SetXY(65, 152);
                //     $pdf->Write(2, $client->phone_number);

                //     //email
                //     $pdf->SetXY(65, 166);
                //     $pdf->Write(2, $client->email);
                // } else if ($package == Constant::BlueCollar) {
                    //Date
                    $pdf->SetXY(30, 40);
                    $pdf->Write(2, date('d/m/Y'));

                    //Place
                    $pdf->SetXY(30, 54);
                    $pdf->Write(2, 'DUBAI, UAE');

                    //Name
                    $pdf->SetXY(65, 116);
                    $pdf->Write(2, $client->name . ' ' . $client->sur_name);

                    //Phone
                    $pdf->SetXY(65, 156);
                    $pdf->Write(2, $client->phone_number);

                    //email
                    $pdf->SetXY(65, 170);
                    $pdf->Write(2, $client->email);
                // }
            }

            if ($pageNo == 4) {
                //Sign
                // $pdf->SetXY(30, 235 );
                // $pdf->Write(2, "[SIGN HERE]");   
            }
        }
        // $content = $pdf->Output($destination_file, "F");
        $theString = $pdf->Output('S');
        Storage::disk(env('MEDIA_DISK'))->put($destination_file, $theString, 'public');
    }

    public static function attachSignature($originalPdf, $signature, $product, $paymentType, $applicant, $client)
    {
        
        $pdf = new \setasign\Fpdi\Fpdi();
        $fileContent = file_get_contents($originalPdf, 'rb');
        $pagecount = $pdf->setSourceFile(StreamReader::createByString($fileContent));
        for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
            $pdf->AddPage();
            $template = $pdf->importPage($pageNo);
            // use the imported page and place it at point 20,30 with a width of 170 mm
            $pdf->useTemplate($template, 10, 10, 200);
            //Select Arial italic 8
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->SetTextColor(0, 0, 0);

            if (strtolower($product->name) == Constant::poland || strtolower($product->name) == Constant::germany) {

                if ($pageNo == 4) {
                    // if ($paymentType == 'FIRST' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                        $pdf->Image($signature, 45, 217, 25, 20, 'PNG');

                        $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name .'_'.$product->name.'_first_payment_contract.pdf';
                    // }
                }
                // if ($pageNo == 5) {
                //     if ($paymentType == 'FIRST' || $paymentType == 'Full-Outstanding Payment') {
                //         //signature

                //         // $pdf->Image($signature, 155, 69, 18, 15, 'PNG');
                //         // $pdf->Image($signature, 155, 109, 18, 15, 'PNG');
                //         $pdf->SetXY(172, 87);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_first_payment_contract.pdf';
                //     }
                //     if ($paymentType == 'SUBMISSION') {
                //         // $pdf->Image($signature, 155, 149, 18, 15, 'PNG');
                //         // $pdf->Image($signature, 155, 195, 18, 15, 'PNG');
                //         $pdf->SetXY(172, 127);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_second_payment_contract.pdf';
                //     } else if($paymentType == 'Full-Outstanding Payment'){
                //         $pdf->SetXY(172, 123);
                //         $pdf->Write(2, date('d/m/Y'));
                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_second_payment_contract.pdf';
                //     }
                // }
                // if ($pageNo == 5) {

                //     if ($paymentType == 'SECOND') {

                //         // $pdf->Image($signature, 155, 64, 18, 15, 'PNG');
                //         // $pdf->Image($signature, 155, 103, 18, 15, 'PNG');
                //         $pdf->SetXY(172, 171);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';
                //     } elseif($paymentType == 'Full-Outstanding Payment') {
                //         $pdf->SetXY(172, 168);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';
                //     }

                //     if ($paymentType == 'Fourth Payment' || $paymentType == 'Full-Outstanding Payment') {

                //         // $pdf->Image($signature, 167, 170, 18, 12, 'PNG');
                //         // $pdf->Image($signature, 167, 200, 18, 12, 'PNG');
                //         $pdf->SetXY(172, 215);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';
                //     }
                // }
            } else if (strtolower($product->name) == Constant::czech) {

                if ($pageNo == 4) {
                    if ($paymentType == 'FIRST' || $paymentType == 'Full-Outstanding Payment') {
                        //signature

                        $pdf->Image($signature, 40, 229, 25, 20, 'PNG');
                        $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name .'_'.$product->name.'_first_payment_contract.pdf';
                    }
                }
                // if ($pageNo == 5) {
                //     if ($paymentType == 'FIRST' || $paymentType == 'Full-Outstanding Payment') {
                //         //signature

                //         // $pdf->Image($signature, 155, 72, 18, 15, 'PNG');
                //         // $pdf->Image($signature, 155, 117, 18, 15, 'PNG');
                //         $pdf->SetXY(172, 103);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_first_payment_contract.pdf';
                //     }
                //     if ($paymentType == 'SUBMISSION') {

                //         // $pdf->Image($signature, 159, 160, 18, 15, 'PNG');
                //         // $pdf->Image($signature, 155, 209, 18, 15, 'PNG');
                //         $pdf->SetXY(172, 143);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_second_payment_contract.pdf';
                //     } else if($paymentType == 'Full-Outstanding Payment') {
                //         $pdf->SetXY(172, 140);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_second_payment_contract.pdf';
                //     }
                // }
                // if ($pageNo == 5) {

                //     if ($paymentType == 'SECOND') {

                //         // $pdf->Image($signature, 158, 68, 18, 15, 'PNG');
                //         // $pdf->Image($signature, 158, 119, 18, 15, 'PNG');
                //         $pdf->SetXY(172, 188);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';
                //     } else if($paymentType == 'Full-Outstanding Payment') {
                //         $pdf->SetXY(172, 187);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';
                //     }

                //     if ($paymentType == 'Fourth Payment' || $paymentType == 'Full-Outstanding Payment') {

                //         // $pdf->Image($signature, 169, 186, 18, 12, 'PNG');
                //         // $pdf->Image($signature, 169, 217, 18, 12, 'PNG');
                //         $pdf->SetXY(172, 234);
                //         $pdf->Write(2, date('d/m/Y')); 

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';
                //     }
                // }
            } else if (strtolower($product->name) == Constant::canada) {

                if ($pageNo == 4) {
                    if ($paymentType == 'FIRST' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                        $pdf->Image($signature, 40, 215, 25, 20, 'PNG');

                        $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name .'_'.$product->name.'_first_payment_contract.pdf';
                    }
                }
                // if ($pageNo == 5) {
                //     if ($paymentType == 'FIRST' || $paymentType == 'Full-Outstanding Payment') {
                //         //signature

                //         $pdf->Image($signature, 155, 76, 18, 15, 'PNG');
                //         $pdf->Image($signature, 155, 116, 18, 15, 'PNG');
                //         $pdf->SetXY(162, 144);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_first_payment_contract.pdf';
                //     }
                //     if ($paymentType == 'SUBMISSION' || $paymentType == 'Full-Outstanding Payment') {

                //         $pdf->Image($signature, 155, 156, 18, 15, 'PNG');
                //         $pdf->Image($signature, 155, 203, 18, 15, 'PNG');
                //         $pdf->SetXY(162, 232);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_second_payment_contract.pdf';
                //     }
                // }
                // if ($pageNo == 6) {

                //     if ($paymentType == 'SECOND' || $paymentType == 'Full-Outstanding Payment') {

                //         $pdf->Image($signature, 155, 81, 18, 15, 'PNG');
                //         $pdf->Image($signature, 155, 122, 18, 15, 'PNG');
                //         $pdf->SetXY(162, 152);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';
                //     }
                // }
            } else if (strtolower($product->name) == Constant::malta) {

                if ($pageNo == 4) {
                    if ($paymentType == 'FIRST' || $paymentType == 'Full-Outstanding Payment') {
                        //signature

                        $pdf->Image($signature, 40, 229, 25, 20, 'PNG');
                        $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name .'_'.$product->name.'_first_payment_contract.pdf';
                    }
                }
                // if ($pageNo == 5) {
                //     if ($paymentType == 'FIRST' || $paymentType == 'Full-Outstanding Payment') {
                //         //signature

                //         // $pdf->Image($signature, 155, 72, 18, 15, 'PNG');
                //         // $pdf->Image($signature, 155, 117, 18, 15, 'PNG');
                //         $pdf->SetXY(173, 106);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_first_payment_contract.pdf';
                //     }
                //     if ($paymentType == 'SUBMISSION') {

                //         // $pdf->Image($signature, 155, 159, 18, 15, 'PNG');
                //         // $pdf->Image($signature, 155, 209, 18, 15, 'PNG');
                //         $pdf->SetXY(174, 148);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_second_payment_contract.pdf';
                //     } else if($paymentType == 'Full-Outstanding Payment') {
                //         $pdf->SetXY(174, 145);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_second_payment_contract.pdf';
                //     }
                // }
                // if ($pageNo == 5) {

                //     if ($paymentType == 'SECOND') {

                //         // $pdf->Image($signature, 155, 64, 18, 15, 'PNG');
                //         // $pdf->Image($signature, 155, 128, 18, 15, 'PNG');
                //         $pdf->SetXY(176, 196);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';
                //     } else if($paymentType == 'Full-Outstanding Payment'){
                //         $pdf->SetXY(172, 195);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';
                //     }
                //     if ($paymentType == 'Fourth Payment' || $paymentType == 'Full-Outstanding Payment') {

                //         // $pdf->Image($signature, 170, 200, 18, 12, 'PNG');
                //         // $pdf->Image($signature, 170, 229, 18, 12, 'PNG');
                //         $pdf->SetXY(172, 246);
                //         $pdf->Write(2, date('d/m/Y'));

                //         $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';
                //     }
                // }
            }
        }
        // if ($paymentType == 'FIRST') {
            $theString = $pdf->Output('S');
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_1st_signature, env('MEDIA_DISK'));
            } else {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_1st_signature, 'local');
            }
            $applicant->contract_1st_signature_status = 'SIGNED';
            $applicant->contract_1st_signature_at = Carbon::now();
            $applicant->contract_1st_signature_verified_by_accountant = 1;
            $applicant->contract_1st_signature_verified = 1;            
            
        // // }
        // if ($paymentType == 'SUBMISSION') {
        //     $theString = $pdf->Output('S');
        //     if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
        //         $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_submission_signature, env('MEDIA_DISK'));
        //     } else {
        //         $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_submission_signature, 'local');
        //     }
        //     $applicant->contract_submission_signature_status = 'SIGNED';
        //     $applicant->contract_submission_signature_at = Carbon::now();

        // }
        // if ($paymentType == 'SECOND') {
        //     $theString = $pdf->Output('S');
        //     if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
        //         $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_2nd_signature, env('MEDIA_DISK'));
        //     } else {
        //         $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_2nd_signature, 'local');
        //     }
        //     $applicant->contract_2nd_signature_status = 'SIGNED';
        //     $applicant->contract_2nd_signature_at = Carbon::now();

        // }
        // if ($paymentType == 'Full-Outstanding Payment') {
        //     $theString = $pdf->Output('S');
        //     if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
        //         $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_1st_signature, env('MEDIA_DISK'));
        //         $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_submission_signature, env('MEDIA_DISK'));
        //         $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_2nd_signature, env('MEDIA_DISK'));
        //     } else {

        //         $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_1st_signature, 'local');
        //         $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_submission_signature, 'local');
        //         $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_2nd_signature, 'local');
        //     }
        //     $applicant->contract_1st_signature_status = 'SIGNED';
        //     $applicant->contract_submission_signature_status = 'SIGNED';
        //     $applicant->contract_2nd_signature_status = 'SIGNED';
        //     $applicant->contract_1st_signature_at = Carbon::now();
        //     $applicant->contract_submission_signature_at = Carbon::now();
        //     $applicant->contract_2nd_signature_at = Carbon::now();
        // }
        $applicant->save();
    }

    public static function jobLetter($applicant,$clientId,$date)
    {
        
        $pdf = new \setasign\Fpdi\Fpdi();
        // $pagecount = $pdf->setSourceFile('pdf/offer_letter_template.pdf');
        $fileContent = file_get_contents(public_path('pdf/offer_letter_template.pdf', 'rb'));
        $pagecount = $pdf->setSourceFile(StreamReader::createByString($fileContent));

        $offer_date = date('F d, Y', strtotime($date. ' + 7 days'));

        $return_date = date('F d, Y', strtotime($offer_date. ' + 7 days'));

        for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {

            $pdf->AddPage();
            $template = $pdf->importPage($pageNo);
            $client = User::find($clientId);
            // use the imported page and place it at point 20,30 with a width of 170 mm
            $pdf->useTemplate($template, 10, 10, 200);
            //Select Arial italic 8
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->SetTextColor(0, 0, 0);
            if ($pageNo == 1) {
                // $pdf->Image($signature, 155, 64, 18, 15, 'PNG');
                $pdf->SetXY(161, 47);
                $pdf->Write(2, $offer_date);

                $pdf->SetXY(37, 103.5);
                $pdf->Write(2, $client->name . ' ' . $client->middle_name . ' ' . $client->sur_name);

                $pdf->SetXY(61, 109);
                $pdf->Write(2, $client->passport_number);

                $pdf->SetXY(37, 115.4);
                $pdf->Write(2, $client->country_of_residence);

                $pdf->SetXY(60, 126);
                $pdf->Write(2, $client->name . ' ' . $client->sur_name);

                $pdf->SetXY(57, 178);
                $pdf->Write(2,  $return_date);
            }
        }
        $fileName = 'offer_letter_template_'.$client->id.'_'.$client->sur_name.'.pdf';
        $theString = $pdf->Output('S');
        $Applicants = Application::find($applicant);
        $Applicants->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_job_offer_letter, env('MEDIA_DISK'));
    }

    public static function mapMoreInfo($complete)
    {
        $applicant = Application::find($complete->id);
        $client = User::find($applicant->client_id);
        $originalPdf = null;
        $destination_file = null;
        $product = product::find($applicant->destination_id)->name;
        $productName = strtolower($product);
        $package = $applicant->work_permit_category;
        if ($applicant->first_payment_status == 'PAID' || $applicant->first_payment_status == 'PARTIALLY_PAID') {
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $originalPdf = (isset($applicant->getMedia(Application::$media_collection_main_1st_signature)[0])) ? $applicant->getMedia(Application::$media_collection_main_1st_signature)[0]->getUrl() : null;
            } else {
                $originalPdf = (isset($applicant->getMedia(Application::$media_collection_main_1st_signature)[0])) ? $applicant->getMedia(Application::$media_collection_main_1st_signature)[0]->getPath() : null;
            }
            $destination_file = Applicant::$media_collection_main_1st_signature;
        } else {
            if($applicant->getMedia(Application::$media_collection_main_1st_signature)){
                if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                    $originalPdf = (isset($applicant->getMedia(Application::$media_collection_main_1st_signature)[0])) ? $applicant->getMedia(Application::$media_collection_main_1st_signature)[0]->getUrl() : null;
                } else {
                    $originalPdf = (isset($applicant->getMedia(Application::$media_collection_main_1st_signature)[0])) ? $applicant->getMedia(Application::$media_collection_main_1st_signature)[0]->getPath() : null;
                }
                $destination_file = Applicant::$media_collection_main_1st_signature;
            } else {
                if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                    $originalPdf = Storage::disk(env('MEDIA_DISK'))->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                } else {
                    $originalPdf = Storage::disk('local')->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                    $originalPdf = ltrim($originalPdf, $originalPdf[0]);
                }
                if ($productName == Constant::poland) {
                    $newFileName = 'contract' . $client->id . '-' . UserHelper::getRandomString() . '-' . 'poland.pdf';
                } else if ($productName == Constant::czech) {
                    $newFileName = 'contract' . $client->id . '-' . UserHelper::getRandomString() . '-' . 'czech.pdf';
                } else if ($productName == Constant::malta) {
                    $newFileName = 'contract' . $client->id . '-' . UserHelper::getRandomString() . '-' . 'malta.pdf';
                } else if ($productName == Constant::canada) {
                    // if ($package == Constant::CanadaExpressEntry) {
                    //     $newFileName = 'contract' . $client->id . '-' . UserHelper::getRandomString() . '-' . 'canada_express_entry.pdf';
                    // } else if ($package == Constant::CanadaStudyPermit) {
                    //     $newFileName = 'contract' . $client->id . '-' . UserHelper::getRandomString() . '-' . 'canada_study.pdf';
                    // } else if ($package == Constant::BlueCollar) {
                        $newFileName = 'contract' . $client->id . '-' . UserHelper::getRandomString() . '-' . 'canada.pdf';
                    // }
                } else if ($productName == Constant::germany) {
                    $newFileName = 'contract' . $client->id . '-' . UserHelper::getRandomString() . '-' . 'germany.pdf';
                } else {
                    $newFileName = 'contract' . $client->id . '-' . UserHelper::getRandomString() . '-' . 'germany.pdf';
                }
                $destination_file = 'Applications/Contracts/client_contracts/' . $newFileName;
            }
        }
        $pdf = new \setasign\Fpdi\Fpdi();
        if (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
            $pagecount = $pdf->setSourceFile($originalPdf);
        } else {
            $fileContent = file_get_contents($originalPdf, 'rb');
            $pagecount = $pdf->setSourceFile(StreamReader::createByString($fileContent));
        }
        for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
            $pdf->AddPage();
            $template = $pdf->importPage($pageNo);
            // use the imported page and place it at point 20,30 with a width of 170 mm
            $pdf->useTemplate($template, 10, 10, 200);
            //Select Arial italic 8
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->SetTextColor(0, 0, 0);
            if ($pageNo == 1 && ($productName == Constant::poland || $product == Constant::germany)) {
                //Nationality
                $pdf->SetXY(85, 136);
                $pdf->Write(2, $client->citizenship);
                //Passport
                $pdf->SetXY(85, 148);
                $pdf->Write(2, $client->passport_number);
            } else if ($pageNo == 1 && $productName == Constant::czech) {
                //Nationality
                $pdf->SetXY(85, 127);
                $pdf->Write(2, $client->citizenship);

                //Passport
                $pdf->SetXY(85, 139);
                $pdf->Write(2, $client->passport_number);
            } else if ($pageNo == 1 && $productName == Constant::canada) {

                if ($package == Constant::CanadaExpressEntry) {
                    $pdf->SetXY(85, 136);
                    $pdf->Write(2, $client->citizenship);

                    //Passport
                    $pdf->SetXY(85, 148);
                    $pdf->Write(2, $client->passport_number);
                } else if ($package == Constant::CanadaStudyPermit) {
                    //Nationality
                    $pdf->SetXY(85, 136);
                    $pdf->Write(2, $client->citizenship);

                    //Passport
                    $pdf->SetXY(85, 148);
                    $pdf->Write(2, $client->passport_number);
                } else if ($package == Constant::BlueCollar) {
                    //Nationality
                    $pdf->SetXY(85, 136);
                    $pdf->Write(2, $client->citizenship);

                    //Passport
                    $pdf->SetXY(85, 148);
                    $pdf->Write(2, $client->passport_number);
                }
            } else if ($pageNo == 1 && $productName == Constant::malta) {

                //Nationality
                $pdf->SetXY(60, 86);
                $pdf->Write(2, $client->citizenship);

                //Passport
                $pdf->SetXY(84, 97);
                $pdf->Write(2, $client->passport_number);

                //DOB
                $pdf->SetXY(68, 92);
                $pdf->Write(2, $client->date_of_birth);
            }
        }
        if ($applicant->second_payment_status == 'PAID') {
            $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_third_payment_contract.pdf';

            $theString = $pdf->Output('S');
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_1st_signature, env('MEDIA_DISK'));
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_submission_signature, env('MEDIA_DISK'));
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_2nd_signature, env('MEDIA_DISK'));
            } else {

                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_1st_signature, 'local');
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_submission_signature, 'local');
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_2nd_signature, 'local');
            }
        } elseif ($applicant->first_payment_status == 'PAID' || $applicant->first_payment_status == 'PARTIALLY_PAID') {
            $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_first_payment_contract.pdf';
            $theString = $pdf->Output('S');
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_1st_signature, env('MEDIA_DISK'));
            } else {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_1st_signature, 'local');
            }
        } else {
            $fileName = $client->name . '_' . $client->middle_name . '_' . $client->sur_name . '_first_payment_contract.pdf';
            $theString = $pdf->Output('S');
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_1st_signature, env('MEDIA_DISK'));
            } else {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Application::$media_collection_main_1st_signature, 'local');
            }
            // $theString = $pdf->Output('S');
            // Storage::disk(env('MEDIA_DISK'))->put($destination_file, $theString, 'public');
        }
        $applicant->save();
    }
}


//Not related///

// if($request->hasfile('filename'))
// {

// foreach($request->file('filename') as $file)
// {
//     $name=$file->getClientOriginalName();
//     $file->move(public_path().'/files/', $name);  
//     $data[] = $name;  
// }
// }

// $file= new File();
// $file->filename=json_encode($data);


// $file->save();

// return back()->with('success', 'Your files has been successfully added');
