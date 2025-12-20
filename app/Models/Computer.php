<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Computer extends Model
{
    use HasFactory;

    protected $fillable = [
        'computer_name',
        'model',
        'operating_system',
        'processor',
        'memory',
        'available',
    ];

    // Quan hệ 1-n: Một máy tính có thể có nhiều báo cáo sự cố
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
