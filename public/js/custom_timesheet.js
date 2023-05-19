(function ($) {
    
    let current_tab = $('.calendar-tab.active').data('tab');
    let dateFilter = $('#calendar_datepicker').val();
    let searchValue = $('#search_text').val();
    let dataFilter = $('.btn-filter-click.active').data('status');
    loadTable(current_tab, dateFilter, searchValue, dataFilter);

    $(document).on('click', '.nav-item .calendar-tab', function (e) {
      $('h4 .tab-text').text(' ' + $(this).text());
      $('.calendar-tab').removeClass('active');
      $(this).addClass('active');
      let current_tab = $(this).data('tab');
      let searchValue = $('#search_text').val();
      let dateFilter = $('#calendar_datepicker').val();
      let dataFilter = $('.btn-filter-click.active').data('status');
      loadTable(current_tab, dateFilter, searchValue, dataFilter);
    });

    $('#calendar_datepicker').on('change', function (){
      let current_tab = $('.calendar-tab.active').data('tab');
      let dateFilter = $(this).val();
      let searchValue = $('#search_text').val();
      let dataFilter = $('.btn-filter-click.active').data('status');
      loadTable(current_tab, dateFilter, searchValue, dataFilter);
    });

    $('#search_text').on('keyup', function (e) {
      let current_tab = $('.calendar-tab.active').data('tab');
      let dateFilter = $('#calendar_datepicker').val();
      let searchValue = $(this).val();
      let dataFilter = $('.btn-filter-click.active').data('status');
      loadTable(current_tab, dateFilter, searchValue, dataFilter);
    });

    function loadTable(current_tab, dateFilter, searchValue, dataFilter) {
      $.ajax({
        url: $('#get_calendar_report').val(), // đường dẫn tới tệp JSON trên máy chủ
        method: 'GET',
        dataType: 'json', // định dạng dữ liệu là JSON
        data: {
          current_tab: current_tab,
          dateFilter: dateFilter,
          searchValue: searchValue,
          dataFilter: dataFilter
        },
        beforeSend: function(){
          $('.loading-effect').show();
        },
        success: function(data) {
          // Xử lý dữ liệu khi tải về thành công
          $('#arrival_late').empty().html(data.count['ArrivalLate']);
          $('#leave_early').empty().html(data.count['LeaveEarly']);
          $('#both').empty().html(data.count['Both']);
          let html = '';
          let status = '';
          if (typeof data.list_calendar !== 'undefined' && data.list_calendar.length <= 0) {
            html = '<tr><td>No Data</td></tr>';
          } else {
            $.each(data.list_calendar,function (idx, item) {
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
              let note = '<td class="text-center"><button data-id="' + item.id +'" data-check-in="' + item.first_checkin +'" data-check-out="' + item.last_checkout +'" class="btn btn-info btn-edit-timesheet">Edit</button></td>';
              let employee_code = (item.employee_code) ? item.employee_code : '<span class="badge bg-label-danger me-1">Deleted</span>';
              let full_name = (item.full_name) ? item.full_name : '<span class="badge bg-label-danger me-1">Deleted</span>'
              html += '<tr>'
            + '<td class="">' + item.date + '</td>'
            + '<td class="">' + employee_code + '</td>'
            + '<td><a href="#">'+ full_name +'</strong></td>'
            + '<td>' + item.first_checkin + '</td>'
            + '<td>' + item.last_checkout + '</td>'
            + '<td>' + item.working_hours + '</td>'
            + '<td>' + item.overtime + '</td>'
            + status
            + note
            + '</tr>'
            });
          }
          $('#timesheet_infor').empty().html(html);
          $('.loading-effect').hide();
        },
        error: function() {
          // Xử lý lỗi khi tải dữ liệu thất bại
          alert('Lỗi khi tải dữ liệu');
          $('.loading-effect').hide();
        }
      });
    }

    $(document).on('click', '.btn-edit-timesheet', function(e) { 
      let id = $(this).data('id');
      let check_in = $(this).data('check-in');
      let check_out = $(this).data('check-out');
      $('#check_in').val(check_in);
      $('#check_out').val(check_out);
      $('#attendance_id').val(id);
      $('#modalEditTime').modal('show');
      
    });
    $(document).on('click', '.btn-filter-click', function(e) {
      let dataFilter = $(this).data('status');
      $('.btn-filter-click').removeClass('active');
      $(this).addClass('active');
      let current_tab = $('.calendar-tab.active').data('tab');
      let dateFilter = $('#calendar_datepicker').val();
      loadTable(current_tab, dateFilter, searchValue, dataFilter);
    });

    $(document).on('click', '.btn-clear-filter', function (e) {
      $('.btn-filter-click').removeClass('active');
      let dataFilter = null;
      let current_tab = $('.calendar-tab.active').data('tab');
      let dateFilter = $('#calendar_datepicker').val();
      let searchValue = $('#search_text').val();
      loadTable(current_tab, dateFilter, searchValue, dataFilter);
    });

    $(document).on('click', '#submit-edit-attendance', function(e) {
      let id =$('#attendance_id').val();
      let check_in = $('#check_in').val();
      let check_out = $('#check_out').val();
      var regex = /^([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
      if (!regex.test(check_in)) {
          $('#check_in').addClass('invalid');
          return
      } else {
          $('#check_in').removeClass('invalid');
      }
      if (!regex.test(check_out)) {
        $('#check_out').addClass('invalid');
        return
      } else {
          $('#check_out').removeClass('invalid');
      }
      $.ajax({
        url: '/api/update_attendance', // đường dẫn tới tệp JSON trên máy chủ
        method: 'POST',
        dataType: 'json', // định dạng dữ liệu là JSON
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          id: id,
          check_in: check_in,
          check_out: check_out
        },
        beforeSend: function(){
          $('.loading-effect').show();
        },
        success: function(data) {
          $('.loading-effect').hide();
          $('#modalEditTime').modal('hide');
          let current_tab = $('.calendar-tab.active').data('tab');
          let dateFilter = $('#calendar_datepicker').val();
          let searchValue = $('#search_text').val();
          let dataFilter = $('.btn-filter-click.active').data('status');
          loadTable(current_tab, dateFilter, searchValue, dataFilter);
          Swal.fire({
            position: 'middle',
            icon: 'success',
            title: 'Successfully!',
            showConfirmButton: false,
            timer: 1000
          })
        },
        error: function() {
          // Xử lý lỗi khi tải dữ liệu thất bại
          alert('Lỗi khi tải dữ liệu');
          $('.loading-effect').hide();
        }
      });
    });
})(jQuery);