@extends('layouts.custom')

@section('title', 'User Management')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User Management/</span> Create</h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create Account</h5>
          </div>
          <div class="card-body">
            <form id="formAccountSettings" method="POST" action="{{ route('admin-user-create') }}">
                @csrf
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="username" class="form-label">Username <span class="required-field text-danger">*</span></label>
                  <input
                    class="form-control @error('username') is-invalid @enderror"
                    type="text"
                    id="username"
                    name="username"
                    value=""
                    autofocus
                    required
                  />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="password_default" class="form-label">Password Default</label>
                    <input
                      class="form-control"
                      type="text"
                      id="password_default"
                      name="password_default"
                      value="{{ $password_default }}"
                      autofocus
                      disabled
                    />
                  </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="status">Status</label>
                  <select id="status" name="status" class="select2 form-select @error('status') is-invalid @enderror">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
                <div class="mb-3 col-md-6">
                  <label for="role" class="form-label">Role</label>
                  <select id="role" name="role" class="select2 form-select text-capitalize @error('role') is-invalid @enderror">
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                  </select>
                </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Create</button>
                <a type="button" href="{{ route('admin-user-management')}}" class="btn btn-outline-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
@endsection