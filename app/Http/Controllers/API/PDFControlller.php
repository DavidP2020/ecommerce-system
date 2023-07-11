<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class PDFControlller extends Controller
{
    // public function exportPDF()
    // {
    //     $pdf = PDF::loadView('pdf');
    //     $path = public_path('pdf/');
    //     $fileName = time() . '.' . 'pdf';
    //     $pdf->save($path . '/' . $fileName);
    //     $pdf = public_path('pdf/' . $fileName);
    //     return $pdf->download('invoice.pdf');
    // }
}
