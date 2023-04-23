setInterval(showTime, 1000);
function showTime() {
    let time = new Date();
    let hour = time.getHours();
    let min = time.getMinutes();
    let sec = time.getSeconds();
    let date = time.getDate();
    let month = time.getMonth();
    let year = time.getFullYear();
    am_pm = " AM";
  
    if (hour > 12) {
        hour -= 12;
        am_pm = " PM";
    }
    if (hour == 0) {
        hr = 12;
        am_pm = "AM";
    }
  
    hour = hour < 10 ? "0" + hour : hour;
    min = min < 10 ? "0" + min : min;
    sec = sec < 10 ? "0" + sec : sec;
  
    let currentTime = hour + ":" 
            + min + ":" + sec + am_pm;
  
    document.getElementById("clock")
            .innerHTML = currentTime;
}
showTime();

function changeStatusCheckButtons() {
  $.ajax({
    url: $('#get_self_check_status').val(), // đường dẫn tới tệp JSON trên máy chủ
    method: 'GET',
    dataType: 'json', // định dạng dữ liệu là JSON
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function(){
      // $('.loading-effect').show();
    },
    success: function(data) {
      $('.loading-effect').hide();
      if (data.response.first_checkin == 'null') {
        $('#btn_checked_in').hide();
        $('#btn_check_in').removeClass('visually-hidden');
      } else {
        $('#btn_check_out').removeAttr('disabled');
      }
    },
    error: function() {
      // Xử lý lỗi khi tải dữ liệu thất bại
      $('.loading-effect').hide();
      alert('Lỗi khi tải dữ liệu');
    }
  });
}
changeStatusCheckButtons();
(function ($) {
    $(document).on("click", ".btn-check-in-out .btn-attendance", function (e) {
      let type_check = $(this).data("check");
      e.preventDefault();
        $.ajax({
            url: $('#update_list_calendar').val(), // đường dẫn tới tệp JSON trên máy chủ
            method: 'POST',
            dataType: 'json', // định dạng dữ liệu là JSON
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
              type_check: type_check
            },
            beforeSend: function(){
              $('.loading-effect').show();
            },
            success: function(data) {
              $('.loading-effect').hide();
              if (data.status_code == 333) {
                alert('You had checked out very fast !Please check out after ' + data.minute_delay + ' minutes');
              } else if (data.status_code == 222) {
                alert('You had checked in!');
              }else if (data.response.first_checkin) {
                $('#btn_check_out').removeAttr('disabled');
                $('#btn_check_in').addClass('visually-hidden');
                $('#btn_checked_in').show();
              }
            },
            error: function() {
              // Xử lý lỗi khi tải dữ liệu thất bại
              $('.loading-effect').hide();
              alert('Lỗi khi tải dữ liệu');
            }
          });
    });
})(jQuery);