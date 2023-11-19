<?php

namespace App\Models;

use App\Models\User;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdraw extends Model
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
        'user_payment_id',
        'account_number',
        'bank_mobile_number',
        'bank_name',
        'ifsc_code',
        'status'
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
        'user_id',
        'amount',
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
