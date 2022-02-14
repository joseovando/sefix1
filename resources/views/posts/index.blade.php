@extends('layouts.app', ['activePage' => 'posts', 'titlePage' => __('CRUD Posts')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12 text-left">
                        <a href="{{route('posts.create')}}" class="btn btn-info">+ Crear</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Simple Table</h4>
                        <p class="card-category"> Here is a subtitle for this table</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        TITULO
                                    </th>
                                    <th>
                                        CONTENIDO
                                    </th>
                                    <th>
                                        ACCIONES
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                    <tr>
                                        <td>{{$post->id}}</td>
                                        <td>{{$post->titulo}}</td>
                                        <td>{{$post->contenido}}</td>
                                        <td>
                                            <form action="{{route('posts.destroy', $post->id)}}" method="POST">
                                                <a href="{{route('posts.edit', $post->id)}}"
                                                    class="btn btn-warning">Editar</a>
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection