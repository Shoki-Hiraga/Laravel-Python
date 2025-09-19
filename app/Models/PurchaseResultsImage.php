<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseResultsImage extends Model
{
    protected $fillable = [
        'purchase_results_id',
        'k_number',
        'image_path',
    ];
}
