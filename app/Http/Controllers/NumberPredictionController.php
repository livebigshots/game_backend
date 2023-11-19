<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GamePrediction;
use App\Models\NumberPrediction;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class NumberPredictionController extends Controller
{
    public function index(Request $request) {
        $numberData = new GamePrediction;
        if (!empty($request->search)) {
            $numberData = $numberData->where(function ($query) use ($request) {
                $query->orWhere('id', 'LIKE', '%'. $request->search. '%');
            });
        }

        $numberData = $numberData->where('game_type', '2')->orderBy('id', 'DESC')->sortable()->limit(10)->get();

        $gameData = GamePrediction::orderBy('id','desc')->where('game_type', 2)->first();

        $numberWithTotalAmount = NumberPrediction::selectRaw("result_number, game_number, IFNULL(SUM(amount), 0.00) as total_amount")
                    ->where('game_id', $gameData->id)
                    ->groupBy('game_number')
                    ->groupBy('result_number')
                    ->get();

        return view('number_prediction.number-prediction-list',
        [
            'numberData' => $numberData,
            'searchData' => $request->search,
            'numberWithTotalAmount' => $numberWithTotalAmount,
            'runningGameId' => $gameData->id,
            'uri' => \Request::route()->uri
       ]);
    }

    public function gameEdit(Request $request) {
        $gameData = GamePrediction::find($request->id);
        if($gameData) {

            $users = NumberPrediction::where('game_id', $gameData->id)->sortable()->paginate(env('ITEMS_PER_PAGE'));
            $numberWithTotalAmount = NumberPrediction::selectRaw("game_number, IFNULL(SUM(amount), 0.00) as total_amount")
                    ->where('game_id', $gameData->id)
                    ->groupBy('game_number')
                    ->paginate(env('ITEMS_PER_PAGE'));

            return view('number_prediction.number-prediction-detail',
            [
                'numberData' => $gameData,
                'users' => $users,
                'searchData' => $request->search,
                'numberWithTotalAmount' => $numberWithTotalAmount,
                'uri' => \Request::route()->uri
           ]);
        }
    }

    public function updateNumber(Request $request) {
        $gameData = GamePrediction::find($request->id);
        if($gameData && $gameData->status != 2) {
            $gameData->update(['result_color' => $request->result_number]);
            NumberPrediction::where('game_id', $request->id)->update(['result_number' => $request->result_number]);
            Session::flash('message', 'Result Number Updated Successfully');
            return back();
        }
        Session::flash('message', 'You can not update the number after game end');
        return back();
    }
}
