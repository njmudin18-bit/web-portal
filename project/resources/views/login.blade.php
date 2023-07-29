<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
  <meta name="author" content="AdminKit">
  <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

  <link rel="preconnect" href="https://fonts.gstatic.com/">
  <link rel="shortcut icon" href="{{ asset('landing/images/icon.png') }}" />

  <link rel="canonical" href="pages-sign-in.html" />

  <title>Log In | {{ Config::get('constants.APPS_NAME'); }}</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">

  <!-- Choose your prefered color scheme -->
  <link href="{{ asset('assetss/css/light.css') }}" rel="stylesheet">
</head>
<!--
  HOW TO USE: 
  data-theme: default (default), dark, light, colored
  data-layout: fluid (default), boxed
  data-sidebar-position: left (default), right
  data-sidebar-layout: default (default), compact
-->

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
  <main class="d-flex w-100 h-100">
    <div class="container d-flex flex-column">
      <div class="row vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">

            <div class="text-center mt-4 mb-4">
              <img src="http://10.11.9.22:8080/omas-admin-page/upload/general_images/logo-mas.png" alt="Charles Hall" class="img-fluid" width="132" height="132" />
            </div>

            <div class="card">
              <div class="card-body">
                <div class="m-sm-4">
                  <div class="text-center">
                    <h1 class="h2">Welcome</h1>
                    <p class="lead">
                      Sign in to {{ Config::get('constants.APPS_NAME'); }}
                    </p>
                  </div>
                  <form id="login_form">
                    <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input class="form-control form-control-lg" type="text" name="username" id="username" placeholder="Enter your username" />
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Enter your password" />
                    </div>
                    <div>
                      <label class="form-check">
                        <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
                        <span class="form-check-label">
                          Remember me next time
                        </span>
                      </label>
                    </div>
                    <div class="text-center mt-3">
                      <button type="submit" id="button_login" class="btn btn-lg btn-primary">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="{{ asset('assetss/js/app.js') }}"></script>
  <script src="{{ asset('assetss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('landing/js/sweetalert2@11.js') }}"></script>

  <script>
    $(function() {
      $.validator.setDefaults({
        submitHandler: login_action
      });

      $('#login_form').validate({
        rules: {
          username: {
            required: true,
            minlength: 4,
          },
          password: {
            required: true,
            minlength: 5
          }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.mb-3').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });

      function login_action() {

        var username = $("#username").val();
        var password = $("#password").val();
        //var token = $("meta[name='csrf-token']").attr("content");
        var token = '{{ csrf_token() }}';

        $.ajax({
          type: 'POST',
          url: "{{ route('login.check_login') }}",
          data: {
            "username": username,
            "password": password,
            "_token": token
          },
          beforeSend: function() {
            $("#button_login").prop('disabled', true);
            $("#button_login").html('<div class="spinner-border text-warning" role="status"></div>');
          },
          success: function(response) {
            console.log(response);
            console.log(response.url);
            if (response.code == 200 && response.status == "success") {
              $("#button_login").prop('disabled', false);
              $("#button_login").html('Sign In');

              let timerInterval
              Swal.fire({
                icon: 'success',
                title: response.message,
                html: 'Anda akan diarahkan dalam <b></b> milliseconds.',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                  Swal.showLoading()
                  const b = Swal.getHtmlContainer().querySelector('b')
                  timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                  }, 100)
                },
                willClose: () => {
                  clearInterval(timerInterval)
                }
              }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                  window.location.href = "{{ route('dashboard') }}";
                }
              })
            }
          },
          error: function(xhr, status, error) {
            $("#button_login").prop('disabled', false);
            $("#button_login").html('Sign In');

            Swal.fire(
              'Oops...',
              xhr.responseJSON.message,
              'error'
            )
          }
        });
        return false;
      };
    });
  </script>
</body>

</html>