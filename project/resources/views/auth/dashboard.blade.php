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

  <link rel="canonical" href="{{ route('dashboard') }}" />

  <title>Dashboard | {{ Config::get('constants.APPS_NAME'); }}</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">

  <!-- Choose your prefered color scheme -->
  <link href="{{ asset('assetss/css/light.css') }}" rel="stylesheet">
  <link href="{{ asset('assetss/css/customs.css') }}" rel="stylesheet">
  <!-- <link href="css/dark.css" rel="stylesheet"> -->
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
  <div class="wrapper">
    <!-- SIDERBAR -->
    <x-side-bar></x-side-bar>
    <!-- SIDERBAR END -->

    <div class="main">
      <!-- NAVBAR TOP -->
      <x-nav-bar></x-nav-bar>
      <!-- NAVBAR TOP END -->

      <main class="content">
        <div class="container-fluid p-0">

          <div class="mb-3">
            <button id="tambah_btn" class="btn btn-info float-right" onclick="openModal();">Tambah apps</button>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title text-center">Daftar Apps</h5>
                  <hr>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table id="datatables-multi" class="table table-striped" style="width:150%">
                      <thead class="bg-primary text-white">
                        <tr>
                          <th>No</th>
                          <th width="13%">#</th>
                          <th>Status</th>
                          <th>Nama Apps</th>
                          <th>Link</th>
                          <th>Milik?</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </main>

      <!-- FOOTER -->
      <x-footer-bar></x-footer-bar>
      <!-- FOOTER END -->
    </div>
  </div>

  <!-- MODAL -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal title</h4>
          <button type="button" class="btn-close" aria-label="Close" onclick="reset_all()"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" style="display:none"></div>
          <form id="form_data">
            <input type="hidden" value="" id="kode" name="kode">
            <div class="form-group row mb-3">
              <label class="col-sm-2 col-form-label">Nama Apps</label>
              <div class="col-sm-10">
                <input type="text" name="nama_apps" id="nama_apps" class="form-control" required="required" autocomplete="off">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-2 col-form-label">Link Apps</label>
              <div class="col-sm-10">
                <input type="text" id="link_apps" name="link_apps" class="form-control" required="required" autocomplete="off">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-2 col-form-label">Deskripsi</label>
              <div class="col-sm-10">
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" required="required" autocomplete="off">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-2 col-form-label">Milik?</label>
              <div class="col-sm-10">
                <select id="milik" name="milik" class="form-select">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                  <option value="MAS">PT MAS</option>
                  <option value="MAI">PT MAIN</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-2 col-form-label">Status</label>
              <div class="col-sm-10">
                <select id="aktivasi" name="aktivasi" class="form-select">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                  <option value="Aktif">Aktif</option>
                  <option value="Tidak">Tidak</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-outline-danger waves-effect md-trigger" onclick="reset_all()">Close</button>
          <button id="savedata" type="button" class="btn btn-primary waves-effect waves-light" onclick="save()">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <div id="loading" class="loading">Loading&#8230;</div>

  <script src="{{ asset('assetss/js/app.js') }}"></script>
  <script src="{{ asset('assetss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('assetss/js/datatables.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    var save_method;
    var url;
    var token = '{{ csrf_token() }}';

    //FUNCTION OPEN MODAL CABANG
    function openModal() {
      save_method = 'add';
      $("#pass_div").show();
      $('#savedata').text('Simpan');
      $('#form_data')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tambah Apps'); // Set Title to Bootstrap modal title
      $(".form-group").parent().find('div').removeClass("has-error");
    }

    function edit_data(id) {
      save_method = 'update';
      $('#form_data')[0].reset();
      $(".form-group>div").removeClass("has-error");
      $('.help-block').empty();

      $.ajax({
        data: {
          "id": id,
          "_token": token
        },
        url: "{{ route('apps.edit') }}",
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          $('[name="kode"]').val(data.data.id);
          $('[name="nama_apps"]').val(data.data.nama_apps);
          $('[name="link_apps"]').val(data.data.link_apps);
          $('[name="deskripsi"]').val(data.data.deskripsi);
          $('[name="milik"]').val(data.data.corp_apps);
          $('[name="aktivasi"]').val(data.data.status);

          $('#modal').modal('show');
          $('.modal-title').text('Edit Apps');
          $('#savedata').text('Update');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire(
            'Oops...',
            jqXHR.responseJSON.message,
            textStatus
          );
        }
      });
    }

    function hapus_data(id) {
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, hapus',
        cancelButtonText: 'Tidak, Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            data: {
              "id": id,
              "_token": token
            },
            url: "{{ route('apps.hapus') }}",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              reload_table();
            },
            error: function(jqXHR, textStatus, errorThrown) {
              Swal.fire(
                'Oops...',
                jqXHR.responseJSON.message,
                textStatus
              );
            }
          });
        }
      })
    }

    //VALIDATION AND ADD USER
    function save() {
      var nama_apps = $("#nama_apps").val();
      var link_apps = $("#link_apps").val();
      var milik = $("#milik").val();
      var aktivasi = $("#aktivasi").val();
      var deskripsi = $("#deskripsi").val();
      var kode = $("#kode").val();

      if (save_method == 'add') {
        url = "{{ route('apps.simpan') }}";
      } else {
        url = "{{ route('apps.update') }}";
      }

      $.ajax({
        data: {
          "nama_apps": nama_apps,
          "link_apps": link_apps,
          "deskripsi": deskripsi,
          "milik": milik,
          "aktivasi": aktivasi,
          "id": kode,
          "_token": token
        },
        url: url,
        type: "POST",
        dataType: 'JSON',
        beforeSend: function(data) {
          $("#loading").show();
        },
        success: function(data) {
          if (data.code == 200) {
            reload_table();
            $('#modal').modal('hide');
          } else if (data.code == 500) {
            Swal.fire(
              'Oops...',
              data.message,
              'error'
            );
            $('#modal').modal('hide');
          } else {
            for (var i = 0; i < data.inputerror.length; i++) {
              console.log(data.inputerror[i]);
              $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
              $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
            }
          }

          $('#savedata').html('Simpan');
          $("#loading").hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $("#loading").hide();
          Swal.fire(
            'Oops...',
            jqXHR.responseJSON.message,
            textStatus
          );
          $('#savedata').html('Simpan');
        }
      });
    }

    function reset_all() {
      $('#modal').modal('hide');
    }

    //FUNCTION RELOAD TABLE
    function reload_table() {
      table.ajax.reload(null, false);
    }

    $(document).ready(function() {
      $("#loading").hide();

      table = $("#datatables-multi").DataTable({
        responsive: true,
        select: {
          style: "multi"
        },
        ajax: {
          url: "{{ route('apps.data') }}",
          type: "GET"
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_Row_Index',
            "className": "text-center",
            orderable: false,
            searchable: false
          },
          {
            data: 'action',
            "className": "text-center",
            orderable: false,
            searchable: false
          },
          {
            data: 'status_apps',
            "className": "text-center",
            orderable: false,
            searchable: false
          },
          {
            data: 'nama_apps'
          },
          {
            data: 'link_apps'
          },
          {
            data: 'corp_apps',
            "className": "text-left"
          }
        ]
      });

      $("#nama_apps").change(function() {
        $(this).parent().removeClass('has-error');
        $(this).next().empty();
      });

      $("#link_apps").change(function() {
        $(this).parent().removeClass('has-error');
        $(this).next().empty();
      });

      $("#deskripsi").change(function() {
        $(this).parent().removeClass('has-error');
        $(this).next().empty();
      });

      $("#milik").change(function() {
        $(this).parent().removeClass('has-error');
        $(this).next().empty();
      });

      $("#aktivasi").change(function() {
        $(this).parent().removeClass('has-error');
        $(this).next().empty();
      });
    });
  </script>
</body>

</html>