@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Danh sách sự cố phòng máy</h5>
        <a href="{{ route('issues.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Thêm vấn đề mới
        </a>
    </div>
    <div class="card-body">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Mã vấn đề</th>
                        <th>Tên máy tính</th>
                        <th>Tên phiên bản</th>
                        <th>Người báo cáo</th>
                        <th>Thời gian báo cáo</th>
                        <th>Mức độ</th>
                        <th>Trạng thái</th>
                        <th style="width: 150px">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($issues as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        
                        <td>{{ $issue->computer->computer_name }}</td>
                        <td>{{ $issue->computer->model }}</td>
                        
                        <td>{{ $issue->reported_by ?? 'N/A' }}</td>
                        
                        <td>{{ \Carbon\Carbon::parse($issue->reported_date)->format('d/m/Y H:i') }}</td>
                        
                        <td>
                            @if($issue->urgency == 'High')
                                <span class="badge bg-danger">Cao</span>
                            @elseif($issue->urgency == 'Medium')
                                <span class="badge bg-warning text-dark">Trung bình</span>
                            @else
                                <span class="badge bg-info text-dark">Thấp</span>
                            @endif
                        </td>
                        
                        <td>
                            @if($issue->status == 'Open')
                                <span class="badge bg-secondary">Mở</span>
                            @elseif($issue->status == 'In Progress')
                                <span class="badge bg-primary">Đang xử lý</span>
                            @else
                                <span class="badge bg-success">Đã giải quyết</span>
                            @endif
                        </td>
                        
                        <td>
                            <a href="{{ route('issues.edit', $issue->id) }}" class="btn btn-warning btn-sm" title="Cập nhật">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            
                            <form action="{{ route('issues.destroy', $issue->id) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa vấn đề này không? Hành động này không thể hoàn tác!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $issues->links() }} 
        </div>
    </div>
</div>
@endsection