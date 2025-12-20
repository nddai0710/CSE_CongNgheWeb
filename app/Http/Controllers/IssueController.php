<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\Computer;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Sử dụng with('computer') để tránh lỗi N+1 Query (tối ưu hiệu năng)
        // paginate(10) theo yêu cầu đề bài 
        $issues = Issue::with('computer')->orderBy('id', 'desc')->paginate(10);
        
        return view('issues.index', compact('issues'));
    }

    /**
     * Hiển thị form thêm mới
     */
    public function create()
    {
        // Lấy danh sách máy tính để hiển thị trong thẻ <select>
        $computers = Computer::all();
        return view('issues.create', compact('computers'));
    }

    /**
     * Xử lý lưu dữ liệu mới vào CSDL
     */
    public function store(Request $request)
    {
        // Validate dữ liệu 
        $request->validate([
            'computer_id'   => 'required|exists:computers,id',
            'reported_by'   => 'nullable|string|max:50',
            'reported_date' => 'required|date',
            'description'   => 'required|string',
            'urgency'       => 'required|in:Low,Medium,High', // Chỉ nhận 3 giá trị này
            'status'        => 'required|in:Open,In Progress,Resolved',
        ]);

        // Tạo mới
        Issue::create($request->all());

        return redirect()->route('issues.index')
                         ->with('success', 'Thêm sự cố thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa
     */
    public function edit(string $id)
    {
        $issue = Issue::findOrFail($id);
        $computers = Computer::all(); // Cần danh sách máy để chọn lại nếu muốn đổi
        
        return view('issues.edit', compact('issue', 'computers'));
    }

    /**
     * Cập nhật dữ liệu
     */
    public function update(Request $request, string $id)
    {
        $issue = Issue::findOrFail($id);

        // Validate lại cho chắc 
        $request->validate([
            'computer_id'   => 'required|exists:computers,id',
            'reported_by'   => 'nullable|string|max:50',
            'reported_date' => 'required|date',
            'description'   => 'required|string',
            'urgency'       => 'required|in:Low,Medium,High',
            'status'        => 'required|in:Open,In Progress,Resolved',
        ]);

        $issue->update($request->all());

        return redirect()->route('issues.index')
                         ->with('success', 'Cập nhật thông tin thành công!');
    }

    /**
     * Xóa dữ liệu
     */
    public function destroy(string $id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete();

        return redirect()->route('issues.index')
                         ->with('success', 'Đã xóa sự cố thành công!');
    }
}
