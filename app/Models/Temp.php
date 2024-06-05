<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    use HasFactory;
    protected $fillable = [
        'pay_id',
        'user_name',
        'name',
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
    ]; 
}
