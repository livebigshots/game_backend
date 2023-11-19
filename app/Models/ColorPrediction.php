<?php

namespace App\Models;

use App\Models\User;
use App\Models\GamePrediction;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ColorPrediction extends Model
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
        'user_id',
        'game_id',
        'game_color',
        'result_color',
        'amount',
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
        'id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function game_prediction()
    {
        return $this->hasOne(GamePrediction::class, 'id', 'game_id');
    }
}
