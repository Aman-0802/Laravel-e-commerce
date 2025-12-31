<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'category_id',
    'subcategory_id',
    'mrp',
    'buy_rate',
    'sell_rate',
    'batch_no',
    'short_description',
    'description',
    'image'
];

}