@extends('admin.layouts.custom')

@section('title', 'Timesheet Management')


@section('content')
<input type="hidden" id="get_calendar_report" value="{{ route('get_list_calendar') }}">
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Timesheet Management /</span> Daily</h4>

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
          <input type="text" class="custom-datepicker" id="calendar_datepicker" value="" name="calendar-datepicker"/>
        </div>
      </ul>
      <div class="card mb-4">
        <!-- timesheet day -->
        <div class="card">
          <div class="table-responsive text-nowrap">
            <table id="calendar-report" class="table">
              <thead>
                <tr>
                  <th>Employee</th>
                  <th>First Check-in</th>
                  <th>Last Check-out</th>
                  <th>Working Hours</th>
                  <th>Overtime</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a href="#">Phan Trường</strong></td>
                  <td>08:00:00</td>
                  <td>17:00:00</td>
                  <td>8h</td>
                  <td>0h</td>
                  <td><span class="badge bg-label-primary me-1">Active</span></td>
                </tr>
              </tbody>
              <tfoot class="table-border-bottom-0">
                <tr>
                  <th>Total</th>
                  <th>Late Arrival:3</th>
                  <th>Early leave:3</th>
                  <th>Working Hour:3</th>
                  <th>Overtime:3</th>
                </tr>
              </tfoot>
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
        dateFormat: 'dd/mm/yy',
        beforeShow: function(input, inst) {
          // $(inst.dpDiv).addClass("custom-datepicker");
        }
      });
    </script>
@endsection