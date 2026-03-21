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
                                <a href="{{ route('dashboard') }}">Dashboard</a>
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
                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="card-title mb-0">Employee List</h5>

                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select form-select-sm w-auto rounded-cs" id="bulan"
                                onchange="doReload()">
                                <option value="">-- Select Month --</option>
                                @foreach ($list_bulan as $key => $val)
                                    <option value="{{ $key }}" {{ request('b') == $key ? 'selected' : '' }}>
                                        {{ $val }}</option>
                                @endforeach
                            </select>

                            <select class="form-select form-select-sm w-auto rounded-cs" id="tahun"
                                onchange="doReload()">
                                <option value="">-- Select Year --</option>
                                @foreach ($list_tahun as $tahun)
                                    <option value="{{ $tahun }}" {{ request('t') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}</option>
                                @endforeach
                            </select>

                            <select class="form-select form-select-sm w-auto rounded-cs" id="status"
                                onchange="doReload()">
                                <option value="">-- Select Status --</option>
                                <option value="active" {{ request('a') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('a') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>

                            <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary rounded-cs">
                                <i class="bi bi-plus"></i> Add New
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <x-sweetalertsession />

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Salary</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody id="employee-table-body">
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->fullname }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->department->name }}</td>
                                    <td>{{ $employee->role->title ?? '-' }}</td>
                                    <td>
                                        @if ($employee->status == 'active')
                                            <span class="badge bg-success rounded-cs">Active</span>
                                        @else
                                            <span class="badge bg-danger rounded-cs">Inactive</span>
                                        @endif
                                    </td>
                                    <td>$ {{ number_format($employee->salary, 0, ',', '.') }}</td>
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
                                                    <a href="{{ route('employees.show', $employee->id) }}"
                                                        class="dropdown-item btn btn-sm text-white mb-1 rounded-cs"
                                                        style="background-color:#0dcaf0;">
                                                        <i class="bi bi-eye me-1"></i> View
                                                    </a>

                                                    <a href="{{ route('employees.edit', $employee->id) }}"
                                                        class="dropdown-item btn btn-sm text-white mb-1 rounded-cs"
                                                        style="background-color:#0d6efd;">
                                                        <i class="bi bi-pencil me-1"></i> Edit
                                                    </a>

                                                    <form id="form-delete-{{ $employee->id }}" method="POST"
                                                        class="d-inline"
                                                        action="{{ route('employees.destroy', $employee->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="dropdown-item btn btn-sm text-white rounded-cs"
                                                            data-swal-form-id="form-delete-{{ $employee->id }}"
                                                            style="background-color:#dc3545;">
                                                            <i class="bi bi-trash me-1"></i> Delete
                                                        </button>
                                                    </form>

                                                    <x-sweetalertaction form-id="form-delete-{{ $employee->id }}"
                                                        action="delete" />

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

    <script>
        function doReload() {
            let url = "{{ url('employees') }}";
            let query = "";

            let b = $('#bulan').val();
            let t = $('#tahun').val();
            let a = $('#status').val();

            if (b) query += (query ? '&' : '?') + 'b=' + b;
            if (t) query += (query ? '&' : '?') + 't=' + t;
            if (a) query += (query ? '&' : '?') + 'a=' + a;

            window.location.href = url + query;
        }
    </script>
