<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard KJS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Dashboard</a>
      </li>
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/" class="brand-link">
      <span class="brand-text font-weight-light text-center d-block">KJS</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <li class="nav-item">
          <a href="{{ url('/categories') }}" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>Kategori</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/services') }}" class="nav-link">
            <i class="nav-icon fas fa-briefcase"></i>
            <p>Jasa</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/hps') }}" class="nav-link">
            <i class="nav-icon fas fa-tags"></i>
            <p>HPS</p>
          </a>
        </li>
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
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Sidebar -->
  
  <!-- /.sidebar -->

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>
  
  <footer class="main-footer text-sm text-center">
    <strong>KJS © 2025</strong> | All rights reserved.
  </footer>
</div>

@yield('scripts')
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('asset/dist/js/adminlte.min.js') }}"></script>


</body>
</html>
