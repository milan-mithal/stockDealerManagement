<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerPercentage extends Model
{
    use HasFactory;

    protected $table = 'sub_dealer_pricing';

    protected $fillable = [
        'id', 'dealer_id', 'sub_dealer_id', 'percentage'
    ];
}
