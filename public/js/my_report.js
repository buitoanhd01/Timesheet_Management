(function ($) {
    loadTable();
      function loadTable() {
        let dateFilter = $('#calendar_datepicker').val();
        let searchValue = $('#search_text').val();
        dateFilter = dateFilter.replace('/', '-')
          $.ajax({
              url: '/report/view', // đường dẫn tới tệp JSON trên máy chủ
              method: 'GET',
              dataType: 'json', // định dạng dữ liệu là JSON
              data: {
                dateFilter: dateFilter,
                searchValue: searchValue
              },
              beforeSend: function(){
                $('.loading-effect').show();
              },
              success: function(data) {
                // Xử lý dữ liệu khi tải về thành công
                
                $('#attendance_report').empty().html(data.html);
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

      $('#calendar_datepicker').on('change', function (){
        let tab = $('.report-tab.active').data('tab');
        if (tab == 'working') {
            loadTable();
        } else if (tab == 'overtime') {
            loadTableOvertime();
        } else {
            loadTableTotal();
        }
      });

      $('#search_text').on('keyup', function (e) {
        let tab = $('.report-tab.active').data('tab');
        if (tab == 'working') {
            loadTable();
        } else if (tab == 'overtime') {
            loadTableOvertime();
        } else {
            loadTableTotal();
        }
      });

      $('.report-tab').on('click', function (e) {
        $('h4 .tab-text').text(' ' + $(this).text());
        $('.report-tab').removeClass('active');
        $(this).addClass('active');
        if ($(this).data('tab') == 'working') {
            loadTable();
        } else if ($(this).data('tab') == 'overtime') {
            loadTableOvertime();
        } else {
            loadTableTotal();
        }
      });

      function loadTableOvertime() {
        let dateFilter = $('#calendar_datepicker').val();
        let searchValue = $('#search_text').val();
        dateFilter = dateFilter.replace('/', '-')
          $.ajax({
              url: '/report/overtime', // đường dẫn tới tệp JSON trên máy chủ
              method: 'GET',
              dataType: 'json', // định dạng dữ liệu là JSON
              data: {
                dateFilter: dateFilter,
                searchValue: searchValue
              },
              beforeSend: function(){
                $('.loading-effect').show();
              },
              success: function(data) {
                // Xử lý dữ liệu khi tải về thành công
                
                $('#attendance_report').empty().html(data.html);
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

      function loadTableTotal() {
        let dateFilter = $('#calendar_datepicker').val();
        let searchValue = $('#search_text').val();
        dateFilter = dateFilter.replace('/', '-')
          $.ajax({
              url: '/report/total', // đường dẫn tới tệp JSON trên máy chủ
              method: 'GET',
              dataType: 'json', // định dạng dữ liệu là JSON
              data: {
                dateFilter: dateFilter,
                searchValue: searchValue
              },
              beforeSend: function(){
                $('.loading-effect').show();
              },
              success: function(data) {
                // Xử lý dữ liệu khi tải về thành công
                
                $('#attendance_report').empty().html(data.html);
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
  })(jQuery);