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
                  +    '<button type="button" class="btn btn-primary btn-sm btn-edit-custom">Edit</button>'
                  +    '<button type="button" class="btn btn-danger btn-sm ">Delete</button>'
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
  })(jQuery);