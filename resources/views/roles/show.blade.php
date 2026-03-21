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
                                <a href="{{ route('roles.index') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Roles
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
                <h5 class="card-title">Detail Role</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Title</label>
                    <p>{{ $role->title }}</p>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <p>{{ $role->description }}</p>
                </div>

                <div class="d-flex">
                    <a href="{{ route('roles.index') }}" class="btn btn-sm rounded-cs btn-secondary"><i
                            class="bi bi-arrow-left"></i> Back to
                        Role List</a>
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm rounded-cs btn-primary ms-2"><i
                            class="bi bi-pencil-square"></i> Edit
                        Role</a>
                </div>
            </div>
        </div>
    </section>
@endsection
