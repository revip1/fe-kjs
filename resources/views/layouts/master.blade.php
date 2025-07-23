<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard KJS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- CSS Plugin --}}
  <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  {{-- Navbar (Header Atas) --}}
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">

      {{-- Tombol toggle sidebar --}}
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

      {{-- Link ke Dashboard --}}
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Dashboard</a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  {{-- Sidebar (Navigasi Kiri) --}}
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    {{-- Logo Sidebar --}}
    <a href="/" class="brand-link text-center">
      <span class="brand-text font-weight-light d-block">KJS</span>
    </a>

    {{-- Menu Navigasi --}}
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">

          {{-- Link ke halaman Kategori --}}
          <li class="nav-item">
            <a href="{{ url('/categories') }}" class="nav-link">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>Kategori</p>
            </a>
          </li>

          {{-- Link ke halaman Jasa --}}
          <li class="nav-item">
            <a href="{{ url('/services') }}" class="nav-link">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>Jasa</p>
            </a>
          </li>

          {{-- Link ke halaman HPS --}}
          <li class="nav-item">
            <a href="{{ url('/hps') }}" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>HPS</p>
            </a>
          </li>

          {{-- Link ke halaman Overview --}}
          <li class="nav-item">
            <a href="{{ url('/overview') }}" class="nav-link">
              <i class="nav-icon fas fa-eye"></i>
              <p>Overview</p>
            </a>
          </li>

        </ul>
      </nav>
    </div>
  </aside>
  <!-- /.sidebar -->

  {{-- Content Wrapper --}}
  <div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">
        {{-- Tempat untuk konten halaman anak --}}
        @yield('content')
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  {{-- Footer --}}
  <footer class="main-footer text-sm text-center">
    <strong>KJS © 2025</strong> | All rights reserved.
  </footer>
</div>
<!-- /.wrapper -->

{{-- Section untuk script tambahan tiap halaman --}}
@yield('scripts')

{{-- JavaScript bawaan AdminLTE --}}
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('asset/dist/js/adminlte.min.js') }}"></script>

</body>
</html>
