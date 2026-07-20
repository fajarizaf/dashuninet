@extends('layouts.console')
@section('container')


<div class="page-header d-print-none text-white">
    <div class="container-xl">
        
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Dokumentasi
                </div>
                <h2 class="page-title">
                    Panduan Pengguna
                </h2>
            </div>
        </div>

    </div>
</div>


<div class="page-body" style="margin-top:100px">

    <div class="container-xl">
        
        <div class="row g-4">

            <div class="col-3">
                <br/>
                <h2>{{$categori}}</h2>

                <div class="list-group list-group-transparent mb-3">

                    @forelse($list_documentation as $list)

                        <a class="list-group-item list-group-item-action d-flex align-items-center @if(Request::segment(4) == $list->id) active  @endif" style="padding-left:22px;" href="{{ url('/console/panduan/detail/'.$list->id) }}">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                            {{$list->title}}
                        </a>

                    @empty

                    @endforelse

                </div>

            </div>

            <div class="col-9">

                <div class="card card-lg">
                  <div class="card-body" style="line-height:2">
                    
                    @forelse($documentation as $doc)

                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ url('/console/panduan/') }}">Panduan</a></li>
                            <li class="breadcrumb-item"><a href="#">{{$categori}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{$doc->title}}</a></li>
                        </ol>
                    </div>
                    &nbsp;

                    <h1>{{$doc->title}}</h1>
                    <p style="color:#ccc;margin-top:-15px;">Terakhir di update : {{$doc->updated_at}}</p>
                    <br/>
                    {!!$doc->content!!}

                    @empty

                    @endforelse

                  </div>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection
