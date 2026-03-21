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
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ $subtitle }}
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('tasks.index') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Departments
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
                <h5 class="card-title">Detail Department</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <p>{{ $department->name }}</p>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <p>{{ $department->description }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Status</b></label>
                    <p>
                        @if ($department->status == 'pending')
                            <span class="badge bg-warning text-dark rounded-cs">Pending</span>
                        @else
                            <span class="badge bg-success rounded-cs">Done</span>
                        @endif
                    </p>
                </div>

                <div class="d-flex">
                    <a href="{{ route('departments.index') }}" class="btn btn-sm rounded-cs btn-secondary"><i
                            class="bi bi-arrow-left"></i> Back to
                        Department List</a>
                    <a href="{{ route('departments.edit', $department->id) }}"
                        class="btn btn-sm rounded-cs btn-primary ms-2"><i class="bi bi-pencil-square"></i> Edit
                        Department</a>
                </div>
            </div>
        </div>
    </section>
@endsection
