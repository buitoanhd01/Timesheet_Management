function loadDashboard() {
    $.ajax({
      url: '/api/get_dashboard_calendar', // đường dẫn tới tệp JSON trên máy chủ
      method: 'GET',
      dataType: 'json', // định dạng dữ liệu là JSON
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function(){
        // $('.loading-effect').show();
      },
      success: function(data) {
        let dashboard_data = data.attendance_by_month;
        $('#working_hours').empty().html(dashboard_data.working_hours);
        $('#overtime').empty().html(dashboard_data.overtime);
        $('#total_hour').empty().html(dashboard_data.total);
        $('#wrong_time').empty().html(data.wrong_time);
        let html = '';
        let status = '';
        let item = data.attendance;
        if (typeof item == 'undefined' || item == 'null') {
            html = '<tr><td>No Data</td></tr>';
          } else {
            let first_checkin = (item.first_checkin) ? item.first_checkin : '<span class="badge bg-label-info me-1">Not Yet Check In</span>';
            let last_checkout = (item.last_checkout) ? item.last_checkout : '<span class="badge bg-label-info me-1">Not Yet Check Out</span>';
            switch (item.status) {
                case 0:
                  status = '<td class="text-center"><span class="badge bg-label-success me-1">On Time</span></td>';
                  break;
                case 1:
                  status = '<td class="text-center"><span class="badge bg-label-warning me-1">Arrival Late</span></td>';
                  break;
                case 2:
                  status = '<td class="text-center"><span class="badge bg-label-warning me-1">Early Leave</span></td>';
                  break;
                case 3:
                  status = '<td class="text-center"><span class="badge bg-label-danger me-1">Arrival Late / Early Leave</span></td>';
                  break;
                case 4:
                  status = '<td class="text-center"><span class="badge bg-label-infor me-1">Leaved</span></td>';
              }
              html +='<tr>'
            +  '<td>' + first_checkin + '</td>'
            +  '<td>' + last_checkout + '</td>'
             + status
            +'</tr>'
          }
          $('#dashboard_timesheet').empty().html(html);
          $('.loading-effect').hide();
      },
      error: function() {
        // Xử lý lỗi khi tải dữ liệu thất bại
        $('.loading-effect').hide();
        alert('Lỗi khi tải dữ liệu');
      }
    });
  }
  loadDashboard();

  (function ($) {
    $(document).on("click", ".btn-check-in-out .btn-attendance", function (e) {
        loadDashboard();
    });
})(jQuery);