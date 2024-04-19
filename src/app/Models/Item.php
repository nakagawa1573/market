<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status_id',
        'name',
        'brand',
        'price',
        'description',
        'img',
    ];

    public function category()
    {
        return $this->belongsToMany(Category::class, 'item_categories');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorite()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function comment()
    {
        return $this->belongsToMany(User::class, 'Comments');
    }

    public function purchase_history()
    {
        return $this->belongsTo(User::class, 'purchase_histories');
    }
}
