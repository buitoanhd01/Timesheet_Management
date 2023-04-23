@extends('layouts.custom')

@section('title', 'User Management')


@section('content')
<input type="hidden" id="get_user_list" value="{{ route('get_user_list')}}"/>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User Management /</span> List User</h4>
    <div class="row d-flex justify-content-end">
      <div class="col-md-4 mb-2">
        <a class="btn btn-info float-end" href="{{ route('admin-user-show-create') }}">Add New User</a>
      </div>
    </div>
    <div class="card">
      <div class="card-header pt-2 pb-2">
        <label for="name_search">Search:</label>
        <input type="text" id="search_text" class="text-center border border-3 rounded-2">
      </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-layout-fixed">
              <thead class="sticky-top">
                <tr>
                  <th class="col-1">STT</th>
                  <th class="col-3">Employee Name</th>
                  <th class="col-4">Username</th>
                  <th class="col-2">Role</th>
                  <th class="col-3">Status</th>
                  <th class="col-2 text-center">Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" id="user_list">
                
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/user_management.js') }}"></script>
@endsection