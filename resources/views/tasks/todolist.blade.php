<!-- resources/views/tasks/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>ToDo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/solid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/main.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1>To Do List</h1>
        <ul>
            <li class="text-secondary">High (Critical)	- Requires immediate action</li>
            <li class="text-secondary">Medium (Important) - Can wait a few hours or a day</li>
            <li class="text-secondary">Low	(Minor) - Can wait until other tasks are resolved</li>
        </ul>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="text" name="title" class="form-control" placeholder="New Task" required>
                <select name="category" id="category" class="dropdown">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="priority" id="priority" class="dropdown">
                    @foreach($priorities as $prio)
                        <option value="{{ $prio->id }}">{{ $prio->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-success" type="submit">Add Task</button>
            </div>
        </form>

        <ul class="list-group">
            @foreach($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_completed" {{ $task->is_completed ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label {{ $task->is_completed ? 'text-decoration-line-through' : '' }}">
                                {{ $task->title }}
                            </label>
                        </div>
                    </form>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-dark btn-sm" disabled>{{ $task->category_name }}</button>
                        <button type="button" class="btn
                            @if($task->priority_name == "High")
                                btn-danger
                            @elseif($task->priority_name == "Medium")
                                btn-warning
                            @else
                                btn-info
                            @endif btn-sm" disabled>{{ $task->priority_name }}</button>
                        <button class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
