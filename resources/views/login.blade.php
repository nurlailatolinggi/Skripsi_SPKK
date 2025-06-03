<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login - SPKK</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link rel="icon" href="{{asset('images/logo.png')}}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>
    <script src="{{asset('assets/js/core/jquery-3.7.1.min.js')}}"></script><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/kaiadmin.min.css')}}" />

  </head>
  <body>
    @if(session('notif') == true)
    <script>
      Swal.fire({
        icon: '{{ session('icon') }}',
        title: '{{ session('title') }}',
        text: '{{ session('message') }}',
      });
    </script>
    @endif
    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <h2 class="text-center text-dark mt-5">Sistem Penilaian Kinerja Karyawan</h2>
          <div class="card my-5">
  
            <form class="card-body cardbody-color p-lg-5" method="POST" action="{{route('loginact')}}">
              @csrf
              <div class="text-center">
                <img src="{{asset('images/avatar.png')}}" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-1"
                  width="100px" alt="profile">
              </div>
              
              <h5 class="text-center text-dark">Login Form</h5>
              <p class="text-center text-muted">Silahkan login untuk melanjutkan</p>
              <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username..." value="{{old('username')}}">
                @error('username')
                  <small class="text-danger">{{$message}}</small>
                @enderror
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password...">
                @error('password')
                  <small class="text-danger">{{$message}}</small>
                @enderror
              </div>
              <div class="text-center"><button type="submit" class="btn btn-primary px-5 mb-5 w-100">Login</button></div>
            </form>
          </div>
  
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Sweet Alert -->
    {{-- <script src="{{asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script> --}}

    <!-- Kaiadmin JS -->
    <script src="{{asset('assets/js/kaiadmin.min.js')}}"></script>
  </body>
</html>
