(function ($) {
    loadUser();

    $(document).on('click', '.btn-delete-user', function (e) {
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
            url: '/api/delete_user', // đường dẫn tới tệp JSON trên máy chủ
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
              loadUser();
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
        }
      })
    });


    function loadUser() {
      let filter = $('#search_text').val();
        $.ajax({
          url: $('#get_user_list').val(), // đường dẫn tới tệp JSON trên máy chủ
          method: 'GET',
          dataType: 'json', // định dạng dữ liệu là JSON
          data: {
            filter: filter
          },
          beforeSend: function(){
            $('.loading-effect').show();
          },
          success: function(data) {
            // Xử lý dữ liệu khi tải về thành công
            let html = '';
            let status = '';
            if (typeof data.list_user !== 'undefined' && data.list_user.length <= 0) {
              html = '<tr><td>No Data</td></tr>';
            } else {
              $.each(data.list_user,function (idx, item) {
                if (item.status == 'active') {
                    status = '<td><span class="badge bg-label-success me-1">' + item.status + '</span></td>';
                } else {
                    status = '<td><span class="badge bg-label-warning me-1">' + item.status + '</span></td>';
                }
                let fullName = (item.full_name) ? item.full_name : '<button class="btn btn-success btn-sm me-1 btn-assign" data-id="' + item.id +'">Assign Now</button>';
                let role = (item.roles[0].name) ? item.roles[0].name : '';
                html += '<tr>'
                +  '<td>' + (idx + 1) + '</td>'
                +  '<td>' + fullName + '</td>'
                +  '<td>' + item.username + '</td>'
                +  '<td><span class="">' + role + '</span></td>'
                +  status
                + '<td>'
                +    '<a href="/admin/users/edit/' + item.id +'" class="btn btn-primary btn-sm btn-edit-custom">Edit</a>'
                +    '<button type="button" class="btn btn-danger btn-sm ms-1 me-1 btn-delete-user" data-id="' + item.id +'">Delete</button>'
                // +    '<button type="button" class="btn btn-warning btn-sm btn-permission" data-id="' + item.id +'">Permission</button>'
                + '</td>'
                +'</tr>'
              });
            $('#user_list').empty().html(html);
            $('.loading-effect').hide();
            }
          },
          error: function() {
            // Xử lý lỗi khi tải dữ liệu thất bại
            alert('Lỗi khi tải dữ liệu');
            $('.loading-effect').hide();
          }
        });
      }

      $('#search_text').on('keyup', function (e) {
        loadUser();
      });

      $(document).on('click', '.btn-permission', function (e) {
        let user_id = $(this).data('id');
        $('#user_id_hidden').val(user_id);
        $.ajax({
          url: '/api/get_role_list_by_user/', // đường dẫn tới tệp JSON trên máy chủ
          method: 'GET',
          dataType: 'json', // định dạng dữ liệu là JSON
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          data:{
            id: role_id
          },
          beforeSend: function(){
            $('.loading-effect').show();
          },
          success: function(data) {
            // Xử lý dữ liệu khi tải về thành công
            $('#modalRole #role_name').empty().html(data.role);
            let html = '';
            $.each(data.all_permission,function (idx, item) {
              html +='<tr>'
            +  '<td><input type="checkbox" name="permission" class="form-check-input" value="' + item +'"></td>'
            +  '<td>' + item +'</td>'
            +'</tr>'
            });
            $('#permission_list').empty().html(html);
            $.each(data.list_permision,function (idx, item) {
              $('#permission_list input[value="' + item + '"]').attr('checked', true);
            });
            $('.loading-effect').hide();
            $('#modalRole').modal('show');
          },
          error: function() {
            // Xử lý lỗi khi tải dữ liệu thất bại
            alert('Lỗi khi tải dữ liệu');
            $('.loading-effect').hide();
          }
      });
      });

      $(document).on('click', '.btn-assign', function() {
        let user_id = $(this).data('id');
        $('#user_id_hidden').val(user_id);
        $.ajax({
          url: '/api/get_employee_list_no_account', // đường dẫn tới tệp JSON trên máy chủ
          method: 'GET',
          dataType: 'json', // định dạng dữ liệu là JSON
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          beforeSend: function(){
            $('.loading-effect').show();
          },
          success: function(data) {
            // Xử lý dữ liệu khi tải về thành công
            let html = '';
            $.each(data.list_employee,function (idx, item) {
              html +='<tr>'
            +  '<td><input type="radio" name="assign-employee" class="form-check-input" value="' + item.id +'"></td>'
            +  '<td>' + item.employee_code +'</td>'
            +  '<td>' + item.full_name +'</td>'
            +'</tr>'
            });
            $('#employee_no_account').empty().html(html);
            $('.loading-effect').hide();
            $('#modal_assign_user').modal('show');
          },
          error: function() {
            // Xử lý lỗi khi tải dữ liệu thất bại
            alert('Lỗi khi tải dữ liệu');
            $('.loading-effect').hide();
          }
      });
    });

    $(document).on('click', '#btn_save_assign', function (e) {
      let employee_id = $('input[name=assign-employee]:checked', '#form-assign').val();
      let user_id = $('#user_id_hidden').val();
      $.ajax({
        url: '/api/assign_user', // đường dẫn tới tệp JSON trên máy chủ
        method: 'GET',
        dataType: 'json', // định dạng dữ liệu là JSON
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        data:{
          user_id: user_id,
          employee_id: employee_id
        },
        beforeSend: function(){
          $('.loading-effect').show();
        },
        success: function(data) {
          // Xử lý dữ liệu khi tải về thành công
          
          $('.loading-effect').hide();
          $('#modal_assign_user').modal('hide');
          loadUser();
        },
        error: function() {
          // Xử lý lỗi khi tải dữ liệu thất bại
          alert('Lỗi khi tải dữ liệu');
          $('.loading-effect').hide();
        }
    });
    });
})(jQuery);