<?php

namespace App\Helpers;
use Codedge\Fpdf\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use com\aspose\pdf\Document as Document;
use com\aspose\pdf\TextFragment as TextFragment;
use com\aspose\pdf\Position as Position;
use com\aspose\pdf\FontRepository as FontRepository;
use com\aspose\pdf\Color as Color;
use com\aspose\pdf\TextBuilder as TextBuilder;


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


    public static function mapDetails($destinationPath, $originathpath)
    {
        $pdf = new \setasign\Fpdi\Fpdi();
    
        // $pdf->AddPage();
        $pagecount = $pdf->setSourceFile('pdf/poland-low.pdf');
        // $template = $pdf->importPage(1);

        for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
       
            $pdf->AddPage();
            $template = $pdf->importPage($pageNo);
            $client = User::find(Auth::id());
            // use the imported page and place it at point 20,30 with a width of 170 mm
            $pdf->useTemplate($template, 10,10,200);
            // if($pageNo < $pagecount){
            //     $pdf->AddPage();

            // }
            //Select Arial italic 8
            $pdf->SetFont('Arial', 'B','9');
            $pdf->SetTextColor(0,0,0);
            // $pdf->SetFontSize(9);
            // $pdf->SetAutoPageBreak(0);
            if ($pageNo == 1){
                //Date
                $pdf->SetXY(28, 40 );
                $pdf->Write(2, date('d-m-yy'));

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
            }

            if ($pageNo == 4){
                //Sign
                // $pdf->SetXY(30, 235 );
                // $pdf->Write(2, "[SIGN HERE]");   
            }
        }
        $pdf->Output($originathpath, "F");

        
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
