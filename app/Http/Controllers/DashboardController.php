<?php

namespace App\Http\Controllers;

use App\Models\Sell;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function home()
    {
        $now = Carbon::now();

        $first_of_week = Carbon::today()->startOfweek(6);
        $first_of_month = Carbon::today()->startOfMonth();

        $today = Sell::where('date', '>', date('Y-m-d 00:00:00'))->sum('total');
        $week = Sell::where('date', '>', $first_of_week)->sum('total');
        $month = Sell::where('date', '>', $first_of_month)->sum('total');

        $best_sand = Sell::selectRaw('sand_id,SUM(weight) as sum')->groupBy('sand_id')->orderBy('sum', 'desc')->where('date', '>', $first_of_month)->first();

        $best_user = Sell::selectRaw('user_id,SUM(total) as sum')->groupBy('user_id')->orderBy('sum', 'desc')->where('date', '>', $first_of_month)->first();

        $calculation = [
            "today"     => $today,
            "week"      => $week,
            "month"     => $month,
            "best_sand" => $best_sand,
            "best_user" => $best_user,
        ];

        return view('dashboard.index', compact('calculation'));
    }

}
