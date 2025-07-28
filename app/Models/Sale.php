<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'sale_date',
        'total_amount'
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
}
