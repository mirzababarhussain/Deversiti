@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Permission</h1>
    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Permission Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Permission</button>
    </form>
</div>
@endsection
