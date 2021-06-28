<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoansPackage extends Model
{
    use HasFactory;

    protected $table = 'loans_packages';

    protected $fillable = [
        'name',
        'frequency',
        'interest_rate',
        'status',
        'is_deleted',
    ];
}
