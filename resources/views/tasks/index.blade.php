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
        <h1>Category List</h1>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="text" name="name" class="form-control" placeholder="New Category" required>
                <input type="text" name="slug" class="form-control" placeholder="Slug">
                <input type="text" name="description" class="form-control" placeholder="Description">
                <button class="btn btn-success" type="submit"><i class="fa fa-plus-circle"></i> Add Category</button>
            </div>
        </form>

        <ul class="list-group-category">
            @foreach($categories as $category)
                <li class="category-list">
                    {{ $category->name   }}
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
