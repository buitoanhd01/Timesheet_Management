@extends('layouts.custom')

@section('title', 'Role Management')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Role Management </span></h4>
    <div class="row">
        <div class="col-xl">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Add New Role</h5>
              {{-- <small class="text-muted float-end">Default label</small> --}}
            </div>
            <div class="card-body">
              <form id="role_form">
                <div class="mb-3">
                  <label class="form-label" for="role_name">Role Name <span class="required-field text-danger">*</span></label>
                  <input type="text" class="form-control" id="role_name" name="role" placeholder="Admin" required/>
                </div>
                @foreach ($permission_list as $permission)
                <div class="form-check-inline mb-3 col-md-5">
                  <input type="checkbox" class="form-check-input" name="role_permission" value="{{ $permission->name }}" id="role_check_{{$permission->id}}">
                  <label class="form-check-label" for="role_check_{{$permission->id}}"> {{ $permission->name}} </label>
                </div>
                @endforeach
                
              </form>
              <button type="button" id="btn_add_role" class="btn btn-primary">Add</button>
            </div>
          </div>
        </div>
        <div class="col-xl">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">List Role</h5>
              {{-- <small class="text-muted float-end">Merged input group</small> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Role Name</th>
                          <th class="text-center">Actions</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0" id="role_list">
                        
                      </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/role.js') }}"></script>
@endsection