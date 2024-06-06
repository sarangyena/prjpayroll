<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payslip extends Model
{
    use HasFactory;
    protected $fillable = [
        'pay_id',
        'hired',
        'user_name',
        'week_id',
        'month_id',
        'year_id',
        'name',
        'job',
        'pay_period',
        'rate',
        'days',
        'late',
        'salary',
        'rph',
        'hrs',
        'otpay',
        'holiday',
        'philhealth',
        'sss',
        'advance',
        'gross',
        'deduction',
        'net',
        'remarks',
    ]; 
    public function emp(): BelongsTo
    {
        return $this->belongsTo(Employee::class);    
    }
}
