@extends('layouts.custom')

@section('title', 'Position Management')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Position /</span> List Position</h4>
    <div class="row d-flex justify-content-end">
      <div class="col-md-4 mb-2">
        <a class="btn btn-info float-end" href="{{ route('admin-position-show-create') }}">Add New Position</a>
      </div>
    </div>
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
              <thead class="sticky-top">
                <tr>
                  <th>STT</th>
                  <th>Position Name</th>
                  <th>Description</th>
                  <th>Belong To</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" id="position_list">
                @isset($listPositions)
                  @foreach($listPositions as $key => $position)
                  <tr>
                    <td>{{ $key + 1}}</td>
                    <td>{{ $position->position_name }}</td>
                    <td>{{ $position->position_description }}</td>
                    <td>{{ $position->name }}</td>
                    <td>
                      <button type="button" class="btn btn-primary btn-sm btn-edit-custom">Edit</button>
                      <button type="button" class="btn btn-danger btn-sm ">Delete</button>
                    </td>
                  </tr>
                  @endforeach
                @endisset
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/department.js') }}"></script>
@endsection