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
                <h5 class="card-title">Create Employee</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">

                        <label for="fullname" class="form-label">Fullname</label>
                        <input type="text"
                            class="form-control form-control-sm rounded-cs @error('fullname') is-invalid @enderror"
                            value="{{ old('fullname', $employee->fullname) }}" placeholder="Enter Task fullname"
                            maxlength="100" id="fullname" name="fullname">
                        @error('fullname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email"
                            class="form-control form-control-sm rounded-cs @error('email') is-invalid @enderror"
                            value="{{ old('email', $employee->email) }}" placeholder="Enter Email" id="email"
                            name="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" inputmode="numeric"
                            class="form-control form-control-sm rounded-cs @error('phone_number') is-invalid @enderror"
                            value="{{ old('phone_number', $employee->phone_number) }}" placeholder="Enter Phone Number"
                            id="phone_number" name="phone_number">
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" cols="30" rows="5"
                            class="form-control form-control-sm rounded-cs @error('address') is-invalid @enderror">{{ old('address', $employee->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Birth Date</label>
                        <input type="date"
                            class="form-control form-control-sm rounded-cs @error('birth_date') is-invalid @enderror date"
                            value="{{ old('birth_date', $employee->birth_date->format('Y-m-d')) }}"
                            placeholder="Select Birth Date" id="birth_date" name="birth_date">
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="hire_date" class="form-label">Hire Date</label>
                        <input type="date"
                            class="form-control form-control-sm rounded-cs @error('hire_date') is-invalid @enderror date"
                            value="{{ old('hire_date', $employee->hire_date->format('Y-m-d')) }}"
                            placeholder="Select Hire Date" id="hire_date" name="hire_date">
                        @error('hire_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select name="department_id" id="department_id"
                            class="form-select form-select-sm rounded-cs @error('department_id') is-invalid @enderror">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select name="role_id" id="role_id"
                            class="form-select form-select-sm rounded-cs @error('role_id') is-invalid @enderror">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ old('role_id', $employee->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->title }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status"
                            class="form-select form-select-sm rounded-cs @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="text" min="0"
                            class="form-control form-control-sm rounded-cs @error('salary') is-invalid @enderror"
                            value="{{ old('salary', $employee->salary) }}" placeholder="Enter Salary" id="salary"
                            name="salary">
                        @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <a href="{{ route('employees.index') }}" class="btn btn-sm rounded-cs btn-secondary"><i
                                class="bi bi-arrow-left"></i> Back to
                            Task List</a>
                        <button type="submit" class="btn btn-sm rounded-cs btn-primary"><i class="bi bi-upload"></i>
                            Update Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
