<?php

namespace App\Helpers;
use Codedge\Fpdf\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use App\Models\User;
use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Constant;
use \setasign\Fpdi\PdfParser\StreamReader;


class pdfBlock
{

    public static function pdfBlock(){

        $pdf = new \setasign\Fpdi\Fpdi();
        $pdf->AddPage();

        $pagecount = $pdf->setSourceFile("pdf/test.pdf");
        $template = $pdf->importPage(1);

        // use the imported page and place it at point 20,30 with a width of 170 mm
        $pdf->useTemplate($template);
                    
        //Select Arial italic 8
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY(90, 160);

        $pdf->Image('pdf/block.jpg', 10, 10, -300, -100);

        $pdf->Write(0, "Hello World");

        $pdf->Output("pdf/modified_pdf.pdf", "F");
    } 


    public static function mapDetails($originalPdf, $destination_file, $product, $package)
    {
     
        $pdf = new \setasign\Fpdi\Fpdi();
        $pagecount = $pdf->setSourceFile($originalPdf);

        for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
            
            $pdf->AddPage();
            $template = $pdf->importPage($pageNo);
            $client = User::find(Auth::id());
            // use the imported page and place it at point 20,30 with a width of 170 mm
            $pdf->useTemplate($template, 10,10,200);
            //Select Arial italic 8
            $pdf->SetFont('Arial', 'B','9');
            $pdf->SetTextColor(0,0,0);
            
            if ($pageNo == 1 && ($product == Constant::poland || $product == Constant::germany)){
                //Date
                $pdf->SetXY(28, 40 );
                $pdf->Write(2, date('d/m/Y'));

                //Place
                $pdf->SetXY(28, 54.5 );
                $pdf->Write(2, 'DUBAI, UAE');

                //Representative
                // $pdf->SetXY(27, 56 );
                // $pdf->Write(2, 'UAE');

                //Name
                $pdf->SetXY(70, 116.5);
                $pdf->Write(2, $client->name . ' ' . $client->sur_name);

                // //Nationality
                // $pdf->SetXY(70, 129);
                // $pdf->Write(2, '[Nationality]');                

                // //Passport
                // $pdf->SetXY(70, 143 );
                // $pdf->Write(2, "[PASSPORT]");                                

                //Phone
                $pdf->SetXY(70, 156 );
                $pdf->Write(2, $client->phone_number);                

                //email
                $pdf->SetXY(70, 170 );
                $pdf->Write(2, $client->email);                
            } else if ($pageNo == 1 && $product == Constant::czech){
                 //Date
                 $pdf->SetXY(28, 45 );
                 $pdf->Write(2, date('d/m/Y'));
 
                 //Place
                 $pdf->SetXY(28, 61 );
                 $pdf->Write(2, 'DUBAI, UAE');
 
                 //Name
                 $pdf->SetXY(70, 103);
                 $pdf->Write(2, $client->name . ' ' . $client->sur_name);                               
 
                 //Phone
                 $pdf->SetXY(25, 138 );
                 $pdf->Write(2, $client->phone_number);                
 
                 //email
                 $pdf->SetXY(70, 138 );
                 $pdf->Write(2, $client->email);   
            } else if ($pageNo == 1 && $product == Constant::malta){
                //Date
                $pdf->SetXY(28, 22 );
                $pdf->Write(2, date('d/m/Y'));

                //Place
                $pdf->SetXY(67, 22 );
                $pdf->Write(2, 'DUBAI, UAE');

                // //mask
                // $mask = "user/images/mask2.jpg";
                // $pdf->SetProtection(array('print'));
                // $pdf->Image($mask, 85, 39, 15, 4, 'JPG');
                
                //Name
                $pdf->SetXY(65, 69);
                $pdf->Write(2, $client->name . ' ' . $client->sur_name);

                //Phone
                $pdf->SetXY(45, 93 );
                $pdf->Write(2, $client->phone_number);

                //email
                $pdf->SetXY(50, 100 );
                $pdf->Write(2, $client->email);
            } else if($pageNo == 1 && $product == Constant::canada){
                if($package == Constant::CanadaExpressEntry){
                     //Date
                     $pdf->SetXY(30, 40 );
                     $pdf->Write(2, date('d/m/Y'));
 
                     //Place
                     $pdf->SetXY(30, 54 );
                     $pdf->Write(2, 'DUBAI, UAE');
 
                     //Name
                     $pdf->SetXY(65, 116);
                     $pdf->Write(2, $client->name . ' ' . $client->sur_name);                               
 
                     //Phone
                     $pdf->SetXY(65, 155 );
                     $pdf->Write(2, $client->phone_number);                
 
                     //email
                     $pdf->SetXY(65, 169 );
                     $pdf->Write(2, $client->email);   
                } else if($package == Constant::CanadaStudyPermit) {
                     //Date
                    $pdf->SetXY(30, 40 );
                    $pdf->Write(2, date('d/m/Y'));

                    //Place
                    $pdf->SetXY(30, 54 );
                    $pdf->Write(2, 'DUBAI, UAE');

                    //Name
                    $pdf->SetXY(65, 113);
                    $pdf->Write(2, $client->name . ' ' . $client->sur_name);                               

                    //Phone
                    $pdf->SetXY(65, 152 );
                    $pdf->Write(2, $client->phone_number);                

                    //email
                    $pdf->SetXY(65, 166 );
                    $pdf->Write(2, $client->email);  
                } else if($package == Constant::BlueCollar) {
                    //Date
                    $pdf->SetXY(30, 40 );
                    $pdf->Write(2, date('d/m/Y'));

                    //Place
                    $pdf->SetXY(30, 54 );
                    $pdf->Write(2, 'DUBAI, UAE');

                    //Name
                    $pdf->SetXY(65, 116);
                    $pdf->Write(2, $client->name . ' ' . $client->sur_name);                               

                    //Phone
                    $pdf->SetXY(65, 156 );
                    $pdf->Write(2, $client->phone_number);                

                    //email
                    $pdf->SetXY(65, 170 );
                    $pdf->Write(2, $client->email);   
                }

            }

            if ($pageNo == 4){
                //Sign
                // $pdf->SetXY(30, 235 );
                // $pdf->Write(2, "[SIGN HERE]");   
            }
        }
        // $content = $pdf->Output($destination_file, "F");
        $theString = $pdf->Output('S');
        Storage::disk(env('MEDIA_DISK'))->put($destination_file, $theString, 'public');
    }

    public static function attachSignature($originalPdf, $signature, $product, $paymentType, $applicant)
    {
        $pdf = new \setasign\Fpdi\Fpdi();
        $fileContent = file_get_contents($originalPdf,'rb');
        $pagecount = $pdf->setSourceFile(StreamReader::createByString($fileContent));
        // return $originalPdf;
        for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
            $pdf->AddPage();
            $template = $pdf->importPage($pageNo);
            // use the imported page and place it at point 20,30 with a width of 170 mm
            $pdf->useTemplate($template, 10, 10, 200);
            //Select Arial italic 8
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->SetTextColor(0, 0, 0);
            $client = User::find(Auth::id());

            if (strtolower($product->name) == Constant::poland) 
            {
                
                if ($pageNo == 4) {
                    if ($paymentType == 'First Payment' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                        $pdf->Image($signature, 40, 215, 25, 20, 'PNG');

                        // $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_first_payment_contract.pdf';
                    }
                }
                if ($pageNo == 5) {
                    if ($paymentType == 'First Payment' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                    
                        $pdf->Image($signature, 155, 69, 18, 15, 'PNG');
                        $pdf->Image($signature, 155, 109, 18, 15, 'PNG');
                        $pdf->SetXY(162, 136 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_first_payment_contract.pdf';
                    }
                    if ($paymentType == 'Second Payment' || $paymentType == 'Full-Outstanding Payment') {
                        
                        $pdf->Image($signature, 155, 149, 18, 15, 'PNG');
                        $pdf->Image($signature, 155, 195, 18, 15, 'PNG');
                        $pdf->SetXY(162, 224 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_second_payment_contract.pdf';
                    }
                    if ($paymentType == 'Third Payment' || $paymentType == 'Full-Outstanding Payment') {
                        
                        $pdf->Image($signature, 155, 269, 18, 15, 'PNG');
                        $pdf->Image($signature, 155, 309, 18, 15, 'PNG');
                        $pdf->SetXY(162, 336 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_third_payment_contract.pdf';
                    }
                }

                // if ($pageNo == 4) {
                //     if ($paymentType == 'First Payment' || $paymentType == 'Full-Outstanding Payment') {
                //         //signature
                //         $pdf->Image($signature, 45, 114, 25, 20, 'PNG');
                //         $pdf->Image($signature, 123, 111, 25, 20, 'PNG');
                //         $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_first_payment_contract.pdf';
                //     }
                // }
                // if ($pageNo == 5) {
                //     if ($paymentType == 'Second Payment' || $paymentType == 'Full-Outstanding Payment') {
                //         $pdf->Image($signature, 125, 70, 25, 20, 'PNG');
                //         $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_second_payment_contract.pdf';
                //     }
                //     if ($paymentType == 'Third Payment' || $paymentType == 'Full-Outstanding Payment') {
                //         $pdf->Image($signature, 122, 158.5, 25, 20, 'PNG');
                //         $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_third_payment_contract.pdf';
                //     }
                // }
            }

            else if (strtolower($product->name) == Constant::czech) 
            {
                
                if ($pageNo == 4) {
                    if ($paymentType == 'First Payment' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                        $pdf->Image($signature, 45, 186, 25, 20, 'PNG');
                        // $pdf->Image($signature, 123, 111, 25, 20, 'PNG');
                        // $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_first_payment_contract.pdf';
                    }
                }
                if ($pageNo == 5) {
                    if ($paymentType == 'First Payment' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                    
                        $pdf->Image($signature, 155, 110, 25, 20, 'PNG');
                        $pdf->SetXY(162, 145 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_first_payment_contract.pdf';
                    }
                    if ($paymentType == 'Second Payment' || $paymentType == 'Full-Outstanding Payment') {
                        
                        $pdf->Image($signature, 155, 165, 25, 20, 'PNG');
                        $pdf->SetXY(162, 200 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_second_payment_contract.pdf';
                    }
                    if ($paymentType == 'Third Payment' || $paymentType == 'Full-Outstanding Payment') {
                        
                        $pdf->Image($signature, 155, 220, 25, 20, 'PNG');
                        $pdf->SetXY(162, 255 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_third_payment_contract.pdf';
                    }
                }
            }

            else if (strtolower($product->name) == Constant::canada) 
            {
                
                if ($pageNo == 4) {
                    if ($paymentType == 'First Payment' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                        $pdf->Image($signature, 40, 215, 25, 20, 'PNG');

                        // $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_first_payment_contract.pdf';
                    }
                }
                if ($pageNo == 5) {
                    if ($paymentType == 'First Payment' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                    
                        $pdf->Image($signature, 155, 76, 18, 15, 'PNG');
                        $pdf->Image($signature, 155, 116, 18, 15, 'PNG');
                        $pdf->SetXY(162, 144 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_first_payment_contract.pdf';
                    }
                    if ($paymentType == 'Second Payment' || $paymentType == 'Full-Outstanding Payment') {
                        
                        $pdf->Image($signature, 155, 156, 18, 15, 'PNG');
                        $pdf->Image($signature, 155, 203, 18, 15, 'PNG');
                        $pdf->SetXY(162, 232 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_second_payment_contract.pdf';
                    }

                }
                if ($pageNo == 6) {

                    if ($paymentType == 'Third Payment' || $paymentType == 'Full-Outstanding Payment') {
                        
                        $pdf->Image($signature, 155, 81, 18, 15, 'PNG');
                        $pdf->Image($signature, 155, 122, 18, 15, 'PNG');
                        $pdf->SetXY(162, 152 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_third_payment_contract.pdf';
                    }
                }
            }
            else if (strtolower($product->name) == Constant::malta) 
            {
                
                if ($pageNo == 2) {
                    if ($paymentType == 'First Payment' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                    
                        $pdf->Image($signature, 156, 72, 25, 13, 'PNG');
                        $pdf->SetXY(162, 101 );
                        $pdf->Write(2, date('d/m/Y'));
                        // $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_first_payment_contract.pdf';
                    }
                    if ($paymentType == 'Second Payment' || $paymentType == 'Full-Outstanding Payment') {
                        
                        $pdf->Image($signature, 156, 129, 25, 14, 'PNG');
                        $pdf->SetXY(162, 161 );
                        $pdf->Write(2, date('d/m/Y'));
                        // $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_second_payment_contract.pdf';
                    }
                    if ($paymentType == 'Third Payment' || $paymentType == 'Full-Outstanding Payment') {
                                
                        $pdf->Image($signature, 156,195, 25, 14, 'PNG');
                        $pdf->SetXY(162, 227 );
                        $pdf->Write(2, date('d/m/Y'));
                        // $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_third_payment_contract.pdf';
                    }
                }

                if ($pageNo == 4) {
                    if ($paymentType == 'First Payment' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                        $pdf->Image($signature, 48, 164, 20, 17, 'PNG');
                    }
                }
                if ($pageNo == 5) {
                    if ($paymentType == 'First Payment' || $paymentType == 'Full-Outstanding Payment') {
                        //signature
                    
                        $pdf->Image($signature, 154, 78, 25, 14, 'PNG');
                        $pdf->SetXY(162, 107 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_first_payment_contract.pdf';
                    }
                    if ($paymentType == 'Second Payment' || $paymentType == 'Full-Outstanding Payment') {
                        
                        $pdf->Image($signature, 154, 129, 25, 14, 'PNG');
                        $pdf->SetXY(162, 159 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_second_payment_contract.pdf';
                    }
                    if ($paymentType == 'Third Payment' || $paymentType == 'Full-Outstanding Payment') {
                        
                        $pdf->Image($signature, 154,181, 25, 14, 'PNG');
                        $pdf->SetXY(162, 210 );
                        $pdf->Write(2, date('d/m/Y'));

                        $fileName = Auth::user()->name . '_' . Auth::user()->middle_name . '_' . Auth::user()->sur_name . '_third_payment_contract.pdf';
                    }
                }
            }

        }
        if ($paymentType == 'First Payment') {
            $theString = $pdf->Output('S');
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_1st_signature, env('MEDIA_DISK'));
            } else {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_1st_signature, 'local');
            }
        }
        if ($paymentType == 'Second Payment') {
            $theString = $pdf->Output('S');
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_2nd_signature, env('MEDIA_DISK'));
            } else {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_2nd_signature, 'local');
            }
        }
        if ($paymentType == 'Third Payment') {
            $theString = $pdf->Output('S');
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_3rd_signature, env('MEDIA_DISK'));
            } else {

                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_3rd_signature, 'local');
            }
        }
        if ($paymentType == 'Full-Outstanding Payment') {
            $theString = $pdf->Output('S');
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_1st_signature, env('MEDIA_DISK'));
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_2nd_signature, env('MEDIA_DISK'));
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_3rd_signature, env('MEDIA_DISK'));
            } else {

                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_1st_signature, 'local');
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_2nd_signature, 'local');
                $applicant->addMediaFromString($theString)->usingFileName($fileName)->toMediaCollection(Applicant::$media_collection_main_3rd_signature, 'local');
            }
        }
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