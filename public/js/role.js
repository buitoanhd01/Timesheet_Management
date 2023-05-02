(function ($) {
    loadRole();
    function loadRole() {
        $.ajax({
            url: '/api/get_role_list', // đường dẫn tới tệp JSON trên máy chủ
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
                $.each(data.list_roles,function (idx, item) {
                  html +='<tr>'
                +  '<td>' + item.name + '</td>'
                +  '<td class=" d-flex justify-content-center">'
                +    '<button type="button" class="me-1 btn btn-primary btn-sm btn-edit-custom">Edit</button>'
                +    '<button type="button" id="btn_delete_role" class="btn btn-danger btn-sm me-1" data-id="' + item.id +'">Delete</button>'
                +    '<button type="button" class="btn btn-warning btn-sm">Permission</button>'
                +  '</td>'
                +'</tr>'
                });
              $('#role_list').empty().html(html);
              $('.loading-effect').hide();
            },
            error: function() {
              // Xử lý lỗi khi tải dữ liệu thất bại
              alert('Lỗi khi tải dữ liệu');
              $('.loading-effect').hide();
            }
        });
    }

    var roleCheckBoxs = [];
    $(document).on('click', 'input[name="role_permission"]', function (e) {
      if (e.target.checked) {
        roleCheckBoxs.push($(this).val());
      } else {
        let index = roleCheckBoxs.indexOf($(this).val()); // Tìm vị trí của phần tử 
        if (index !== -1) { // Nếu phần tử được tìm thấy trong mảng
          roleCheckBoxs.splice(index, 1); // Xóa phần tử đó khỏi mảng
        }
      }
      roleCheckBoxs = [...new Set(roleCheckBoxs)];
    });
    $(document).on('click', '#btn_add_role', function(e) {
        let role_name = $('#role_name').val();
        $.ajax({
            url: '/api/add_role', // đường dẫn tới tệp JSON trên máy chủ
            method: 'POST',
            dataType: 'json', // định dạng dữ liệu là JSON
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            data: {
                role_name: role_name,
                roles: roleCheckBoxs
            },
            beforeSend: function(){
              $('.loading-effect').show();
            },
            success: function(data) {
              // Xử lý dữ liệu khi tải về thành công
              loadRole();
              $('.loading-effect').hide();
              Swal.fire({
                position: 'middle',
                icon: 'success',
                title: 'Successfully!',
                showConfirmButton: false,
                timer: 1000
              })
              $('#role_name').empty().val('');
            },
            error: function() {
              // Xử lý lỗi khi tải dữ liệu thất bại
              alert('Lỗi khi tải dữ liệu');
              $('.loading-effect').hide();
            }
        });
    });

    $(document).on('click', '#btn_delete_role', function(e) {
      let role_id = $(this).data('id');
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
            url: '/api/delete_role', // đường dẫn tới tệp JSON trên máy chủ
            method: 'GET',
            dataType: 'json', // định dạng dữ liệu là JSON
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            data: {
                role_id: role_id,
            },
            beforeSend: function(){
              $('.loading-effect').show();
            },
            success: function(data) {
              // Xử lý dữ liệu khi tải về thành công
              loadRole();
              $('.loading-effect').hide();
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
})(jQuery);