<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'product_amount',
        'expiry_date',
        'category_id',
    ];
    public function files()
    {
        return $this->morphMany(File::class, 'model');
    }
}
