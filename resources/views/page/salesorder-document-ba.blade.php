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
  <title>{{$document_numbering}}/BA-A/UMS/X/{{$now_year}}</title>
  <link rel="icon" href="{{ URL::asset('assets/static/logo-uninet-white.svg') }}" type="image/x-icon">
  <!-- CSS files -->
  <link href="{{ URL::asset('assets/dist/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/dist/css/demo.min.css?1692870487') }}" rel="stylesheet" />
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
      
        

<div class="page-body">
    <div class="container-xl">
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
                    @if(session()->has('success'))
                        <div class="alert alert-important alert-info alert-dismissible" style="border-radius:0px;" role="alert">
                            <div class="d-flex">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                                </div>
                                <div>
                                    {{ session('success') }}
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif

                    @if(session()->has('failed'))
                        <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;" role="alert">
                            <div class="d-flex">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                                </div>
                                <div>
                                    {{ session('failed') }}
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif

                    <div class="row g-3 align-items-center justify-content-between">
                       
                            <div class="col-12 col-sm-auto">
                                <div class="d-flex gap-2 align-items-center justify-content-between">
                                    <h2 class="page-title text-nowrap">Dokument Berita Acara</h2>
                                </div>
                            </div>

                            <div class="col-12 col-sm-auto">
                                @if(session('role_id') != 2 && session('role_id') != 7)
                                <div class="d-flex gap-1 gap-sm-2">
                                    <button type="button" class="btn btn-outline-cyan" onclick="javascript:window.print();" title="Print Invoice">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path></svg>
                                        <span class="d-none d-lg-inline">&nbsp;Print Invoice</span>
                                    </button>
                                </div>
                                @endif
                            </div>
                       
                    </div>
                </div>
            </div>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="card card-lg">
                        <div class="card-body">
                            <div class="row justify-content-between mb-5">
                                <div class="col-12 mb-5">
                                    <div class="d-sm-flex gap-3 justify-content-between align-items-center">
                                        <img class="mb-3 mb-sm-0" src="{{ URL::asset('assets/static/logo-uninet-white.svg') }}" width="200">
                                        <div>
                                            <div class="fw-bold mb-2">PT. UNINET MEDIA SAKTI</div>
                                            <div class="mb-2 small" style="font-size:10px;">
                                                GRAHA UNINET,<br>
                                                Jl. Warung Buncit Raya, No.25, Pejaten Barat,<br>
                                                Jakarta Selatan - 12710<br>
                                                Phone : 0217940911<br>
                                                Fax : 02179199234<br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-5">
                                    <h1 style="text-align:center;font-size:32px">Berita Acara Aktivasi</h1>
                                    <div class="row" style="width:310px;margin:0px auto">
                                        <div class="col-2"><h3>No :</h3></div>
                                        <div class="col-10"><input value="{{$document_numbering}}/BA-A/UMS/X/{{$now_year}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc" type="text" class="form-control" /></div>
                                    </div>
                                <div>
                                <br/>
                                <br/>
                                <div class="col-12 mb-5">
                                    <p>Pada tanggal ({{$now}}), bersama sama memeriksa layanan dengan spesifikasi berikut :</p>
                                    <table style="width:100%;border:1px solid #ccc">
                                        <tr>
                                            <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;background:#ececec;" colspan="2"><h4 style="margin-bottom:0px;">Data Pelanggan</h4></td>     
                                        <tr>
                                        <tr>
                                            <td style="width:300px;padding-left:10px;"><b>Nama Pelanggan</b></td>    
                                            <td ><input value="{{$customer->customer_name}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" /></td>   
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">Alamat</td>    
                                            <td ><textarea  style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control">{{$customer->customer_address}}</textarea></td>   
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">Informasi Kontak</td>    
                                            <td ><input value="{{$customer->customer_name}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" /></td>   
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">Email / No Telp</td>    
                                            <td ><input value="{{$customer->customer_telp}}" style="border-radius:none;box-shadow:none;border:none;padding:5px" type="text" class="form-control" /></td>   
                                        </tr>
                                    </table>
                                    <br/>
                                    <table style="width:100%;border:1px solid #ccc">
                                        <tr>
                                            <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;background:#ececec;" colspan="2"><h4 style="margin-bottom:0px;">Data Teknis</h4></td>     
                                        <tr>
                                        <tr>
                                            <td style="width:300px;padding-left:10px;"><b>Jenis Layanan</b></td>    
                                            <td ><input value="" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" /></td>   
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">Tanggal Aktivasi</td>    
                                            <td ><input value="{{$now}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="date" class="form-control" /></td>   
                                        </tr>
                                    </table>
                                    <br/>
                                    <br/>
                                        <p>
                                        Telah dialokasikan oleh PT. Uninet Media Sakti untuk pelanggan terhitung sejak tanggal Berita Acara ini. Jangka waktu berlangganan jasa minimum 1 (satu) tahun sebagaimana tercantum dalam FKB/MSA.</p>
                                        
                                        <p>Dan berlaku terhitung sejak tanggal diterbitkannya BAA untuk masing masing pihak. Jika customer ingin melakukan terminasi dini harap memberitahu pihak PT. Uninet Media Sakti melalui surat resmi dan akan diproses 30 hari setelah Pihak PT. Uninet Media Sakti menerimanya, dan jika Pihak Customer melakukan Terminasi dini sebelum masa berlangganan 1 tahun maka Customer akan dikenakan sanksi yang berlaku sesuai dengan ketentuan yang tercantum dalam FKB/MSA.
                                        Segala hal yang berkaitan pengguna dan pemanfaatan layanan tersebut adalah sepenuhnya tanggung jawab PELANGGAN. Maka dengan ini pelanggan bersedia membayar fasilitas tersebut sesuai dengan Perjanjian/Kesepakatan yang telah disetujui.</p>
                                        <p>
                                        Demikian Berita Acara ini dibuat dan mempunyai kekuatan hukum yang sama setelah ditandatangani oleh kedua belah pihak.
                                        </p>
                                    <br/>
                                    <br/>

                                    <table style="width:100%;border:1px solid #ccc">
                                        <tr>
                                            <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;background:#ececec;border-right:1px solid #ccc;text-align:center"><h4 style="margin-bottom:0px;">PT. Uninet Media Sakti</h4></td>    
                                            <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;background:#ececec;text-align:center"><h4 style="margin-bottom:0px;">{{$customer->customer_name}}</h4></td>   
                                        <tr>
                                        <tr>   
                                            <td style="height:300px;border-right: 1px solid #ccc"></td>   
                                        </tr>
                                    </table>
                                <div>
                                
                            </div>

                            

                        </div>
                    </div>

                    <br/>

                    

                    
                        

                        
                    </div>

                </div>
            </div>

        </div>


    </div>

</div>


<style>
    .navbar-overlap:after {
        height: 0px !important;
    }

    .btnactive {
        background-color: #206bc4;
        color: #fff;
    }

    .tables td {
        padding:4px;
    }

    .btn-upload {
        cursor:pointer;
    }
</style>


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

</body>

</html>









