<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $title = $request->title;

        $sales = Sale::get();

        $no = 0;
        $pdf = Pdf::loadView('report',compact(['sales','no','title']));

        return $pdf->stream(Str::slug($title).'.pdf');
    }
}
