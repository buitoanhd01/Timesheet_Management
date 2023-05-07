(function ($) {
    loadTable();
      function loadTable() {
        let dataFilter = $('.request-tab.active').data('filter');
        let dateFilter = $('#calendar_datepicker').val();
        dateFilter = dateFilter.replace('/', '-');
          $.ajax({
              url: '/api/get_self_request', // đường dẫn tới tệp JSON trên máy chủ
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
                      case 0:
                        type = '<td class="text-center"><span class="badge bg-label-info me-1">Paid Leave</span></td>';
                        break;
                      case 1:
                        type = '<td class="text-center"><span class="badge bg-label-info me-1">No Paid Leave</span></td>';
                        break;
                      case 2:
                        type = '<td class="text-center"><span class="badge bg-label-info me-1">Sick Leave</span></td>';
                        break;
                      case 3:
                        type = '<td class="text-center"><span class="badge bg-label-info me-1">Maternity Leave</span></td>';
                        break;
                    }
                    let time_respond = (item.time_response_request) ? item.time_response_request : '<span class="badge bg-label-warning me-1">Pending</span>';
                    let responded_by = (item.responded_by) ? item.responded_by : '<span class="badge bg-label-warning me-1">Pending</span>';
                   html += '<tr>'
                   + '<td class="">' + item.leave_date_start + '</td>'
                   + '<td class="">' + item.leave_date_end + '</td>'
                   + type
                   + '<td>' + item.reason + '</td>'
                   + '<td>' + item.time_sent_request + '</td>'
                   + '<td>' + time_respond + '</td>'
                   + '<td>' + responded_by  + '</td>'
                   + status
                   + '<td>'
                   +    '<a href="/admin/users/edit/' + item.id +'" class="btn btn-primary btn-sm btn-edit-custom">Edit</a>'
                   +    '<button type="button" class="btn btn-danger btn-sm ms-1 me-1 btn-delete-user" data-id="' + item.id +'">Delete</button>'
                   + '</td>'
                   + '</tr>'
                  });
                }
                $('#my_request').empty().html(html);
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

    $('#submit-leave-request').click(function() {
      submitLeaveRequest();
    });

    function submitLeaveRequest() {
      // Lấy dữ liệu từ form
      var formData = {
          'start_date': $('#start_date').val(),
          'end_date': $('#end_date').val(),
          'leave_type': $('#leave_type').val(),
          'reason': $('#reason').val(),
      };
  
      // Kiểm tra tính hợp lệ của dữ liệu
      if (formData.start_date == '') {
          alert('Please insert start date!');
          return false;
      }
      if (formData.end_date == '') {
          alert('Please insert end date!');
          return false;
      }
      if (formData.leave_type == '') {
          alert('Please insert leave type!');
          return false;
      }
      if (formData.reason == '') {
          alert('Please insert reason leave!');
          return false;
      }
  
      // Gửi dữ liệu đến server bằng Ajax
      $.ajax({
          type: 'POST',
          url: '/api/add_new_request',
          data: formData,
          dataType: 'json',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          encode: true
      })
      .done(function(data) {
          // Xử lý kết quả trả về từ server
          if (data.status_code == 200) {
              // Nếu thành công, hiển thị thông báo và đóng modal
              $('#modalRequest').modal('hide');
              Swal.fire({
                position: 'middle',
                icon: 'success',
                title: 'Successfully!',
                showConfirmButton: false,
                timer: 1000
              })
              setTimeout(function (){
                loadTable();
              },1000);
          } else {
              // Nếu thất bại, hiển thị thông báo lỗi
              alert(data.message);
          }
      });
  }
  
  $('.datepicker').datepicker({
    format: "yyyy/mm/dd",
    autoclose: true,
  });
  })(jQuery);