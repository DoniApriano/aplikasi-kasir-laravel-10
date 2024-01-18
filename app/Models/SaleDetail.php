<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillabel = [
        'sale_id',
        'product_id',
        'amount_product',
        'sub_total',
        'subtotal',
    ];
}
