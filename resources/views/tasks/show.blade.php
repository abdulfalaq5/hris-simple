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
                    <h3>Task</h3>
                    <p class="text-subtitle text-muted">
                        Detail employee tasks
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
                                Detail
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
                <h5 class="card-title">Detail Task</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label"><b>Title</b></label>
                    <p>{{ $task->title }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Assigned To</b></label>
                    <p>{{ $task->employee->fullname }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Due Date</b></label>
                    <p>{{ $task->due_date->format('d F Y') }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Status</b></label>
                    <p>
                        @if ($task->status == 'pending')
                            <span class="badge bg-warning text-dark rounded-cs">Pending</span>
                        @else
                            <span class="badge bg-success rounded-cs">Done</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Description</b></label>
                    <p>{{ $task->description }}</p>
                </div>
                <div class="d-flex">
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm rounded-cs btn-secondary"><i
                            class="bi bi-arrow-left"></i> Back to Task List</a>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm rounded-cs btn-primary ms-2"><i
                            class="bi bi-pencil-square"></i> Edit Task</a>
                </div>
            </div>
        </div>
    </section>
@endsection
