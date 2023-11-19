<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Models\ColorPrediction;
use App\Models\NumberPrediction;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $totalUser = User::count();
        $totalColorPayment = ColorPrediction::sum('amount');
        $totalNumberPayment = NumberPrediction::sum('amount');
        $totalWithdraw = Withdraw::sum('amount');
        return view('dashboard', [
            'totalUser' => $totalUser,
            'totalColorPayment' => $totalColorPayment,
            'totalNumberPayment' => $totalNumberPayment,
            'totalWithdraw' => $totalWithdraw
        ]);
    }
}
