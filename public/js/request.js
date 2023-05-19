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
                    let disabled = (item.status != 0) ? 'disabled' : '';
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
                   +    '<button '+disabled+' data-id="'+item.id+'" data-leave-type="'+item.leave_type+'" data-start-time="'+item.leave_date_start+'" data-end-time="'+item.leave_date_end+'" data-reason="'+item.reason+'" type="button" class="btn btn-primary btn-sm btn-edit-request">Edit</button>'
                   +    '<button '+disabled+' type="button" class="btn btn-danger btn-sm ms-1 me-1 btn-delete-request" data-id="' + item.id +'">Delete</button>'
                   + '</td>'
                   + '</tr>'
                  });
                }
                $('#my_request').empty().html(html);
                $('.loading-effect').hide();
                emptyModal();
              },
              error: function() {
                // Xử lý lỗi khi tải dữ liệu thất bại
                alert('Lỗi khi tải dữ liệu');
                $('.loading-effect').hide();
              }
        });
      }

      $(document).on('click', '.btn-edit-request', function(e) {
        let id = $(this).data('id');
        let leave_type = $(this).data('leave-type');
        let leave_start = $(this).data('start-time');
        let leave_end = $(this).data('end-time');
        let reason = $(this).data('reason');
        $('#modalEditRequest #leave_type').val(leave_type);
        $('#modalEditRequest #start_date').val(leave_start);
        $('#modalEditRequest #end_date').val(leave_end);
        $('#modalEditRequest #reason').val(reason);
        $('#modalEditRequest #hidden_id').val(id);
        $('#modalEditRequest').modal('show');
      });

      $(document).on('click', '.btn-delete-request', function(e) {
        let id = $(this).data('id');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '/api/delete_request', // đường dẫn tới tệp JSON trên máy chủ
              method: 'POST',
              dataType: 'json', // định dạng dữ liệu là JSON
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                id: id,
              },
              beforeSend: function(){
                $('.loading-effect').show();
              },
              success: function(data) {
                $('.loading-effect').hide();
                loadTable();
                Swal.fire({
                  position: 'middle',
                  icon: 'success',
                  title: 'Successfully!',
                  showConfirmButton: false,
                  timer: 500
                })
              },
              error: function() {
                // Xử lý lỗi khi tải dữ liệu thất bại
                alert('Lỗi khi tải dữ liệu');
                $('.loading-effect').hide();
              }
            });
          }
        });
      });

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

    $('#edit-leave-request').click(function(e) {
      editLeaveRequest();
    })

    function submitLeaveRequest() {
      // Lấy dữ liệu từ form
      var formData = {
          'start_date': $('#modalRequest #start_date').val(),
          'end_date': $('#modalRequest #end_date').val(),
          'leave_type': $('#modalRequest #leave_type').val(),
          'reason': $('#modalRequest #reason').val(),
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

  function emptyModal() {
    $('#start_date').empty().val();
    $('#end_date').empty().val();
    $('#leave_type').val('1');
    $('#reason').empty().val();
    $('#hidden_id').empty().val();
  }

  function editLeaveRequest() {
    // Lấy dữ liệu từ form
    var formData = {
        'start_date': $('#modalEditRequest #start_date').val(),
        'end_date': $('#modalEditRequest #end_date').val(),
        'leave_type': $('#modalEditRequest #leave_type').val(),
        'reason': $('#modalEditRequest #reason').val(),
        'id' : $('#modalEditRequest #hidden_id').val(),
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
        url: '/api/update_request_leave',
        data: formData,
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        encode: true,
        beforeSend: function(){
          $('.loading-effect').show();
        },
    })
    .done(function(data) {
        // Xử lý kết quả trả về từ server
        if (data.status_code == 200) {
            // Nếu thành công, hiển thị thông báo và đóng modal
            $('#modalEditRequest').modal('hide');
            Swal.fire({
              position: 'middle',
              icon: 'success',
              title: 'Successfully!',
              showConfirmButton: false,
              timer: 500
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