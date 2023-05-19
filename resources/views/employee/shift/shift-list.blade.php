<thead class="sticky-top" style="background-color: #dee5ff;">
    <tr>
      <th>Shift Name</th>
      <th>Shift Start</th>
      <th>Shift End</th>
      <th>Shift Rest Start</th>
      <th>Shift Rest End</th>
      <th>Shift Overtime</th>
    </tr>
  </thead>
  <tbody id="shift_list">
        <tr>
            <td>{{ $list_shift['shift_name'] }}</td>
            <td>{{ $list_shift['shift_start_time'] }}</td>
            <td>{{ $list_shift['shift_end_time'] }}</td>
            <td>{{ $list_shift['shift_rest_time_start'] }}</td>
            <td>{{ $list_shift['shift_rest_time_end'] }}</td>
            <td>{{ $list_shift['time_start_overtime'] }}</td>
        </tr>
    {{-- @empty ($list_shift)
    <tr>
        <td colspan="30">No Data!</td>
    </tr>
    @endempty --}}
  </tbody>