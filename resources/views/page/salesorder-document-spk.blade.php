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
  <title>{{$document_numbering}}/SPK/UMS/VIII/{{$now_year}}</title>
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

    <!-- <script src="https://cdn.jsdelivr.net/npm/signature_pad"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
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
                <form method="POST" action="{{ url('/console/salesorder/create_spk') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="order_id" value="{{ $order_id }}" />
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

                            <div class="card-header d-flex align-items-center justify-content-between">
                            
                                <h2 class="page-title text-nowrap">Dokumen SPK</h2>

                                <div class="row g-2">
                                    <div class="col-auto">
                                        <!-- jika BA maka bisa save spk -->
                                        @if(session('role_id') == 5 || session('role_id') == 3 )
                                        <!-- <div class="d-flex gap-1 gap-sm-2">
                                            <button type="submit" class="btn btn-outline-primary" title="Print Invoice">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                                                <span class="d-none d-lg-inline">&nbsp;Save</span>
                                            </button>
                                        </div> -->
                                        @endif
                                    </div>
                                    <div class="col-auto">
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
                    </div>
                    <!-- Page body -->
                    <div class="page-body">
                        <div class="container-xl">
                            <div class="card card-lg">
                                <div class="card-body">
                                    <div class="row justify-content-between mb-5">
                                        <div class="col-12 mb-5">
                                            <div class="d-sm-flex gap-3 justify-content-between align-items-center">
                                                <img class="mb-3 mb-sm-0" src="{{ URL::asset('assets/static/logo-uninet-white.svg') }}" width="150">
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
                                            <h1 style="text-align:center;font-size:26px">Surat Perintah Kerja </h1>
                                            <h1 style="text-align:center;font-size:26px;margin-top:-15px">Work Orders</h1>
                                        <div>
                                        <br/>
                                        <div class="col-12 mb-5">
                                            <table style="width:100%;border:1px solid #ccc">
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc" colspan="2">
                                                        
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Layanan Baru">
                                                            <span class="form-check-label"><b>Layanan Baru</b> / New Services</span>
                                                        </label>
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Kenaikan Layanan">
                                                            <span class="form-check-label"><b>Kenaikan Layanan</b> Services Upgrade</span>
                                                        </label>
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Penurunan Layanan">
                                                            <span class="form-check-label"><b>Penurunan Layanan</b> Services Downgrade</span>
                                                        </label>
                                                    </td>  
                                                <tr>
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Pemblokiran">
                                                            <span class="form-check-label"><b>Pemblokiran</b> Softblok</span>
                                                        </label>
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Pembukaan Blokir">
                                                            <span class="form-check-label"><b>Pembukaan Blokir</b> Open Softblok</span>
                                                        </label>
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Lain-lain">
                                                            <span class="form-check-label"><b>Lain-lain</b></span>
                                                        </label>
                                                    </td> 
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Pemutusan">
                                                            <span class="form-check-label"><b>Pemutusan</b></span>
                                                        </label>
                                                    </td> 
                                                <tr>   
                                            </table>
                                            <br/>

                                            <table style="width:100%;border:1px solid #ccc">
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Nomor</b><br/>
                                                        Number
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input name="spk_number" value="{{$document_numbering}}/SPK/UMS/VIII/{{$now_year}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Kepada</b><br/>
                                                        To
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input name="spk_to" value="" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Tanggal</b><br/>
                                                        Date
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input name="spk_date" value="{{$now}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Tembusan</b><br/>
                                                        CC
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input name="spk_cc" value="Administrasi Legal" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                </tr>   
                                            </table>
                                            <br/>

                                            <table style="width:100%;border:1px solid #ccc">
                                                <tr>
                                                    <td style="width:200px;border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>ID Pelanggan</b><br/>
                                                        Customer ID
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input disabled value="{{$customer->customer_number}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Nama Pelanggan</b><br/>
                                                        Customer Name
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input disabled value="{{$customer->customer_name}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                </tr> 
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Lokasi Pekerjaan</b><br/>
                                                        Address
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input disabled value="{{$customer->customer_address}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Email / No. Telp</b><br/>
                                                        Email / Phone Number
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input disabled value="{{$customer->customer_telp}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Customer Bill ID</b><br/>
                                                        No Tagihan Pelanggan
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input name="cust_bill_id" value="" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                </tr>   
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Perihal</b><br/>
                                                        Subject
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input name="subject" value="" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                </tr>  
                                            </table>
                                            <br/>

                                            <table style="width:100%;border:1px solid #ccc">
                                                <tr>
                                                    <td style="width:200px;border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Tanggal Pelaksanaan</b><br/>
                                                        Execution Date
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input name="execution_date" value="" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="date" class="form-control" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Uraian Pekerjaan</b><br/>
                                                        Working List
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <textarea name="working_list" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px;height:200px;" type="text" class="form-control"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Tanggal Upgrade</b><br/>
                                                        Upgrade Date
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input name="upgrade_date" value="" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="date" class="form-control" />
                                                    </td>
                                                </tr> 
                                            </table>
                                            <br/>
                                            
                                            

                                            <table style="width:100%;border:1px solid #ccc">
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;background:#ececec;border-right:1px solid #ccc;text-align:center"><b>Dibuat Oleh</b><br/> Prepared By</td>    
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;background:#ececec;text-align:center"><b>Diketahui Oleh</b><br/> Acknowledge By</td>   
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;background:#ececec;text-align:center"><h4 style="margin-bottom:0px;"><b>Dilaksanakan Oleh</b><br/>Executed by</h4></td>   
                                                <tr>
                                                <tr>   
                                                    <td style="height:200px;border-right: 1px solid #ccc"></td>
                                                    <td style="height:200px;border-right: 1px solid #ccc"></td>   
                                                    <td style="height:200px;border-right: 1px solid #ccc"></td>     
                                                </tr>
                                                <tr>   
                                                    <td style="border-right: 1px solid #ccc">
                                                        <input value="" placeholder="Contoh : Nia Eka Putri" style="text-align:center;border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                    <td style="border-right: 1px solid #ccc">
                                                        <input value="" placeholder="Contoh : Purwahono" style="text-align:center;border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>   
                                                    <td style="border-right: 1px solid #ccc">
                                                        <input value="" placeholder="Contoh : Topan Adi Saputra" style="text-align:center;border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>     
                                                </tr>
                                                <tr>   
                                                    <td style="border-right: 1px solid #ccc">
                                                        <input value="Administration Division"  style="text-align:center;border-radius:none;box-shadow:none;border:none;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                    <td style="border-right: 1px solid #ccc">
                                                        <input value="Technical Operational" style="text-align:center;border-radius:none;box-shadow:none;border:none;padding:5px" type="text" class="form-control" />
                                                    </td>   
                                                    <td style="border-right: 1px solid #ccc;">
                                                        <input value="Technical Operational" style="text-align:center;border-radius:none;box-shadow:none;border:none;padding:5px" type="text" class="form-control" />
                                                    </td>     
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
                </form>
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


