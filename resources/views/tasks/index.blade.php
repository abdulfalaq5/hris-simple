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
                                Index
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title">Task List</h5>
                        @if (session('role') == 'HR')
                            <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary ms-auto rounded-cs"><i
                                    class="bi bi-plus"></i>
                                Add New</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">

                    <x-sweetalertsession />

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Assigned To</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->employee->fullname ?? 'N/A' }}</td>
                                    <td>{{ $task->due_date->format('Y-m-d') }}</td>
                                    <td>
                                        @if ($task->status == 'done')
                                            <span class="badge bg-success rounded-cs">Done</span>
                                        @elseif ($task->status == 'pending')
                                            <span class="badge bg-warning rounded-cs">Pending</span>
                                        @else
                                            <span class="badge bg-secondary rounded-cs">{{ $task->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group mb-1">
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm rounded-cs dropdown-toggle me-1"
                                                    type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton"
                                                    style="min-width: 40px;">
                                                    <a href="{{ route('tasks.show', $task->id) }}"
                                                        class="dropdown-item btn btn-sm text-white mb-1 rounded-cs"
                                                        style="background-color:#0dcaf0;">
                                                        <i class="bi bi-eye me-1"></i> View
                                                    </a>
                                                    @if ($task->status == 'pending')
                                                        <a href="{{ route('tasks.done', $task->id) }}"
                                                            class="dropdown-item btn btn-sm text-white mb-1 rounded-cs"
                                                            style="background-color:#198754;">
                                                            <i class="bi bi-check me-1"></i> Mark as Done
                                                        </a>
                                                    @else
                                                        <a href="{{ route('tasks.pending', $task->id) }}"
                                                            class="dropdown-item btn btn-sm text-dark mb-1 rounded-cs"
                                                            style="background-color:#ffc107;">
                                                            <i class="bi bi-x me-1"></i> Mark as Pending
                                                        </a>
                                                    @endif
                                                    @if (session('role') == 'HR')
                                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                                            class="dropdown-item btn btn-sm text-white mb-1 rounded-cs"
                                                            style="background-color:#0d6efd;">
                                                            <i class="bi bi-pencil me-1"></i> Edit
                                                        </a>

                                                        <form id="form-delete-{{ $task->id }}" method="POST"
                                                            class="d-inline"
                                                            action="{{ route('tasks.destroy', $task->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="dropdown-item btn btn-sm text-white rounded-cs"
                                                                data-swal-form-id="form-delete-{{ $task->id }}"
                                                                style="background-color:#dc3545;">
                                                                <i class="bi bi-trash me-1"></i> Delete
                                                            </button>
                                                        </form>

                                                        <x-sweetalertaction form-id="form-delete-{{ $task->id }}"
                                                            action="delete" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </section>
    @endsection
