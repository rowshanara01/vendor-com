<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'json',
    ];

     public function getRouteKeyName()
    {
        return 'slug';
    }


    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeConditions($query, $type)
    {
        return $query->where('conditions', $type);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'active');
    }
    public function scopeSold($query)
    {
        return $query->where('sale', 1);
    }

    public function productWishlistUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
