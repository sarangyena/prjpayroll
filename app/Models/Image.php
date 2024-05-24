<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'userName',
        'image_name',
        'image_data',
        'qr_data',
    ]; 

    public function user(): BelongsTo
    {
        return $this->belongsTo(Employee::class);    
    }
}
