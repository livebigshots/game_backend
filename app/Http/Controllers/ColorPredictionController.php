<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GamePrediction;
use App\Models\ColorPrediction;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ColorPredictionController extends Controller
{
    public function index(Request $request) {
        $colorData = new GamePrediction;
        if (!empty($request->search)) {
            $colorData = $colorData->where(function ($query) use ($request) {
                $query->orWhere('id', 'LIKE', '%'. $request->search. '%');
            });
        }

        $colorData = $colorData->where('game_type', '1')->orderBy('id', 'DESC')->sortable()->limit(10)->get();

        $gameData = GamePrediction::orderBy('id','desc')->where('game_type', 1)->first();

        $colorsWithTotalAmount = ColorPrediction::selectRaw("CASE
                WHEN game_color = 'red' THEN 1
                WHEN game_color = 'violet' THEN 2
                WHEN game_color = 'green' THEN 3
                WHEN game_color = 'orange' THEN 4
                ELSE 5
            END AS color_order, game_color, result_color,IFNULL(SUM(amount), 0.00) as total_amount")
                ->where('game_id', $gameData->id)
                ->groupBy('game_color')
                ->groupBy('result_color')
                ->orderBy('color_order')
                ->paginate(env('ITEMS_PER_PAGE'));

        // dd($colorsWithTotalAmount);

        return view('color_prediction.color-prediction-list',
        [
            'colorData' => $colorData,
            'colorsWithTotalAmount' => $colorsWithTotalAmount,
            'runningGameId' => $gameData->id,
            'searchData' => $request->search,
            'uri' => \Request::route()->uri
       ]);
    }

    public function gameEdit(Request $request) {
        $gameData = GamePrediction::find($request->id);
        if($gameData) {

            $users = ColorPrediction::where('game_id', $gameData->id)->sortable()->paginate(env('ITEMS_PER_PAGE'));
            $colorsWithTotalAmount = ColorPrediction::selectRaw("CASE
                    WHEN game_color = 'red' THEN 1
                    WHEN game_color = 'violet' THEN 2
                    WHEN game_color = 'green' THEN 3
                    WHEN game_color = 'orange' THEN 4
                    ELSE 5
                END AS color_order, game_color, IFNULL(SUM(amount), 0.00) as total_amount")
                    ->where('game_id', $gameData->id)
                    ->groupBy('game_color')
                    ->orderBy('color_order')
                    ->paginate(env('ITEMS_PER_PAGE'));

            return view('color_prediction.color-prediction-detail',
            [
                'colorData' => $gameData,
                'users' => $users,
                'searchData' => $request->search,
                'colorsWithTotalAmount' => $colorsWithTotalAmount,
                'uri' => \Request::route()->uri
           ]);
        }
    }

    public function updateColor(Request $request) {

        $gameData = GamePrediction::find($request->id);
        if($gameData && $gameData->status != 2) {
            $gameData->update(['result_color' => $request->result_color]);
            ColorPrediction::where('game_id', $request->id)->update(['result_color' => $request->result_color]);
            Session::flash('message', 'Result Color Updated Successfully');
            return back();
        }
        Session::flash('message', 'You can not update the color after game end');
        return back();
    }
}
