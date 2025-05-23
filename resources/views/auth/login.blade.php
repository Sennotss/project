@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <img src="{{ asset('assets/logo/logo-removebg-preview.png') }}" alt="Logo" height="50">
              {{-- <span class="app-brand-text demo text-body fw-bold">{{config('variables.templateName')}}</span> --}}
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Selamat datang di {{config('variables.templateName')}}!</h4>
          <p class="mb-4">Silakan masuk untuk melaporkan dan memantau kendala dengan lebih mudah.</p>

          <div id="error-message" class="alert alert-danger" style="display:none;"></div>
          <form id="formAuthentication" class="mb-3">
            <div class="mb-3">
              <label for="username" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $('#formAuthentication').on('submit', function (e) {
    let apiUrl = "{{config('api.base_url')}}/login";
    e.preventDefault();

    const email = $('#email').val();
    const password = $('#password').val();

    $.ajax({
      url: apiUrl,
      method: 'POST',
      contentType: 'application/json',
      dataType: 'json',
      data: JSON.stringify({
        email: email,
        password: password
      }),
      success: function (response) {
        localStorage.setItem('auth_token', response.access_token);
        localStorage.setItem('auth_user', JSON.stringify(response.user));
        localStorage.setItem('login_success', 'true');
        localStorage.setItem('user_role', response.user.role);
        $.post('/store-token', {
          _token: '{{ csrf_token() }}',
          token: response.access_token,
          user: response.user
        }, function () {
          window.location.href = '/dashboard';
        });
      },
      error: function (xhr) {
        let errMsg = 'Terjadi kesalahan saat login.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errMsg = xhr.responseJSON.message;
        }
        $('#error-message').text(errMsg).show();
      }
    });
  });
</script>
@if(session('error'))
<script>
  Swal.fire({
    icon: 'warning',
    title: 'Akses Ditolak',
    text: '{{ session('error') }}',
  })
</script>
@endif

@endsection
