<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainDealerPercentage extends Model
{
    use HasFactory;

    protected $table = 'dealer_percentage';

    protected $fillable = [
        'id', 'dealer_id', 'percentage', 'inc_dec'
    ];
}