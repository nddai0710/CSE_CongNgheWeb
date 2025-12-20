@extends('layouts.app')

@section('content')
<div class="card shadow mb-4" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Thêm vấn đề mới</h5>
    </div>
    <div class="card-body">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('issues.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="computer_id" class="form-label">Máy tính gặp sự cố</label>
                <select name="computer_id" class="form-select" required>
                    <option value="">-- Chọn máy tính --</option>
                    @foreach($computers as $computer)
                        <option value="{{ $computer->id }}">{{ $computer->computer_name }} ({{ $computer->model }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="reported_by" class="form-label">Người báo cáo</label>
                <input type="text" class="form-control" name="reported_by" maxlength="50">
            </div>

            <div class="mb-3">
                <label for="reported_date" class="form-label">Thời gian báo cáo</label>
                <input type="datetime-local" class="form-control" name="reported_date" required value="{{ date('Y-m-d\TH:i') }}">
            </div>

            <div class="mb-3">
                <label for="urgency" class="form-label">Mức độ sự cố</label>
                <select name="urgency" class="form-select" required>
                    <option value="Low">Low (Thấp)</option>
                    <option value="Medium">Medium (Trung bình)</option>
                    <option value="High">High (Cao)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái hiện tại</label>
                <select name="status" class="form-select" required>
                    <option value="Open">Open (Mở)</option>
                    <option value="In Progress">In Progress (Đang xử lý)</option>
                    <option value="Resolved">Resolved (Đã giải quyết)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả chi tiết</label>
                <textarea class="form-control" name="description" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Thêm mới</button>
            <a href="{{ route('issues.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
@endsection