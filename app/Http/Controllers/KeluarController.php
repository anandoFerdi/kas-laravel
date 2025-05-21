<?php

namespace App\Http\Controllers;

use App\Models\Keluar;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;


class KeluarController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $totalKeluar = DB::table('keluars')->select(
            DB::raw('sum(nominal) as jumlah')
        )->get();

        $keluar = Keluar::all();
        return view('uangKeluar.index', [
        'keluar' => $keluar,
        'totalKeluar' => $totalKeluar
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('uangKeluar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required',
            'nominal' => 'required',
            'keperluan' => 'required',
            'tanggal' => 'required',
            'nota' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:6144'
        ]);

        $nota = $request->file('nota');
        $nota->storeAs('public/nota', $nota->hashName());

        Keluar::create([
            'nama' => $request->nama,
            'nominal' => $request->nominal,
            'keperluan' => $request->keperluan,
            'tanggal' => $request->tanggal,
            'nota' => $nota->hashName()
        ]);

        return redirect()->route('uangKeluar.index')
                        ->with('success','Data created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        return view('uangKeluar.show',compact('keluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $keluar = Keluar::findOrFail($id);

    return view('uangKeluar.edit',compact('keluar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // $request->validate([
        //     'nama' => 'required',
        //     'nominal' => 'required',
        //     'keperluan' => 'required',
        //     'tanggal' => 'required',
        // ]);

        $keluar = Keluar::findOrFail($id);

        $request->validate([
            'nota' => 'image|mimes:jpg,png,jpeg,gif,svg|max:6144',
        ]);

        if($request->hasFile('nota')){

        $nota = $request->file('nota');
        $nota->storeAs('public/nota', $nota->hashName());

        Storage::delete('public/nota/'.$keluar->nota);

        $keluar->update([
            'nota' => $nota->hashName(),
            'nama' => $request->nama,
            'nominal' => $request->nominal,
            'keperluan' => $request->keperluan,
            'tanggal' => $request->tanggal
        ]);
        }else{
            $keluar->update([
                'nama' => $request->nama,
                'nominal' => $request->nominal,
                'keperluan' => $request->keperluan,
                'tanggal' => $request->tanggal
            ]);
        }

        return redirect()->route('uangKeluar.index')
                        ->with('success','Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $keluar = Keluar::findOrFail($id);
        $keluar->delete();
        Storage::delete('public/nota/'.$keluar->nota);

        return redirect()->route('uangKeluar.index')
                        ->with('success','Data deleted successfully');
    }

    public function export_pdf()
    {
        $keluar = Keluar::all();
        $pdf = Pdf::loadView('export_pdf.keluar', ['keluar' => $keluar]);
        return $pdf->download('uangKeluar-'.Carbon::now()->timestamp.'.pdf');

    }
}
