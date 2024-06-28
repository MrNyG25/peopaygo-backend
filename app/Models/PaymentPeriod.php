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

    public function timesheets()
    {
        return $this->belongsToMany(Timesheet::class, 'payment_period_timesheet')->withTimestamps();
    }
}
