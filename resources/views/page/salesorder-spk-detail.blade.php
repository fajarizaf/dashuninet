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
  <title>{{$spk->spk_number}}</title>
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
    <style>
        canvas {
            width: 100%;
            max-width: 400px;
            height: 200px;
            background-color: #f8f8f8;
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

                            <div class="card-header d-flex align-items-center justify-content-between">
                            
                                <h2 class="page-title text-nowrap">Dokumen SPK </h2>

                                <div class="row g-2">
                                    <div class="col-auto">
                                    <div class="col-auto">
                                        @if(session('role_id') != 2 && session('role_id') != 7)
                                        <div class="d-flex gap-1 gap-sm-2">
                                            <button type="button" class="btn btn-outline-cyan" onclick="printSection('cetak-area')" title="Print Invoice">
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
                    <div class="page-body" id="cetak-area">
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
                                                            <input class="form-check-input" type="radio" name="type" value="Layanan Baru" {{ $spk->spk_type == 'Layanan Baru' ? 'checked' : '' }}>
                                                            <span class="form-check-label"><b>Layanan Baru</b> / New Services</span>
                                                        </label>
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Kenaikan Layanan" {{ $spk->spk_type == 'Kenaikan Layanan' ? 'checked' : '' }}>
                                                            <span class="form-check-label"><b>Kenaikan Layanan</b> Services Upgrade</span>
                                                        </label>
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Penurunan Layanan" {{ $spk->spk_type == 'Penurunan Layanan' ? 'checked' : '' }}>
                                                            <span class="form-check-label"><b>Penurunan Layanan</b> Services Downgrade</span>
                                                        </label>
                                                    </td>  
                                                <tr>
                                                <tr>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Pemblokiran" {{ $spk->spk_type == 'Pemblokiran' ? 'checked' : '' }}>
                                                            <span class="form-check-label"><b>Pemblokiran</b> Softblok</span>
                                                        </label>
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Pembukaan Blokir" {{ $spk->spk_type == 'Pembukaan Blokir' ? 'checked' : '' }}>
                                                            <span class="form-check-label"><b>Pembukaan Blokir</b> Open Softblok</span>
                                                        </label>
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Lain-lain" {{ $spk->spk_type == 'Lain-lain' ? 'checked' : '' }}>
                                                            <span class="form-check-label"><b>Lain-lain</b></span>
                                                        </label>
                                                    </td> 
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" value="Pemutusan" {{ $spk->spk_type == 'Pemutusan' ? 'checked' : '' }}>
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
                                                        <input readonly value="{{$spk->spk_number}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Kepada</b><br/>
                                                        To
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input readonly  value="{{$spk->spk_to}}" value="" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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
                                                        <input readonly value="{{$spk->spk_date}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;border-right:1px solid #ccc">
                                                        <b>Tembusan</b><br/>
                                                        CC
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;width:10px;border-right:1px solid #ccc">
                                                        :
                                                    </td>
                                                    <td style="border-bottom:1px solid #ccc;padding:5px;padding-left:10px;">
                                                        <input readonly value="{{$spk->spk_cc}}" value="Administrasi Legal" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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
                                                        <input readonly value="{{$customer->customer_number}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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
                                                        <input readonly value="{{$customer->customer_name}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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
                                                        <input readonly value="{{$customer->customer_address}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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
                                                        <input readonly value="{{$customer->customer_email}} / {{$customer->customer_phone}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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
                                                        <input readonly value="{{$spk->cust_bill_id}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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
                                                        <input readonly value="{{$spk->subject}}" value="" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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
                                                        <input readonly value="{{date('d-M-Y', strtotime($spk->execution_date))}}" value="" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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
                                                        <textarea readonly name="working_list" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px;height:70px" type="text" class="form-control">{{$spk->working_list}}</textarea>
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
                                                        <input readonly value="{{date('d-M-Y', strtotime($spk->upgrade_date))}}" style="border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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
                                                    <td style="height:10px;border-right: 1px solid #ccc"></td>
                                                    <td style="height:10px;border-right: 1px solid #ccc"></td>   
                                                    <td style="height:10px;border-right: 1px solid #ccc"></td>     
                                                </tr>
                                                <tr>   
                                                    <td style="border-right: 1px solid #ccc" class="text-center">
                                                        <img style="max-width: 300px;max-height: 90px;" src="{{ env('BACKEND_URL') }}/image/get/ums/{{ $spk->signature_ba }}" />
                                                        <input value="{{ $spk->name_ba}}" readonly placeholder="Contoh : Nia Eka Putri" style="text-align:center;border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>
                                                    <td style="border-right: 1px solid #ccc" class="text-center">
                                                        <img style="max-width: 300px;max-height: 90px;" src="{{ env('BACKEND_URL') }}/image/get/ums/{{ $spk->signature_acknowledge }}" />
                                                        <input value="{{ $spk->name_acknowledge}}" readonly placeholder="Contoh : Purwahono" style="text-align:center;border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
                                                    </td>   
                                                    <td style="border-right: 1px solid #ccc" class="text-center">
                                                        <img style="max-width: 300px;max-height: 90px;" src="{{ env('BACKEND_URL') }}/image/get/ums/{{ $spk->signature_acknowledge }}" />
                                                        <input value="{{ $spk->name_executed}}" readonly placeholder="Contoh : Topan Adi Saputra" style="text-align:center;border-radius:none;box-shadow:none;border:none;border-bottom:1px solid #ccc;padding:5px" type="text" class="form-control" />
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


                </div>


            </div>

        </div>
        <div class="card m-4 p-5">
        <h2>Tanda Tangan</h2>
        <div class="d-flex gap-1 gap-sm-2">
            <button class="btn btn-success" id="clear">Reset</button>
            <button class="btn btn-primary" id="save">Save</button>
        </div>
        <br>
        <canvas id="signature-pad" width="400" height="200" style="border: 1px solid #000;"></canvas>
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

    <script>
        const canvas = document.getElementById("signature-pad");
        const signaturePad = new SignaturePad(canvas, {
            minWidth: 1,
            maxWidth: 1,
        });

        const clearButton = document.getElementById("clear");
        const saveButton = document.getElementById("save");

        // Hapus tanda tangan
        clearButton.addEventListener("click", () => {
            signaturePad.clear();
        });

        // Simpan tanda tangan sebagai gambar
        saveButton.addEventListener("click", () => {
            if (!signaturePad.isEmpty()) {
                const dataURL = signaturePad.toDataURL("image/png");

                $.ajax({

                    type: 'POST',
                    url: "{{ route('upload_signature') }}",
                    data: JSON.stringify({
                        signature: dataURL,
                        id: '{{ $spk->id }}'
                    }),
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        console.log(data);
                        window.location.reload();
                    }

                });

                console.log("Tanda tangan tersimpan:", dataURL);
                // alert("Tanda tangan berhasil disimpan!");
            } else {
                alert("Silakan buat tanda tangan dulu!");
            }
        });


        function printSection(sectionId) {
            const content = document.getElementById(sectionId).innerHTML;
            const original = document.body.innerHTML;
            
            document.body.innerHTML = content; // Ganti seluruh body dengan elemen yang ingin dicetak
            window.print();
            document.body.innerHTML = original; // Kembalikan tampilan semula
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('._token').val()
            }
        });

</script>
</body>

</html>


