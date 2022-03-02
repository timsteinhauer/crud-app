<?php

namespace App\Models\Customer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{

    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
    ];


    //
    // Relations
    //
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "customer_user");
    }

}
