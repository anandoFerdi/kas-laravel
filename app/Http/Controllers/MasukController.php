<?php

namespace App\Http\Controllers;

use App\Models\Masuk;
use Illuminate\View\View;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class MasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $totalMasuk = DB::table('masuks')->select(
                    DB::raw('sum(nominal) as jumlah')
                    )->get();

        $masuk = Masuk::all();
        return view('uangMasuk.index', [
        'masuk' => $masuk,
        'totalMasuk' => $totalMasuk
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('uangMasuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nominal' => 'required',
            'sumber' => 'required',
            'tanggal' => 'required',
        ]);

        Masuk::create($request->all());

        return redirect()->route('uangMasuk.index')
                        ->with('success','Data created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        return view('uangMasuk.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {

    $masuk = Masuk::findOrFail($id);

    return view('uangMasuk.edit',compact('masuk'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // $request->validate([
        //     'nominal' => 'required',
        //     'sumber' => 'required',
        //     'tanggal' => 'required',
        // ]);

        $masuk = Masuk::findOrFail($id);

        $masuk->update($request->all());

        return redirect()->route('uangMasuk.index')
                        ->with('success','Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $masuk = Masuk::findOrFail($id);
        $masuk->delete();

        return redirect()->route('uangMasuk.index')
                        ->with('success','Data deleted successfully');
    }

    public function export_pdf()
    {
        $masuk = Masuk::all();
        $pdf = Pdf::loadView('export_pdf.masuk', ['masuk' => $masuk]);
        return $pdf->download('uangMasuk-'.Carbon::now()->timestamp.'.pdf');

    }


}
