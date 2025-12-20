<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Issue extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'computer_id',
        'reported_by',
        'reported_date',
        'description',
        'urgency',
        'status',
    ];

    // Quan hệ ngược lại với Computer
    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }
}
