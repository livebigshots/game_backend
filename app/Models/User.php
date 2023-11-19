<?php

namespace App\Models;

use App\Models\Wallet;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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
        'first_name',
        'last_name',
        'mobile_number',
        'email',
        'username',
        'password',
        'otp',
        'image',
        'reference_code',
        'by_reference_code',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'otp',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    protected $sortable = [
        'id',
        'first_name',
        'last_name',
        'username',
        'email',
    ];

    // Define an accessor for the image attribute
    public function getImageAttribute()
    {
        $disk = 'local'; // Replace with the name of your configured disk
        $relativePath = $this->attributes['image']; // 'image' is the name of your image attribute
        return asset('storage/users/'.$this->attributes['image']);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }
}
