<thead class="sticky-top" style="background-color: #dee5ff;">
    <tr>
      <th>Employee Name</th>
      <th>Employee Code</th>
      <th>Shift Name</th>
      <th>Shift Start</th>
      <th>Shift End</th>
      <th>Shift Rest Start</th>
      <th>Shift Rest End</th>
      <th>Shift Overtime</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="shift_list">
        @foreach ($list_shift as $shift)
        <tr>
            <td>{{ $shift['full_name'] }}</td>
            <td>{{ $shift['employee_code'] }}</td>
            <td>{{ $shift['shift_name'] }}</td>
            <td>{{ $shift['shift_start_time'] }}</td>
            <td>{{ $shift['shift_end_time'] }}</td>
            <td>{{ $shift['shift_rest_time_start'] }}</td>
            <td>{{ $shift['shift_rest_time_end'] }}</td>
            <td>{{ $shift['time_start_overtime'] }}</td>
            <td><button type="button" class="btn btn-info btn-edit-shift" data-employee-id="{{ $shift['id'] }}"
                data-shift-name="{{ $shift['shift_name'] }}" data-shift-start="{{ $shift['shift_start_time'] }}"
                data-shift-end="{{ $shift['shift_end_time'] }}" data-rest-start="{{ $shift['shift_rest_time_start'] }}"
                data-rest-end="{{ $shift['shift_rest_time_end'] }}" data-overtime="{{ $shift['time_start_overtime'] }}"
                >Edit</button>
            </td>
        </tr>
        @endforeach
    @empty ($list_shift)
    <tr>
        <td colspan="30">No Data!</td>
    </tr>
    @endempty
  </tbody>