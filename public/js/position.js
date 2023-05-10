(function ($) {
    loadTable();
      function loadTable() {
          $.ajax({
              url: '/api/get_position_list', // đường dẫn tới tệp JSON trên máy chủ
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
                let name
                if (typeof data.list_position !== 'undefined' && data.list_position.length <= 0) {
                  html = '<tr><td>No Data</td></tr>';
                } else {
                  $.each(data.list_position,function (idx, item) {
                    name = (item.name) ? item.name : '<span class="badge bg-label-warning me-1">No Assignment Yet</span>';
                    html +='<tr>'
                  +  '<td>' + (idx + 1) + '</td>'
                  +  '<td>' + item.position_name + '</td>'
                  +  '<td>' + item.position_description + '</td>'
                  +  '<td>' + name + '</td>'
                  +  '<td>'
                  +    '<a href="/admin/position/edit/'+ item.id + '" type="button" class="btn btn-primary btn-sm btn-edit-custom me-2">Edit</a>'
                  +    '<button type="button" class="btn btn-danger btn-sm btn-delete-department" data-id="' + item.id +'">Delete</button>'
                  +  '</td>'
                  +'</tr>'
                  });
                }
                $('#position_list').empty().html(html);
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
              url: '/api/delete_position', // đường dẫn tới tệp JSON trên máy chủ
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