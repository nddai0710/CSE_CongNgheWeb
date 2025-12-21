<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Computer;

class Issue extends Model
{
    use HasFactory;

    // [cite: 10, 11, 12, 13, 14, 15]
    protected $fillable = [
        'computer_id',
        'reported_by',
        'reported_date',
        'description',
        'urgency',
        'status'
    ];

    // Quan hệ n-1: Một sự cố thuộc về một máy tính cụ thể
    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }
}
