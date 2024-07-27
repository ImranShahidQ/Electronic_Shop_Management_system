<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldCustomer extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'phone_number', 'address', 'total_price', 'product_name', 'pay_price', 'due_price'];
}
