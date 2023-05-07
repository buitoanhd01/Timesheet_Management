@extends('layouts.custom')

@section('title', 'My Request')


@section('content')
<input type="hidden" id="get_self_calendar" value="{{ route('get_self_calendar') }}">
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">My Request /</span><span class="tab-text"> All</span></h4>

  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
          <a class="nav-link active request-tab" data-filter="all"
          ><i class="bx bx-user me-1"></i> All</a>
        </li>
        <li class="nav-item">
          <a class="nav-link request-tab" data-filter="0"
            ><i class="bx bx-bell me-1"></i> Pending</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link request-tab" data-filter="1"
            ><i class="bx bx-link-alt me-1"></i> Accepted</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link request-tab" data-filter="2"
            ><i class="bx bx-link-alt me-1"></i> Confused</a
          >
        </li>
        {{-- <button type="button" class="btn btn-primary position-absolute" id="btn_add_request" style="margin-right: 24px;right: 0;">Add New Request</button> --}}
        <div>
          <input type="text" class="custom-datepicker text-center" id="calendar_datepicker" value="{{ date('Y/m') }}" name="calendar-datepicker" autocomplete="off"/>
        </div>
      </ul>
      <div class="card">
        <div class="card-header pt-2 pb-2">
            <label for="name_search">Search:</label>
            <input type="text" id="search_text" class="text-center border border-3 rounded-2">
        </div>
        <!-- timesheet day -->
        <div class="card">
          <div class="table-responsive text-nowrap" style="max-height: 460px">
            <table id="calendar-report-employee" class="table">
              <thead class="sticky-top" style="background-color: #dee5ff">
                <tr>
                  <th>Employee_code</th>
                  <th>Full_name</th>
                  <th>Leave Start</th>
                  <th>Leave End</th>
                  <th>Leave Type</th>
                  <th>Reason</th>
                  <th>Time Sent</th>
                  <th>Time Respond</th>
                  <th>Respond By</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody id="request_manager">
                
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
        format: "yyyy/mm",
        startView: 1,
        minViewMode: 1,
        autoclose: true
      });
    </script>
    <script src="{{ asset('js/request-manager.js') }}"></script>
@endsection