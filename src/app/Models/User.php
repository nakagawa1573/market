<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'email',
        'password',
        'stripe_account_id',
        'stripe_customer_id',
        'login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function favorite()
    {
        return $this->belongsToMany(Item::class, 'favorites');
    }

    public function comment()
    {
        return $this->belongsToMany(Item::class, 'comments');
    }

    public function purchase_history()
    {
        return $this->belongsToMany(Item::class, 'purchase_histories');
    }

    public function delivery_address()
    {
        return $this->hasOne(DeliveryAddress::class);
    }
}
