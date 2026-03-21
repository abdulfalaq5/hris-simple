@extends('layouts.dashboard')
@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Create Task</h3>
                    <p class="text-subtitle text-muted">
                        Handle employee tasks
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('tasks.index') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Tasks
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Create Task</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title</label>
                        <input type="text"
                            class="form-control form-control-sm rounded-cs @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" placeholder="Enter Task Title" maxlength="100" id="title"
                            name="title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Employee</label>
                        <select name="assigned_to" id="assigned_to"
                            class="form-select form-select-sm rounded-cs select2 @error('assigned_to') is-invalid @enderror"
                            value="{{ old('assigned_to') }}">
                            <option value="" disabled selected>Select Employee</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="datetime-local"
                            class="form-control form-control-sm rounded-cs @error('due_date') is-invalid @enderror date"
                            value="{{ old('due_date') }}" placeholder="Select Due Date" min="{{ now()->format('Y-m-d') }}"
                            max="{{ now()->addYear()->format('Y-m-d') }}" step="1" id="due_date" name="due_date">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status"
                            class="form-select form-select-sm rounded-cs @error('status') is-invalid @enderror"
                            value="{{ old('status') }}">
                            <option value="" disabled selected>Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="on progress">On Progress</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" cols="30" rows="5"
                            class="form-control form-control-sm rounded-cs @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm rounded-cs btn-secondary"><i
                                class="bi bi-arrow-left"></i> Back to
                            Task List</a>
                        <button type="submit" class="btn btn-sm rounded-cs btn-primary"><i class="bi bi-upload"></i>
                            Create Task</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
