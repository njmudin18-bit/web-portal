<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="900">
  <title>{{ Config::get('constants.APPS_NAME'); }} | {{ Config::get('constants.COMPANY_NAME_FULL'); }}</title>
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('landing/images/icon.png') }}">
  <link rel="stylesheet" href="{{ asset('landing/bootstrap-4.0.0/dist/css/bootstrap.min.css') }}" crossorigin="anonymous">
  <link href="{{ asset('landing/css/customs.css') }}" rel="stylesheet">
  <style>
    .lds-dual-ring {
      display: inline-block;
      width: 80px;
      height: 80px;
    }
    .lds-dual-ring:after {
      content: " ";
      display: block;
      width: 64px;
      height: 64px;
      margin: 8px;
      border-radius: 50%;
      border: 6px solid #fff;
      border-color: #fff transparent #fff transparent;
      animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body>
  <div class="video-bg">
    <video width="320" height="240" autoplay loop muted>
      <source src="{{ asset('landing/video/7btrrd.mp4') }}" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>
  <div class="container app">
    <div class="row header">
      <div class="col-md-12 header-menu">
        <a class="menu-link is-active" href="#">{{ strtoupper(Config::get('constants.COMPANY_NAME_FULL')); }}</a>
      </div>
    </div>
    <div class="row wrapper">
      <div class="col-md-12 main-container">
        <div class="main-header">
          <a class="menu-link-main" href="#">All Apps</a>
        </div>
      </div>
      <div class="col-md-12 content-wrapper">
        <div class="content-section">
          <div class="content-section-title">PT. Multi Arta Sekawan</div>
          <div id="content_mas" class="apps-card"></div>

          <div id="loader" class="apps-card justify-content-center">
            <div class="lds-dual-ring"></div>
          </div>
        </div>
        <div class="content-section last">
          <div class="content-section-title">PT. Multi Arta Industri</div>
          <div id="content_main" class="apps-card"></div>

          <div id="loader2" class="apps-card justify-content-center">
            <div class="lds-dual-ring"></div>
          </div>
        </div>
        <div class="overlay-app"></div>
      </div>
      <script src="{{ asset('landing/js/jquery-3.7.0.min.js') }}"></script>
      <script src="{{ asset('landing/js/sweetalert2@11.js') }}"></script>
      <!-- <script src="{{ asset('landing/bootstrap-4.0.0/js/dist/popover.js') }}"></script> -->
      <script src="{{ asset('landing/bootstrap-4.0.0/dist/js/bootstrap.min.js') }}"></script>
      <script>
        var token = '{{ csrf_token() }}';

        function show_datas() {
          $.ajax({
            data: {
              "_token": token
            },
            url: "{{ route('apps.list') }}",
            type: "POST",
            dataType: "JSON",
            beforeSend: function(data) {
              console.log("aaa");
              $("#loader").show();
              $("#loader2").show();
            },
            success: function(data) {
              var mas_items = [];
              var main_items = [];

              var results = data.data;
              let mas_data = results.filter(function(res) {
                return res.corp_apps == "MAS";
              });

              let main_data = results.filter(function(res) {
                return res.corp_apps == "MAI";
              });

              $.each(mas_data, function(key, value) {
                let link_mas = "'" + value.link_apps + "'";
                let logo_mas = "{{ asset('landing/images/icon.png') }}";

                mas_items.push('<div class="app-card" onclick="save_to_log(' + link_mas + ')">' +
                  '<span>' +
                  '<img class="images rounded-circle" src="' + logo_mas + '">' +
                  value.nama_apps +
                  '</span>' +
                  '<div class="app-card__subtext">' +
                  value.deskripsi +
                  '</div>' +
                  '<div class="app-card-buttons">' +
                  '<button onclick="save_to_log(' + link_mas + ')" class="content-button status-button">visit</button>' +
                  '<div class="menu"></div>' +
                  '</div>' +
                  '</div>');
              });

              $.each(main_data, function(key, value) {
                let link_main = "'" + value.link_apps + "'";
                let logo_main = "{{ asset('landing/images/logo-main.png') }}";

                main_items.push('<div class="app-card" onclick="save_to_log(' + link_main + ')">' +
                  '<span>' +
                  '<img class="images rounded-circle" src="' + logo_main + '">' +
                  value.nama_apps +
                  '</span>' +
                  '<div class="app-card__subtext">' +
                  value.deskripsi +
                  '</div>' +
                  '<div class="app-card-buttons">' +
                  '<button onclick="save_to_log(' + link_main + ')" class="content-button status-button">visit</button>' +
                  '<div class="menu"></div>' +
                  '</div>' +
                  '</div>');
              });

              $("#loader").hide();
              $("#loader2").hide();

              $("#content_mas").html(mas_items);
              $("#content_main").html(main_items);
            },
            error: function(jqXHR, textStatus, errorThrown) {
              Swal.fire({
                title: 'Oops...',
                text: jqXHR.responseJSON.message,
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Refresh token',
                allowOutsideClick: false,
                footer: '<small>Klik tombol refresh token untuk mendapatkan token terbaru</small>'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.reload();
                }
              })
            }
          });
        }

        function save_to_log(link) {
          let url = link;

          window.open(url);

          // $.ajax({
          //   data: {
          //     "link": link,
          //     "_token": token
          //   },
          //   url: "{{ route('logs.save') }}",
          //   type: "POST",
          //   dataType: "JSON",
          //   beforeSend: function(data) {
          //     window.open(url);
          //   },
          //   success: function(data) {

          //   },
          //   error: function(jqXHR, textStatus, errorThrown) {
          //     Swal.fire(
          //       'Oops...',
          //       jqXHR.responseJSON.message,
          //       textStatus
          //     );
          //   }
          // });
        }

        $(document).ready(function() {
          show_datas();
        });
      </script>
</body>

</html>