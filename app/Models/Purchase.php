<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'price', 'total_price', 'date', 'company_name', 'pay_price', 'due_price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function category()
{
    return $this->product->category();
}
}
