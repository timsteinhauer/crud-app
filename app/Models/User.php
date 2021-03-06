<?php

namespace App\Models;

use App\Models\Basics\Salutation;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $fillable = [
        'is_operator',
        'name',
        'email',
        'password',
        'customer_id',
        'salutation_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];


    protected $appends = [
        'profile_photo_url',
    ];

    protected $with = [
        'salutation',
        'customer',
    ];

    //
    // Relations
    //
    public function salutation(): BelongsTo
    {
        return $this->belongsTo(Salutation::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }


    //
    // Business Logic
    //

    public static function randomPassword(): string
    {
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%&!$%&!$%&!$%&');
        return substr($random, 0, 12);
    }

    public static function randomPasswordHash(): string
    {
        return Hash::make( self::randomPassword() );
    }
}
