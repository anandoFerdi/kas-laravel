<?php

namespace App\Http\Controllers;
use App\Models\Keluar;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $Request): View
    {
        $current_month = Carbon::now()->month;
        $dataKeluar = DB::table('keluars')->select([
                    DB::raw('sum(nominal) as jumlah'),
                    DB::raw('EXTRACT(MONTH from tanggal) as bulan'),
                    DB::raw('EXTRACT(YEAR from tanggal) as tahun')
                ])->groupBy(['bulan','tahun'])
                ->whereMonth('tanggal', '=', $current_month)
                ->get();

        $dataMasuk = DB::table('masuks')->select([
                    DB::raw('sum(nominal) as jumlah'),
                    DB::raw('EXTRACT(MONTH from tanggal) as bulan'),
                    DB::raw('EXTRACT(YEAR from tanggal) as tahun')
                ])->groupBy(['bulan','tahun'])
                ->whereMonth('tanggal', '=', $current_month)
                ->get();

        $totalKeluar = DB::table('keluars')->select(
                    DB::raw('sum(nominal) as jumlah')
                )->get();

        $totalMasuk = DB::table('masuks')->select(
                    DB::raw('sum(nominal) as jumlah')
                )->get();

        return view ('dashboard', [
            'dataKeluar' => $dataKeluar,
            'dataMasuk' => $dataMasuk,
            'totalKeluar' => $totalKeluar,
            'totalMasuk' => $totalMasuk,

        ]);
    }




}
