<form action="{{ route('issues.update', $issue->id) }}" method="POST">
    @csrf
    @method('PUT') <select name="computer_id" class="form-select" required>
        @foreach($computers as $computer)
            <option value="{{ $computer->id }}" {{ $computer->id == $issue->computer_id ? 'selected' : '' }}>
                {{ $computer->computer_name }} ({{ $computer->model }})
            </option>
        @endforeach
    </select>

    <input type="text" class="form-control" name="reported_by" value="{{ $issue->reported_by }}">
    
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>