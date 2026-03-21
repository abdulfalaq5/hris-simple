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
                                <a href="{{ route('employees.index') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Employees
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
                <h5 class="card-title">Detail Employee</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label"><b>Fullname</b></label>
                    <p>{{ $employees->fullname }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Email</b></label>
                    <p>{{ $employees->email }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Role</b></label>
                    <p>{{ $employees->role->title }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Department</b></label>
                    <p>{{ $employees->department->name }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Birth Date</b></label>
                    <p>{{ $employees->birth_date->format('d F Y') }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Hire Date</b></label>
                    <p>{{ $employees->hire_date->format('d F Y') }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Address</b></label>
                    <p>{{ $employees->address }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Status</b></label>
                    <p>
                        @if ($employees->status == 'active')
                            <span class="badge bg-success rounded-cs">Active</span>
                        @else
                            <span class="badge bg-danger rounded-cs">Inactive</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"><b>Salary</b></label>
                    <p>{{ number_format($employees->salary) }}</p>
                </div>
                <div class="d-flex">
                    <a href="{{ route('employees.index') }}" class="btn btn-sm rounded-cs btn-secondary"><i
                            class="bi bi-arrow-left"></i> Back to Employee List</a>
                    <a href="{{ route('employees.edit', $employees->id) }}"
                        class="btn btn-sm rounded-cs btn-primary ms-2"><i class="bi bi-pencil-square"></i> Edit Employee</a>
                </div>
            </div>
        </div>
    </section>
@endsection
