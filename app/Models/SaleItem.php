<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'discount',
        'subtotal',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
