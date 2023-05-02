@extends('layouts.custom')

@section('title', 'My Account')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">My Account/</span></h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">My Account</h5>
          </div>
          <div class="card-body">
            <form id="formAccountSettings" method="POST" action="{{ route('admin-user-edit', ['id' => $user->id]) }}">
                @csrf
                @method('PUT')
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="email" class="form-label">Username</label>
                  <input
                    class="form-control"
                    type="text"
                    id="email"
                    name="email"
                    value="{{ $user->username }}"
                    disabled
                  />
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="status">Status</label>
                  <select disabled id="status" name="status" class="select2 form-select @error('status') is-invalid @enderror">
                    <option value="active" @if($user->status == "active") selected @endif>Active</option>
                    <option value="inactive" @if($user->status == "inactive") selected @endif>Inactive</option>
                  </select>
                </div>
                <div class="mb-3 col-md-6">
                  <label for="role" class="form-label">Role</label>
                  <select disabled id="role" name="role" class="select2 form-select text-capitalize @error('role') is-invalid @enderror">
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" @if($role_name == $role->name) selected @endif>{{ $role->name }}</option>
                    @endforeach
                  </select>
                </div>
              <div class="mt-2">
                <button type="button" class="btn btn-primary me-2" id="show_change_password">Change Password</button>
                {{-- <a type="button" href="{{ route('admin-user-management')}}" class="btn btn-outline-secondary">Cancel</a> --}}
                {{-- <button type="submit" class="btn btn-warning me-2 float-end">Reset Password</button> --}}
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
@endsection