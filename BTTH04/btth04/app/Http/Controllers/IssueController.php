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
    public function index() {
    $issues = Issue::with('computer')->paginate(10); // Phân trang 10
    return view('issues.index', compact('issues'));
}

public function create() {
    $computers = Computer::all();
    return view('issues.create', compact('computers'));
}

public function store(Request $request) {
    $request->validate([
        'computer_id' => 'required',
        'reported_date' => 'required',
        'description' => 'required',
        'urgency' => 'required',
        'status' => 'required'
    ]);
    Issue::create($request->all());
    return redirect()->route('issues.index')->with('success', 'Thêm thành công!');
}

public function edit($id) {
    $issue = Issue::findOrFail($id);
    $computers = Computer::all();
    return view('issues.edit', compact('issue', 'computers'));
}

public function update(Request $request, $id) {
    $issue = Issue::findOrFail($id);
    $issue->update($request->all());
    return redirect()->route('issues.index')->with('success', 'Cập nhật thành công!');
}

public function destroy($id) {
    Issue::findOrFail($id)->delete();
    return redirect()->route('issues.index')->with('success', 'Xóa thành công!');
}
}
