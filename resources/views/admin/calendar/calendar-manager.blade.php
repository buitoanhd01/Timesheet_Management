@extends('layouts.custom')

@section('title', 'Timesheet Management')


@section('content')
<input type="hidden" id="get_calendar_report" value="{{ route('get_list_calendar') }}">
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Timesheet Management /</span><span class="tab-text"> Daily</span></h4>

  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
          <a class="nav-link active calendar-tab" data-tab="daily"
          ><i class="bx bx-user me-1"></i> Daily</a>
        </li>
        <li class="nav-item">
          <a class="nav-link calendar-tab" data-tab="weekly"
            ><i class="bx bx-bell me-1"></i> Weekly</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link calendar-tab" data-tab="monthly"
            ><i class="bx bx-link-alt me-1"></i> Monthly</a
          >
        </li>
        <div>
          <input type="text" class="custom-datepicker text-center" id="calendar_datepicker" value="{{ date('Y/m/d') }}" name="calendar-datepicker"/>
        </div>
      </ul>
      <div class="card">
        <div class="d-flex justify-content-between">
          <div class="card-header pt-2 pb-2">
            <label for="name_search">Search:</label>
            <input type="text" id="search_text" class="text-center border border-3 rounded-2">
          </div>
          <div class="btn-filter mt-1 mb-1">
            <button type="button" class="btn btn-outline-warning rounded-pill btn-filter-click" data-status="1">
              Arrival Late:
              <span class="badge rounded-pill" id="arrival_late">0</span>
            </button>
            <button type="button" class="btn btn-outline-warning rounded-pill btn-filter-click" data-status="2">
              Leave Early:
              <span class="badge rounded-pill" id="leave_early">0</span>
            </button>
            <button type="button" class="btn btn-outline-danger rounded-pill btn-filter-click" data-status="3">
              Arrival Late/Leave Early:
              <span class="badge rounded-pill" id="both">0</span>
            </button>
            <button class="btn btn-secondary btn-clear-filter ms-2 me-1">All</button>
          </div>
        </div>
        <!-- timesheet day -->
        <div class="card">
          <div class="table-responsive text-nowrap" id="vertical-example" style="max-height: 460px">
            <table id="calendar-report" class="table">
              <thead class="sticky-top" style="background-color: #dee5ff">
                <tr>
                  <th>Date</th>
                  <th>Staff Code</th>
                  <th>Employee Name</th>
                  <th>Check-in</th>
                  <th>Check-out</th>
                  <th>Working Hours</th>
                  <th>Overtime</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Note</th>
                </tr>
              </thead>
              <tbody id="timesheet_infor">
                
              </tbody>
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
        format: "yyyy/mm/dd",
        autoclose: true,
      });
    </script>
    <script src="{{ asset('js/custom_timesheet.js') }}"></script>
@endsection