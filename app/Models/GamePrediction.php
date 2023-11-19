<?php

namespace App\Models;

use App\Models\ColorPrediction;
use App\Models\NumberPrediction;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GamePrediction extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'game_type',
        'status',
        'result_color',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    protected $sortable = [
        'game_type',
        'status',
        'result_color',
    ];

    public static function colorArray() {
        return [
            '1' => 'red',
            '2' => 'violate',
            '3' => 'green',
            '4' => 'orange'
        ];
    }

    public static function randomColor() {
        $colors = self::colorArray();
        $randomKey = array_rand(self::colorArray());
        $randomColor = $colors[$randomKey];
        return $randomColor;
    }

    public static function numberArray() {
        return [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10'
        ];
    }

    public static function randomNumber() {
        $numbers = self::numberArray();
        $randomKey = array_rand(self::numberArray());
        $randomNumber = $numbers[$randomKey];
        return $randomNumber;
    }

    public static function totalColorPredictUser($id) {
        $color = ColorPrediction::where('game_id', $id)->count();
        return $color;
    }

    public static function totalNumberPredictUser($id) {
        $numbers = NumberPrediction::where('game_id', $id)->count();
        return $numbers;
    }

    public static function totalWin($id) {
       $totalwin =  ColorPrediction::where('game_id', $id)
                    ->whereColumn('game_color', '=', 'result_color')
                    ->count();

        return $totalwin;
    }

    public static function totalLose($id) {
        $totalwin =  ColorPrediction::where('game_id', $id)
                     ->whereColumn('game_color', '!=', 'result_color')
                     ->count();

         return $totalwin;
    }

    public static function totalNumberWin($id) {
        $totalwin =  NumberPrediction::where('game_id', $id)
                     ->whereColumn('game_number', '=', 'result_number')
                     ->count();

         return $totalwin;
     }

     public static function totalNumberLose($id) {
         $totalwin =  NumberPrediction::where('game_id', $id)
                      ->whereColumn('game_number', '!=', 'result_number')
                      ->count();

          return $totalwin;
     }
}
