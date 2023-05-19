(function ($) {
    loadTable();
      function loadTable() {
        let dataFilter = $('.request-tab.active').data('filter');
        let dateFilter = $('#calendar_datepicker').val();
        dateFilter = dateFilter.replace('/', '-');
          $.ajax({
              url: '/api/get_all_request', // đường dẫn tới tệp JSON trên máy chủ
              method: 'GET',
              dataType: 'json', // định dạng dữ liệu là JSON
              data: {
                dataFilter: dataFilter,
                dateFilter: dateFilter
              },
              beforeSend: function(){
                $('.loading-effect').show();
              },
              success: function(data) {
                // Xử lý dữ liệu khi tải về thành công
                let html = '';
                let status = '';
                let type = '';
                if (typeof data.list_requests !== 'undefined' && data.list_requests.length <= 0) {
                  html = '<tr><td>No Data</td></tr>';
                } else {
                  $.each(data.list_requests,function (idx, item) {
                    switch (item.status) {
                      case 0:
                        status = '<td class="text-center"><span class="badge bg-label-warning me-1">Pending</span></td>';
                        break;
                      case 1:
                        status = '<td class="text-center"><span class="badge bg-label-success me-1">Accepted</span></td>';
                        break;
                      case 2:
                        status = '<td class="text-center"><span class="badge bg-label-danger me-1">Denied</span></td>';
                        break;
                    }
                    switch (item.leave_type) {
                      case 1:
                        type = '<td class="text-center"><span class="badge bg-label-info me-1">Paid Leave</span></td>';
                        break;
                      case 2:
                        type = '<td class="text-center"><span class="badge bg-label-info me-1">No Paid Leave</span></td>';
                        break;
                      case 3:
                        type = '<td class="text-center"><span class="badge bg-label-info me-1">Sick Leave</span></td>';
                        break;
                      case 4:
                        type = '<td class="text-center"><span class="badge bg-label-info me-1">Maternity Leave</span></td>';
                        break;
                    }
                    let time_respond = (item.time_response_request) ? item.time_response_request : '<span class="badge bg-label-warning me-1">Pending</span>';
                    let responded_by = (item.responded_by) ? item.responded_by : '<span class="badge bg-label-warning me-1">Pending</span>';
                    let disabledAccept = (item.status == 1) ? 'disabled' : '';
                    let disabledDeny = (item.status == 2) ? 'disabled' : '';
                   html += '<tr>'
                   + '<td class="">' + item.employee_code + '</td>'
                   + '<td class="">' + item.full_name + '</td>'
                   + '<td class="">' + item.leave_date_start + '</td>'
                   + '<td class="">' + item.leave_date_end + '</td>'
                   + type
                   + '<td>' + item.reason + '</td>'
                   + '<td>' + item.time_sent_request + '</td>'
                   + '<td>' + time_respond + '</td>'
                   + '<td>' + responded_by  + '</td>'
                   + status
                   + '<td>'
                   +    '<button type="button" class="btn btn-success btn-sm btn-accept-custom ' + disabledAccept +'" data-id="' + item.id +'">Accept</button>'
                   +    '<button type="button" class="btn btn-danger btn-sm ms-1 me-1 btn-deny-custom ' + disabledDeny +'" data-id="' + item.id +'">Deny</button>'
                   + '</td>'
                   + '</tr>'
                  });
                }
                $('#request_manager').empty().html(html);
                $('.loading-effect').hide();
              },
              error: function() {
                // Xử lý lỗi khi tải dữ liệu thất bại
                alert('Lỗi khi tải dữ liệu');
                $('.loading-effect').hide();
              }
        });
      }

      $('#calendar_datepicker').on('change', function (){
        loadTable();
      });

    $(document).on('click', '.nav-item .request-tab', function (e) {
      $('h4 .tab-text').text(' ' + $(this).text());
      $('.request-tab').removeClass('active');
      $(this).addClass('active');
      loadTable();
    });

    $(document).on('click', '#btn_add_request', function (e) {
      e.preventDefault();
      $('#modalRequest').modal('show');
    });

    $(document).on('click', '.btn-accept-custom', function (e) {
      let id = $(this).data('id');
      $.ajax({
        url: '/api/update_status_request', // đường dẫn tới tệp JSON trên máy chủ
        method: 'POST',
        dataType: 'json', // định dạng dữ liệu là JSON
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          id: id,
          status: 1
        },
        beforeSend: function(){
          // $('.loading-effect').show();
        },
        success: function(data) {
          $('.loading-effect').hide();
          loadTable();
        },
        error: function() {
          // Xử lý lỗi khi tải dữ liệu thất bại
          $('.loading-effect').hide();
          alert('Lỗi khi tải dữ liệu');
        }
      });
    });
    
    $(document).on('click', '.btn-deny-custom', function (e) {
      let id = $(this).data('id');
      $.ajax({
        url: '/api/update_status_request', // đường dẫn tới tệp JSON trên máy chủ
        method: 'POST',
        dataType: 'json', // định dạng dữ liệu là JSON
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          id: id,
          status: 2
        },
        beforeSend: function(){
          // $('.loading-effect').show();
        },
        success: function(data) {
          $('.loading-effect').hide();
          loadTable();
        },
        error: function() {
          // Xử lý lỗi khi tải dữ liệu thất bại
          $('.loading-effect').hide();
          alert('Lỗi khi tải dữ liệu');
        }
      });
    });
  
  $('.datepicker').datepicker({
    format: "yyyy/mm/dd",
    autoclose: true,
  });
  })(jQuery);