<?php

namespace App\Helpers;
use Codedge\Fpdf\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $pdf->AddPage();

        $pagecount = $pdf->setSourceFile($destinationPath);
        $template = $pdf->importPage(1);
        $client = User::find(Auth::id());
        // use the imported page and place it at point 20,30 with a width of 170 mm
        $pdf->useTemplate($template);
                    
        //Select Arial italic 8
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY(90, 160);

        $pdf->Write(0, $client->phone_number);

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
