<?php

namespace App\Models;

use App\Models\User;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class paymentHistory extends Model
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
        'amount',
        'payment_mode',
        'user_payment_id',
        'status'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    protected $sortable = [
        'id',
        'user_id',
        'amount',
        'payment_mode',
        'user_payment_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function paymentStatus() {
        return [
            '1' => 'Pending',
            '2' => 'Verified',
            '3' => 'Decline'
        ];
    }
}
