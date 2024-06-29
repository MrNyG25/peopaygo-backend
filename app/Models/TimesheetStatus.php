<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimesheetStatus extends Model
{
    use HasFactory;

    const TO_PAY = 1;
    const PAYED = 2;


    protected $fillable = [
        'name',
    ];
}
