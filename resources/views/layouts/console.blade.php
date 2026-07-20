<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Dashboard - PT. Uninet Media Sakti</title>
  <link rel="icon" href="{{ URL::asset('assets/static/logo-uninet-white.svg') }}" type="image/x-icon">
  <!-- CSS files -->
  <link href="{{ URL::asset('assets/dist/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/dist/css/demo.min.css?1692870487') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/dist/libs/choosen/chosen.css') }}" rel="stylesheet" />
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }
  </style>
</head>

<body>
  <script src="{{ URL::asset('assets/dist/js/demo-theme.min.js?1692870487') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <div class="page">

    

    @auth
    @include('component.navbar')
    @else

    @endauth

    <div class="page-wrapper">
      @yield('container')
    </div>

    @include('component.footer')

  </div>


  <!-- Libs JS -->
  <script src="{{ URL::asset('assets/dist/libs/nouislider/dist/nouislider.min.js?1692870487') }}" defer></script>
  <script src="{{ URL::asset('assets/dist/libs/litepicker/dist/litepicker.js?1692870487') }}" defer></script>
  <script src="{{ URL::asset('assets/dist/libs/tom-select/dist/js/tom-select.base.min.js?1692870487') }}"
    defer></script>

  <!-- Tabler Core -->
  <script src="{{ URL::asset('assets/dist/js/tabler.min.js?1692870487') }}" defer></script>
  <script src="{{ URL::asset('assets/dist/js/demo.min.js?1692870487') }}" defer></script>
  <script src="{{ URL::asset('assets/dist/libs/choosen/chosen.jquery.js') }}" defer></script>

</body>

</html>