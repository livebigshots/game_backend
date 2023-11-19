<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\GamePrediction;
use Lang;
use App\Http\Controllers\Api\BaseController as BaseController;

class GamePredictionController extends BaseController
{
    public function getGame(Request $request) {
        $gameData = GamePrediction::where('game_type', $request->type)->orderBy('id', 'DESC')->first();

        if($gameData) {
            $gameData->update(['status' => '1']);
            return $this->sendResponse($gameData, Lang::get('messages.GAME_FOUND_SUCCESSFULLY'));
        }
        return $this->sendResponse((Object)[], Lang::get('messages.GAME_NOT_FOUND_SUCCESSFULLY'));
    }

    public function getHistory(Request $request) {

        $gameData = GamePrediction::where('game_type', $request->type)->orderBy('id', 'DESC')->paginate(10);

        if($gameData) {
            // $gameData->update(['status' => '1']);
            return $this->sendResponse($gameData, Lang::get('messages.GAME_FOUND_SUCCESSFULLY'));
        }
        return $this->sendResponse((Object)[], Lang::get('messages.GAME_NOT_FOUND_SUCCESSFULLY'));
    }
}
