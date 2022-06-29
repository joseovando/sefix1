@foreach ($vistaCategorias as $vistaCategoria)
    {{-- @if ($vistaCategoria->plantilla == 1) --}}
    @if ($array_categoria[$vistaCategoria->id_categoria]['plantilla'] == 1)
        @include(
            'presupuestosejecutados.categoria_inicial_plantilla'
        )
    @else
        {{-- @if ($vistaCategoria->id_user == auth()->id()) --}}
        @if ($array_categoria[$vistaCategoria->id_categoria]['id_user'] == auth()->id())
            @include(
                'presupuestosejecutados.categoria_inicial_usuario'
            )
        @endif
    @endif
@endforeach
