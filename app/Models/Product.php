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
    ];

    protected $casts = [
        'price' => 'float',
    ];

    // Relationships
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id', 'product_id');
    }

    public function designUploads()
    {
        return $this->hasMany(DesignUpload::class, 'product_id', 'product_id');
    }
}