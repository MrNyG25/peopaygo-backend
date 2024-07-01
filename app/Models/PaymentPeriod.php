<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'start_at',
        'end_at',
        'check_date',
    ];

    protected $casts = [
        'start_at' => 'date:d/m/Y',
        'end_at' => 'date:d/m/Y',
        'check_date' => 'date:d/m/Y',
        'created_at' => 'date:d/m/Y',
    ];

    public function timesheets()
    {
        return $this->belongsToMany(Timesheet::class, 'payment_period_timesheet')->withTimestamps();
    }
}
