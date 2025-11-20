<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignUpload extends Model
{
    use HasFactory;

    protected $primaryKey = 'design_id';

    protected $fillable = [
        'user_id',
        'product_id',
        'file_name',
        'upload_date',
    ];

    protected $casts = [
        'upload_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}