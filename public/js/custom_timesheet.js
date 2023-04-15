(function ($) {
    
    let current_tab = $('.calendar-tab.active').data('tab');
    let dateFilter = $('#calendar_datepicker').val();
    loadTable(current_tab, dateFilter);

    $(document).on('click', '.nav-item .calendar-tab', function (e) {
      $('h4 .tab-text').text(' ' + $(this).text());
      $('.calendar-tab').removeClass('active');
      $(this).addClass('active');
      let current_tab = $(this).data('tab');
      let dateFilter = $('#calendar_datepicker').val();
      loadTable(current_tab, dateFilter);
    });

    $('#calendar_datepicker').on('change', function (){
      let current_tab = $('.calendar-tab.active').data('tab');
      let dateFilter = $(this).val();
      loadTable(current_tab, dateFilter);
    });

    function loadTable(current_tab, dateFilter) {
      $.ajax({
        url: $('#get_calendar_report').val(), // đường dẫn tới tệp JSON trên máy chủ
        method: 'GET',
        dataType: 'json', // định dạng dữ liệu là JSON
        data: {
          current_tab: current_tab,
          dateFilter: dateFilter
        },
        beforeSend: function(){
          $('.loading-effect').show();
        },
        success: function(data) {
          // Xử lý dữ liệu khi tải về thành công
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
                  status = '<td class="text-center"><span class="badge bg-label-warning me-1">Early Departure</span></td>';
                  break;
                case 3:
                  status = '<td class="text-center"><span class="badge bg-label-danger me-1">Arrival Late / Early Departure</span></td>';
                  break;
                case 4:
                  status = '<td class="text-center"><span class="badge bg-label-infor me-1">Leaved</span></td>';
              }
              let note = (item.notes) ? '<td class="text-center"><button data-note="' + item.notes +'" class="btn btn-primary">Note</button></td>' : '<td></td>';
              html += '<tr>'
            + '<td><a href="#">'+ item.full_name +'</strong></td>'
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
})(jQuery);