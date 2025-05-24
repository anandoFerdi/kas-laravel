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
        $current_year = Carbon::now()->year;
        $timeframe = $Request->get('timeframe', 'monthly');
        $now = Carbon::now();

        $dataKeluar = DB::table('keluars')->select([
                    DB::raw('sum(nominal) as jumlah'),
                    DB::raw('EXTRACT(MONTH from tanggal) as bulan'),
                    DB::raw('EXTRACT(YEAR from tanggal) as tahun')
                ])
                ->whereMonth('tanggal', '=', $current_month)
                ->whereYear('tanggal', '=', $current_year)
                ->groupBy(['tahun','bulan'])
                ->get();

        $dataMasuk = DB::table('masuks')->select([
                    DB::raw('sum(nominal) as jumlah'),
                    DB::raw('EXTRACT(MONTH from tanggal) as bulan'),
                    DB::raw('EXTRACT(YEAR from tanggal) as tahun')
                ])
                ->whereMonth('tanggal', '=', $current_month)
                ->whereYear('tanggal', '=', $current_year)
                ->groupBy(['tahun','bulan'])
                ->get();

        $totalKeluar = DB::table('keluars')->select(
                    DB::raw('sum(nominal) as jumlah')
                )->get();

        $totalMasuk = DB::table('masuks')->select(
                    DB::raw('sum(nominal) as jumlah')
                )->get();



        // Tentukan range berdasarkan waktu
        switch ($timeframe) {
            case 'yearly':
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
                break;
            case 'all':
                $start = Carbon::minValue(); // semua data
                $end = Carbon::maxValue();
                break;
            case 'monthly':
            default:
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
                break;
        }

        // Data untuk grafik
        $uangMasuk = DB::table('masuks')
            ->whereBetween('tanggal', [$start, $end])
            ->sum('nominal');

        $uangKeluar = DB::table('keluars')
            ->whereBetween('tanggal', [$start, $end])
            ->sum('nominal');

        return view('dashboard', [
            'dataKeluar' => $dataKeluar,
            'dataMasuk' => $dataMasuk,
            'totalKeluar' => $totalKeluar,
            'totalMasuk' => $totalMasuk,
            'uangMasuk' => $uangMasuk,
            'uangKeluar' => $uangKeluar,
            'timeframe' => $timeframe,

        ]);

    }




}
