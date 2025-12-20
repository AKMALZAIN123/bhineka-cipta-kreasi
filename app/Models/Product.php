<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'category',
        'size',
        'price',
        'description',
        'availability',
        'image_url',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    // Relationships
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function designUploads()
    {
        return $this->hasMany(DesignUpload::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function getSoldAttribute()
    {
        return (int) $this->orderItems()->sum('quantity');
    }
}