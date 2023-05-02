(function ($) {
    loadTable();
      function loadTable() {
        let dataFilter = $('.request-tab.active').data('filter');
          $.ajax({
              url: '/api/get_self_request', // đường dẫn tới tệp JSON trên máy chủ
              method: 'GET',
              dataType: 'json', // định dạng dữ liệu là JSON
              data: {
                dataFilter: dataFilter
              },
              beforeSend: function(){
                $('.loading-effect').show();
              },
              success: function(data) {
                // Xử lý dữ liệu khi tải về thành công
                let html = '';
                let status = '';
                if (data.list_requests) {
                  html = '<tr><td>No Data</td></tr>';
                } else {
                  $.each(data.list_requests,function (idx, item) {
                   
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
          url: '/leave-request',
          data: formData,
          dataType: 'json',
          encode: true
      })
      .done(function(data) {
          // Xử lý kết quả trả về từ server
          if (data.success) {
              // Nếu thành công, hiển thị thông báo và đóng modal
              alert(data.message);
              $('#modal-leave-request').modal('hide');
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