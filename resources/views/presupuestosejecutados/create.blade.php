@extends('layouts.app', ['activePage' => 'presupuestosejecutados', 'titlePage' => __('Presuspuesto Ejecutado')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('posts.store') }}" autocomplete="off" class="form-horizontal">

                    @csrf

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Presupuesto Ejecutado') }}</h4>
                            <p class="card-category">{{ __('') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">17/02</th>
                                            <th scope="col">18/02</th>
                                            <th scope="col">19/02</th>
                                            <th scope="col">20/02</th>
                                            <th scope="col">21/02</th>
                                            <th scope="col">22/02</th>
                                            <th scope="col">23/02</th>
                                            <th scope="col">24/02</th>
                                            <th scope="col">25/02</th>
                                            <th scope="col">26/02</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Alimentación</th>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Pensión Hijos</th>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Regalos</th>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Bs.</span>
                                                    </div>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection