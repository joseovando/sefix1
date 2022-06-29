<form autocomplete="off" class="form-horizontal" id="guardar_ejecutado">

    @csrf

    <div>
        <table id="example" class="display" style="width:100%">
            <thead class="thead-light">
                <tr>
                    <th scope="col">
                        <div class="form-group">
                            <select class="custom-select mr-sm-2" id="select_categoria" name="select_categoria">
                                @foreach ($vistaCategoriaPadres as $vistaCategoriaPadre)
                                    @if ($vistaCategoriaPadre->plantilla == 1)
                                        <option @if ($id_categoria == $vistaCategoriaPadre->id) selected @endif
                                            value="{{ $vistaCategoriaPadre->id }}">
                                            {{ $vistaCategoriaPadre->categoria }}
                                        </option>
                                    @else
                                        @if ($vistaCategoriaPadre->id_user == auth()->id())
                                            <option @if ($id_categoria == $vistaCategoriaPadre->id) selected @endif
                                                value="{{ $vistaCategoriaPadre->id }}">
                                                {{ $vistaCategoriaPadre->categoria }}
                                            </option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                            <input type="hidden" name="id_categoria" value="{{ $id_categoria }}">
                            <input type="hidden" name="menu" value="{{ $menu }}">
                            <input type="hidden" name="tipo" value="{{ $tipo }}">
                            <input type="hidden" name="date" value="{{ $date }}">
                        </div>
                    </th>
                    @for ($i = 0; $i <= $n_inputs; $i++)
                        <th scope="col">
                            <div id="calendario_{{ $i }}">
                                <span>{{ $calendario[$i] }}</span>
                            </div>
                        </th>
                    @endfor
                    <th scope="col">Total Ejecutado Mes</th>
                    <th scope="col">Total Programado Mes</th>
                    <th scope="col">Diferencia Mes</th>
                    <th scope="col">Porcentaje Mes</th>
                </tr>
            </thead>
            <tbody>
                @include('presupuestosejecutados.categoria_search')
                @include('presupuestosejecutados.categoria_ajax')
                @include('presupuestosejecutados.categoria_inicial')
            </tbody>
            <tfoot>
                <tr>
                    <th scope="row">Total</th>
                    @for ($i = 0; $i <= $n_inputs; $i++)
                        @if ($total_monto_dia[$i] > 0)
                            <th scope="row" bgcolor="#7adf7f" align="right">
                                <div id="total_dia_{{ $i }}">
                                    <span>{{ $total_monto_dia[$i] }}</span>
                                </div>

                            </th>
                        @else
                            <th scope="row" bgcolor="#7adf7f" align="right">
                                <div id="total_dia_{{ $i }}">
                                    <span></span>
                                </div>
                            </th>
                        @endif
                    @endfor
                    <th scope="row" bgcolor="#fec87c" align="right">
                        <div id="total_ejecutado">
                            <span>{{ $total_ejecutado_mes }}</span>
                        </div>
                    </th>
                    <th scope="row" bgcolor="#ff7777" align="right">
                        <div id="total_programado">
                            <span>{{ $total_programado_mes }}</span>
                        </div>
                    </th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row">
        <div class="card-footer ml-auto mr-auto">
            <button type="submit" id="guardarEjecutado" class="btn btn-primary">{{ __('Guardar') }}</button>
        </div>
    </div>
</form>
