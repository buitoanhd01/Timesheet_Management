(function ($) {
    loadTable();
      function loadTable() {
        let searchValue = $('#search_text').val();
          $.ajax({
              url: 'shift/list', // đường dẫn tới tệp JSON trên máy chủ
              method: 'GET',
              dataType: 'json', // định dạng dữ liệu là JSON
              data: {
                searchValue: searchValue
              },
              beforeSend: function(){
                $('.loading-effect').show();
              },
              success: function(data) {
                // Xử lý dữ liệu khi tải về thành công
                
                $('#shift_table').empty().html(data.html);
                $('.loading-effect').hide();
              },
              error: function(xhr, status, error) {
                // Xử lý lỗi khi tải dữ liệu thất bại
                alert('Lỗi khi tải dữ liệu');
                $('.loading-effect').hide();
                console.log(xhr.responseText);
              }
        });
      }

      $('#search_text').on('keyup', function (e) {
        let tab = $('.shift-tab.active').data('tab');
        if (tab == 'schedule') {
            loadTable();
        } else if (tab == 'overtime') {

        } else {

        }
      });

      $('.shift-tab').on('click', function (e) {
        $('h4 .tab-text').text(' ' + $(this).text());
        $('.shift-tab').removeClass('active');
        $(this).addClass('active');
        if ($(this).data('tab') == 'schedule') {
            loadTable();
        } else if ($(this).data('tab') == 'overtime') {
        } else {
        }
      });

      $(document).on('click', '.btn-edit-shift', function(e) {
        let id = $(this).data('employee-id');
        let shift_name = $(this).data('shift-name');
        let shift_start = $(this).data('shift-start');
        let shift_end = $(this).data('shift-end');
        let rest_start = $(this).data('rest-start');
        let rest_end = $(this).data('rest-end');
        let overtime = $(this).data('overtime');
        $('#modalShift #shift_name').val(shift_name);
        $('#modalShift #shift_start').val(shift_start);
        $('#modalShift #shift_end').val(shift_end);
        $('#modalShift #rest_start').val(rest_start);
        $('#modalShift #rest_end').val(rest_end);
        $('#modalShift #overtime').val(overtime);
        $('#modalShift #hidden_id').val(id);
        $('#modalShift').modal('show');
      });

      $(document).on('click', '#btn_save_shift', function(e) {
        let id = $('#modalShift #hidden_id').val();
        let shift_name = $('#modalShift #shift_name').val();
        let shift_start = $('#modalShift #shift_start').val();
        let shift_end = $('#modalShift #shift_end').val();
        let rest_start = $('#modalShift #rest_start').val();
        let rest_end = $('#modalShift #rest_end').val();
        let overtime = $('#modalShift #overtime').val();
        var regex = /^([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
        if (!regex.test(shift_start)) {
            $('#modalShift #shift_start').addClass('invalid');
            return
        } else {
            $('#modalShift #shift_start').removeClass('invalid');
        }
        if (!regex.test(shift_end)) {
            $('#modalShift #shift_end').addClass('invalid');
            return
        } else {
            $('#modalShift #shift_end').removeClass('invalid');
        }
        if (!regex.test(rest_start)) {
            $('#modalShift #rest_start').addClass('invalid');
            return
        } else {
            $('#modalShift #rest_start').removeClass('invalid');
        }
        if (!regex.test(rest_end)) {
            $('#modalShift #rest_end').addClass('invalid');
            return
        } else {
            $('#modalShift #rest_end').removeClass('invalid');
        }
        if (!regex.test(overtime)) {
            $('#modalShift #overtime').addClass('invalid');
            return
        } else {
            $('#modalShift #overtime').removeClass('invalid');
        }
        $.ajax({
            url: '/api/update_shift', // đường dẫn tới tệp JSON trên máy chủ
            method: 'POST',
            dataType: 'json', // định dạng dữ liệu là JSON
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            data:{
              id: id,
              shift_name: shift_name,
              shift_start: shift_start,
              shift_end: shift_end,
              rest_start: rest_start,
              rest_end: rest_end,
              overtime: overtime
            },
            beforeSend: function(){
              $('.loading-effect').show();
            },
            success: function(data) {
              // Xử lý dữ liệu khi tải về thành công
              
              $('.loading-effect').hide();
              $('#modalShift').modal('hide');
              setTimeout(function(){
                Swal.fire({
                    position: 'middle',
                    icon: 'success',
                    title: 'Successfully!',
                    showConfirmButton: false,
                    timer: 500
                  })
              },200);
              loadTable();
            },
            error: function() {
              // Xử lý lỗi khi tải dữ liệu thất bại
              alert('Lỗi khi tải dữ liệu');
              $('.loading-effect').hide();
            }
        });
      });

  })(jQuery);