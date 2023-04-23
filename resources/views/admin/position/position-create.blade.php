@extends('layouts.custom')

@section('title', 'Position Management')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Position Management /</span> Create</h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create Position</h5>
          </div>
          <div class="card-body">
            <form id="formAccountSettings" method="POST" action="{{ route('admin-position-create') }}">
                @csrf
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="position_name" class="form-label">Position Name <span class="required-field text-danger">*</span></label>
                  <input
                    class="form-control @error('position_name') is-invalid @enderror"
                    type="text"
                    id="position_name"
                    name="position_name"
                    value=""
                    autofocus
                    required
                  />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="position_description" class="form-label">Position Description</label>
                    <input
                      class="form-control @error('position_description') is-invalid @enderror"
                      type="text"
                      id="position_description"
                      name="position_description"
                      value=""
                      autofocus
                    />
                </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Create</button>
                <a type="button" href="{{ route('admin-position-management')}}" class="btn btn-outline-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
@endsection