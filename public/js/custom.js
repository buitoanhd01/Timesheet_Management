(function ($) {
    
    $(document).on('click', '.nav-item .calendar-tab', function (e) {
      let current_tab = $(this).data('tab');
      let dateFilter = $('#calendar_datepicker').val();
      loadTable(current_tab, dateFilter)
    });

    function loadTable(current_tab, dateFilter) {
      $.ajax({
        url: $('#get_calendar_report').val(), // đường dẫn tới tệp JSON trên máy chủ
        method: 'GET',
        dataType: 'json', // định dạng dữ liệu là JSON
        data: {
          current_tab: current_tab,
          dateFilter: dateFilter
        },
        success: function(data) {
          // Xử lý dữ liệu khi tải về thành công
          
        },
        error: function() {
          // Xử lý lỗi khi tải dữ liệu thất bại
          alert('Lỗi khi tải dữ liệu');
        }
      });
    }
})(jQuery);