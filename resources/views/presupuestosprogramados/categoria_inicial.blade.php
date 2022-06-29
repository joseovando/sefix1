@for ($i = 0; $i <= $cantidad_tr; $i++)

    {{-- categorias plantilla --}}
    @if ($categoria_plantilla[$i] == 1)
        @include('presupuestosprogramados.categoria_inicial_plantilla')
    @else
        {{-- categorias plantilla --}}

        {{-- categorias usuario --}}
        @if ($categoria_user[$i] == auth()->id())
            @include('presupuestosprogramados.categoria_inicial_plantilla')
        @endif
        {{-- categorias usuario --}}

        @if ($id_categoria_array[$i] == 0)
            @include('presupuestosprogramados.categoria_inicial_plantilla')
        @endif
    @endif
@endfor
