<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Keluar;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
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

        // chart data
        // $chart_options = [
        //     'chart_title' => 'Users by months',
        //     'report_type' => 'group_by_date',
        //     'model' => 'App\Models\Masuk',
        //     'group_by_field' => 'tanggal',
        //     'group_by_period' => 'month',
        //     'chart_type' => 'line',
        // ];
        // $chartMasuk = new LaravelChart($chart_options);

        return view ('home', [
            'dataKeluar' => $dataKeluar,
            'dataMasuk' => $dataMasuk,
            'totalKeluar' => $totalKeluar,
            'totalMasuk' => $totalMasuk,



        ]);
    }
}
