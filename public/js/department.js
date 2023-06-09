(function ($) {
    loadTable();
      function loadTable() {
          $.ajax({
              url: '/api/get_department_list', // đường dẫn tới tệp JSON trên máy chủ
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
                if (typeof data.list_department !== 'undefined' && data.list_department.length <= 0) {
                  html = '<tr><td>No Data</td></tr>';
                } else {
                  $.each(data.list_department,function (idx, item) {
                    html +='<tr>'
                  +  '<td>' + (idx + 1) + '</td>'
                  +  '<td>' + item.department_name + '</td>'
                  +  '<td>' + item.department_description + '</td>'
                  +  '<td>' + item.num_employees + '</td>'
                  +  '<td>'
                  +    '<a href="/admin/department/edit/'+ item.id + '" type="button" class="btn btn-primary btn-sm btn-edit-custom">Edit</a>'
                  +    '<button type="button" class="btn btn-danger btn-sm btn-delete-department" data-id="' + item.id +'">Delete</button>'
                  +  '</td>'
                  +'</tr>'
                  });
                }
                $('#department_list').empty().html(html);
                $('.loading-effect').hide();
              },
              error: function() {
                // Xử lý lỗi khi tải dữ liệu thất bại
                alert('Lỗi khi tải dữ liệu');
                $('.loading-effect').hide();
              }
        });
      }

      $(document).on('click', '.btn-delete-department', function (e) {
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
              url: '/api/delete_department', // đường dẫn tới tệp JSON trên máy chủ
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