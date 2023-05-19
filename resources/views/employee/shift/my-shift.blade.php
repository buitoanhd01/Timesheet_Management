@extends('layouts.custom')

@section('title', 'Timesheet Shift')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">My Shift /</span><span class="tab-text"> Shift Schedule</span></h4>

  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="nav-link shift-tab active" data-tab="schedule"
              ><i class="bx bx-alarm me-1"></i> Shift Schedule</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link shift-tab" data-tab="request"
            ><i class="bx bx-bell me-1"></i> Shift Request</a
          >
        </li> --}}
        {{-- <div>
          <input type="text" class="custom-datepicker text-center" id="calendar_datepicker" value="{{ date('Y/m') }}" name="calendar-datepicker" autocomplete="off"/>
        </div> --}}
      </ul>
      <div class="card">
        <div class="d-flex justify-content-between">
          {{-- <div class="card-header pt-2 pb-2">
            <label for="name_search">Search:</label>
            <input type="text" id="search_text" class="text-center border border-3 rounded-2">
          </div> --}}
          {{-- <p class="mb-0 mt-2 me-5">
            <span class="badge badge-center rounded-pill bg-warning text-warning">5</span> : <span class="me-2">Wrong Time</span>
            <span class="badge badge-center rounded-pill" style="background-color: #ffcccc;color: #ffcccc">5</span> : <span>Weekend</span>
          </p> --}}
        </div>
        <!-- timesheet day -->
        <div class="card">
          <div class="table-responsive text-nowrap" style="max-height: 460px">
            <table id="shift_table" class="table table-bordered">
              
            </table>
          </div>
        </div>
        <!-- /timsheet day -->
      </div>
    </div>
  </div>
</div>
  @endsection

@section('scripts')
    <script type="text/javascript">
      $('#calendar_datepicker').datepicker({
        format: "yyyy/mm",
        startView: 1,
        minViewMode: 1,
        autoclose: true
      });
    </script>
    <script src="{{ asset('js/my-shift.js') }}"></script>
@endsection