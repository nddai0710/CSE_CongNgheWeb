<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;

// Đường dẫn trang chủ chuyển hướng luôn vào danh sách sự cố
Route::get('/', function () {
    return redirect()->route('issues.index');
});

// Tạo trọn bộ 7 route CRUD (index, create, store, show, edit, update, destroy)
Route::resource('issues', IssueController::class);