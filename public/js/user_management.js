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
                let fullName = (item.full_name) ? item.full_name : '<button class="btn btn-success btn-sm me-1">Host User</button>';
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
                // +    '<button type="button" class="btn btn-warning btn-sm ">Role Edit</button>'
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
})(jQuery);