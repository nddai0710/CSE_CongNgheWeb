<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Computer extends Model
{
    use HasFactory;

    // Khai báo các cột được phép gán dữ liệu (Mass Assignment)
    protected $fillable = [
        'computer_name',      // Tên máy tính [cite: 4]
        'model',              // Tên phiên bản [cite: 5]
        'operating_system',   // Hệ điều hành [cite: 5]
        'processor',          // Bộ vi xử lý [cite: 6]
        'memory',             // Bộ nhớ RAM [cite: 6]
        'available'           // Trạng thái hoạt động [cite: 7]
    ];

    // Quan hệ 1-n: Một máy tính có thể có nhiều báo cáo sự cố
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
