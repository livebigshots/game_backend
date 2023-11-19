<?php

namespace App\Console\Commands;

use App\Models\GamePrediction;
use Illuminate\Console\Command;

class GamePredictionCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game-prediction:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Game Prediction data in every 2:30 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        GamePrediction::create([
            'game_type' => '1',
            'status' => '0',
            'result_color' => null
        ]);

        GamePrediction::create([
            'game_type' => '2',
            'status' => '0',
            'result_color' => null
        ]);
    }
}
