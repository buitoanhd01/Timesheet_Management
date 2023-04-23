@extends('layouts.custom')

@section('title', 'Employee Management')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Employee Management /</span> List Employee</h4>
    <div class="row d-flex justify-content-end">
      <div class="col-md-4 mb-2">
        <a class="btn btn-info float-end" href="{{ route('admin-employee-create') }}">Add New Employee</a>
      </div>
    </div>
    <div class="card">
      <div class="card-header pt-2 pb-2">
        <label for="name_search">Search:</label>
        <input type="text" id="search_text" class="text-center border border-3 rounded-2">
      </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
              <thead class="sticky-top">
                <tr>
                  <th>Staff Code</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Position</th>
                  <th>Department</th>
                  <th>Account</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" id="employee_list">
                
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/user_profile.js') }}"></script>
@endsection