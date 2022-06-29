@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => __('Categorias')])

@section('content')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <script type="text/javascript" language="javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/autoComplete.min.css') }}">

    <style>
        .scroll {
            margin-left: 5px;
            max-height: 400px;
            overflow-y: auto;
        }

        .margin {
            margin-left: 5px;
            margin-right: 5px;
        }

    </style>

    <div class="content">

        <div class="container-fluid">
            {{-- Create Buttons --}}
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-info btn-round btn-block" data-toggle="modal" data-target="#saveModal">
                        <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp; Nueva Categoria
                    </button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-info btn-round btn-block" data-toggle="modal" data-target="#saveModal2">
                        <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp; Nueva Subcategoria
                    </button>
                </div>
            </div>
            {{-- Create Buttons --}}

            <!-- Table -->
            @include('categorias.tablero')
            <!-- table -->

            <!-- Modal Create Categorias -->
            @include('categorias.modal_categoria')
            @include('categorias.modal_subcategoria')
            <!-- Modal Create Categorias -->
        </div>
    </div>
@endsection
@push('js')
    @include('categorias.scripts')
@endpush
