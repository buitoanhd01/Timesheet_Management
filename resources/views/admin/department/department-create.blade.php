@extends('layouts.custom')

@section('title', 'Department Management')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Department Management/</span> Create</h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create Department</h5>
          </div>
          <div class="card-body">
            <form id="formAccountSettings" method="POST" action="{{ route('admin-department-create') }}">
                @csrf
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="department_name" class="form-label">Department Name <span class="required-field text-danger">*</span></label>
                  <input
                    class="form-control @error('department_name') is-invalid @enderror"
                    type="text"
                    id="department_name"
                    name="department_name"
                    value=""
                    autofocus
                    required
                  />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="department_description" class="form-label">Department Description</label>
                    <input
                      class="form-control @error('department_description') is-invalid @enderror"
                      type="text"
                      id="department_description"
                      name="department_description"
                      value=""
                      autofocus
                    />
                </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Create</button>
                <a type="button" href="{{ route('admin-department-management')}}" class="btn btn-outline-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
@endsection