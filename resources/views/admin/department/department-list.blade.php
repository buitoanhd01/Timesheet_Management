@extends('layouts.custom')

@section('title', 'Department Management')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Department /</span> List Department</h4>
    <div class="row d-flex justify-content-end">
      <div class="col-md-4 mb-2">
        <a class="btn btn-info float-end" href="{{ route('admin-department-show-create') }}">Add New Department</a>
      </div>
    </div>
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
              <thead class="sticky-top">
                <tr>
                  <th>STT</th>
                  <th>Department Name</th>
                  <th>Description</th>
                  <th>Number Employee</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" id="department_list">
                
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/department.js') }}"></script>
@endsection