@extends('layouts.app')
@section('content')
<form action="{{ route('issues.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Máy tính</label>
        <select name="computer_id" class="form-control">
            @foreach($computers as $c)
                <option value="{{ $c->id }}">{{ $c->computer_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Mức độ</label>
        <select name="urgency" class="form-control">
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="Open">Open</option>
            <option value="In Progress">In Progress</option>
            <option value="Resolved">Resolved</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Lưu</button>
</form>
@endsection 