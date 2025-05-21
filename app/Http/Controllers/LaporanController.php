<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Keluar;

class LaporanController extends Controller
{
    public function masuk()
    {
        $keluar = Keluar::all();
        return view('export_pdf.keluar', ['keluar' => $keluar]);

    }

}
