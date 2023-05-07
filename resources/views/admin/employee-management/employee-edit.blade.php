@extends('layouts.custom')

@section('title', 'Employee Management')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Employee Management /</span> Profile Details</h4>
    <div class="card mb-4">
        <h5 class="card-header">Profile Details</h5>
        <!-- Account -->
        <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img
              src="{{ asset('assets/img/avatars/1.png')}}"
              alt="user-avatar"
              class="d-block rounded"
              height="100"
              width="100"
              id="uploadedAvatar"
            />
            <div class="button-wrapper">
              {{-- <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                <span class="d-none d-sm-block">Upload new photo</span>
                <i class="bx bx-upload d-block d-sm-none"></i>
                <input
                  type="file"
                  id="upload"
                  class="account-file-input"
                  hidden
                  accept="image/png, image/jpeg"
                />
              </label>
              <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                <i class="bx bx-reset d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Reset</span>
              </button>

              <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p> --}}
            </div>
          </div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
          <form id="formAccountSettings" method="POST" action="{{ route('admin-employee-edit',['id' => $employee->id]) }}">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">First Name <span class="required-field text-danger">*</span></label>
                <input
                  class="form-control @error('firstName') is-invalid @enderror"
                  type="text"
                  id="firstName"
                  name="firstName"
                  value="{{$employee->first_name}}"
                  autofocus
                  required
                />
              </div>
              <div class="mb-3 col-md-6">
                <label for="lastName" class="form-label">Last Name <span class="required-field text-danger">*</span></label>
                <input class="form-control @error('lastName') is-invalid @enderror" type="text" name="lastName" id="lastName" value="{{$employee->last_name}}" required/>
              </div>
              <div class="mb-3 col-md-6">
                <label for="fullName" class="form-label">Full Name <span class="required-field text-danger">*</span></label>
                <input
                  class="form-control @error('fullName') is-invalid @enderror"
                  type="text"
                  id="fullName"
                  name="fullName"
                  value="{{$employee->full_name}}"
                  placeholder=""
                  required
                />
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">E-mail <span class="required-field text-danger">*</span></label>
                <input
                  class="form-control @error('email') is-invalid @enderror"
                  type="email"
                  id="email"
                  name="email"
                  value="{{$employee->email}}"
                  placeholder=""
                  required
                />
              </div>
              @isset($user->username)
              <div class="mb-3 col-md-6">
                <label for="username" class="form-label">Username <span class="required-field text-danger">*</span></label>
                <input
                  class="form-control @error('username') is-invalid @enderror"
                  type="text"
                  id="username"
                  name="username"
                  value="{{$user->username}}"
                  placeholder=""
                  required
                />
              </div>
              @endisset
              <div class="mb-3 col-md-6">
                <label for="employee_code" class="form-label">Employee Code <span class="required-field text-danger">*</span></label>
                <input
                  type="text"
                  class="form-control @error('employee_code') is-invalid @enderror"
                  id="employee_code"
                  name="employee_code"
                  value="{{$employee->employee_code}}"
                  required
                  disabled
                />
              </div>
              <div class="mb-3 col-md-6">
                <label for="tax_code" class="form-label">Tax Code</label>
                <input
                  type="text"
                  class="form-control @error('tax_code') is-invalid @enderror"
                  id="tax_code"
                  name="tax_code"
                  value="{{$employee->tax_code}}"
                />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="phoneNumber">Phone Number <span class="required-field text-danger">*</span></label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text">Vi (+84)</span>
                  <input
                    type="text"
                    id="phoneNumber"
                    name="phoneNumber"
                    class="form-control @error('phoneNumber') is-invalid @enderror"
                    placeholder=""
                    value="{{$employee->phone}}"
                    required
                  />
                </div>
              </div>
              <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder=""  value="{{$employee->address}}"/>
              </div>
              <div class="mb-3 col-md-6">
                <label for="birthday" class="form-label">Birthday</label>
                <input class="form-control daterangepicker" type="text" id="birthday" name="birthday" placeholder="yyyy/mm/dd" autocomplete="off" value="{{$employee->birthday}}"/>
              </div>
              <div class="mb-3 col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <select class="select2 form-select" name="gender" id="gender">
                    <option value="">Select</option>
                    <option value="male" @if($employee->gender == 'male') selected @endif>Male</option>
                  <option value="female" @if($employee->gender == 'female') selected @endif>Female</option>
                </select>
              </div>
              <div class="mb-3 col-md-6">
                <label for="start_time" class="form-label">Start time <span class="required-field text-danger">*</span></label>
                <input type="text" class="form-control daterangepicker" id="start_time" name="start_time" placeholder="yyyy/mm/dd" autocomplete="off" value="{{$employee->start_time}}"/>
              </div>
              <div class="mb-3 col-md-6">
                <label for="end_time" class="form-label">End time <span class="required-field text-danger">*</span></label>
                <input type="text" class="form-control daterangepicker" id="end_time" name="end_time" placeholder="yyyy/mm/dd" autocomplete="off" value="{{$employee->end_time}}"/>
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="employee_type">Employee Type</label>
                <select id="employee_type" name="employee_type" class="select2 form-select">
                  <option value="">Select Employee Type</option>
                  <option value="part-time" @if($employee->employee_type == 'part-time') selected @endif>Part-time</option>
                  <option value="official" @if($employee->employee_type == 'official') selected @endif>Official</option>
                </select>
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="status">Employee Type</label>
                <select id="status" name="status" class="select2 form-select">
                  @empty($employee->status)
                  <option value="">Select Status</option>
                  @endempty
                  <option value="working" @if($employee->status == 'working') selected @endif>Working</option>
                  <option value="expired" @if($employee->status == 'expired') selected @endif>Expired</option>
                </select>
              </div>
              <div class="mb-3 col-md-6">
                <label for="position" class="form-label">Position</label>
                <select id="position" name="position" class="select2 form-select">
                  @empty($employee->position)
                  <option value="">Select Position</option>
                  @endempty
                  @isset($positions)
                  @foreach($positions as $position)
                  <option value="{{ $position->id }}"  class="text-capitalize" @if($employee->position == $position->position_name) selected @endif>{{$position->position_name}}</option>
                  @endforeach
                  @endisset
                </select>
              </div>
              <div class="mb-3 col-md-6">
                <label for="department" class="form-label">Department</label>
                <select id="department" name="department" class="select2 form-select">
                  @empty($employee->departments)
                  <option value="">Select Department</option>
                  @endempty
                  @isset($departments)
                  @foreach($departments as $department)
                  <option value="{{ $department->id }}" @if($employee->department == $department->department_name) selected @endif class="text-capitalize">{{$department->department_name}}</option>
                  @endforeach
                  @endisset
                </select>
              </div>
            </div>
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Save changes</button>
              <a type="button" href="{{ route('admin-employee')}}" class="btn btn-outline-secondary">Cancel</a>
            </div>
          </form>
        </div>
        <!-- /Account -->
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
      $('.daterangepicker').datepicker({
        dateFormat: "yy/mm/dd",
        changeMonth: true,
        changeYear: true,
      });
    </script>
    <script src="{{ asset('js/user_profile.js') }}"></script>
@endsection
