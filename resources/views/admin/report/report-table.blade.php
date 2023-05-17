<thead class="sticky-top" style="background-color: #dee5ff;">
    <tr>
      <th class="col-1 position-sticky start-0 bg-info">Employee Code</th>
      <th class="col-3 position-sticky bg-info" style="left: 146.35px">Employee Name</th>
      @foreach($date_data as $date)
      @php
          $dateNew = date('d', strtotime($date));
          $dayOfWeek = date('l', strtotime($date));
      @endphp
      <th class="text-center @if($dayOfWeek == 'Saturday' || $dayOfWeek == 'Sunday') weekend @endif ">{{ $dateNew }}</th>
      @endforeach
      <th class="text-center">Total</th>
    </tr>
  </thead>
  <tbody id="timesheet_report">
    @foreach($data_reports as $key => $report)
    <tr>
      <td class="position-sticky start-0 bg-light">{{ $key }}</td>
      <td class="position-sticky bg-light" style="left: 146.35px;">{{ $report['full_name'] }}</td>
      @foreach($date_data as $date)
      @php
          $dayOfWeek = date('l', strtotime($date));
          $dateNew = date('Y-m-d 00:00:00', strtotime($date));
      @endphp
      <td class="data-date text-center 
      @if($dayOfWeek == 'Saturday' || $dayOfWeek == 'Sunday') weekend @endif @if(isset($report[$date]['status']) && $report[$date]['status'] != 0) bg-warning @endif">
      {{ (isset($report[$date]['working_hours']) && $report[$date]['working_hours'] != 0) ? $report[$date]['working_hours'] : '' }}
    </td>
      @endforeach
      <td>{{ (isset($report['total']) && $report['total'] != 0) ? $report['total'] : 0 }}</td>
    </tr>
    @endforeach
    @empty ($data_reports)
    <tr>
        <td colspan="30">No Data!</td>
    </tr>
    @endempty
  </tbody>