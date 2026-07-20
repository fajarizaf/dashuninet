@extends('layouts.console')
@section('container')


<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-3 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Helps</div>
                <h2 class="page-title">User Documentation</h2>
            </div>
        </div>
    </div>
</div>


<div class="page-body">

    <div class="container-xl">

        <div class="row row-cards">

        @forelse($categori as $cat)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                  <!-- Photo -->
                  <div class="card-img-top" style="background:#ecf5fc;height:60px"></div>
                  <div class="card-body">
                    <h3 class="card-title"><span class="badge bg-azure-lt">Panduan</span> {{$cat->name_doc_cat}}</h3>

                    @inject("Documentation", "App\Http\Controllers\DocController")


                    {{ $Documentation::get_list_doc($cat->id) }}


                  </div>
                </div>
            </div>
        @empty
            <h3>No Documentation Found</h3>
        @endforelse

        </div>

    </div>

</div>

@endsection
