(function ($) {
  loadProfile();
    function loadProfile() {
        $.ajax({
            url: '/api/get_employee_list', // đường dẫn tới tệp JSON trên máy chủ
            method: 'GET',
            dataType: 'json', // định dạng dữ liệu là JSON
            data: {
              
            },
            beforeSend: function(){
              $('.loading-effect').show();
            },
            success: function(data) {
              // Xử lý dữ liệu khi tải về thành công
              let html = '';
              let status = '';
              if (typeof data.list_employee !== 'undefined' && data.list_employee.length <= 0) {
                html = '<tr><td>No Data</td></tr>';
              } else {
                $.each(data.list_employee,function (idx, item) {
                  let position = (item.position) ? item.position : '<span class="badge bg-label-warning me-1">No Assignment Yet</span>';
                  let department = (item.department) ? item.department : '<span class="badge bg-label-warning me-1">No Assignment Yet</span>';
                  let account = (item.username) ? item.username : 'No Account';
                  html +='<tr>'
                +  '<td>' + item.employee_code + '</td>'
                +  '<td>' + item.full_name + '</td>'
                +  '<td>' + item.email + '</td>'
                +  '<td>' + item.phone + '</td>'
                +  '<td>' + position + '</td>'
                +  '<td>' + department +'</td>'
                +  '<td>' + account +'</td>'
                +  '<td>'
                +    '<a type="button" href="/admin/employee/edit/' + item.id +'" class="btn btn-primary btn-sm me-1">Edit</a>'
                +    '<button type="button" data-id="' + item.id + '" class="btn btn-danger btn-sm btn-delete-employee">Delete</button>'
                +  '</td>'
                +'</tr>'
                });
              }
              $('#employee_list').empty().html(html);
              $('.loading-effect').hide();
            },
            error: function() {
              // Xử lý lỗi khi tải dữ liệu thất bại
              alert('Lỗi khi tải dữ liệu');
              $('.loading-effect').hide();
            }
          });
    }
    $(document).on('click', '#create_new_account', function (e) {
        if ($(this).is(':checked')) {
            $('.new-account').show();
        } else {
            $('.new-account').hide();
        }
    });

    $(document).on('click', '.btn-delete-employee', function (e) {
      let id = $(this).data('id');
      $.ajax({
        url: '/api/delete_employee', // đường dẫn tới tệp JSON trên máy chủ
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
          loadProfile();
        },
        error: function() {
          // Xử lý lỗi khi tải dữ liệu thất bại
          alert('Lỗi khi tải dữ liệu');
          $('.loading-effect').hide();
        }
      });
    });
})(jQuery);