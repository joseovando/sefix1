<tr id="tr_inicial_{{ $vistaCategoria->id_categoria }}">
    <th scope="row">{{ $array_categoria[$vistaCategoria->id_categoria]['id_categoria'] }}</th>
    @for ($i = 0; $i <= $n_inputs; $i++)
        <td>
            <div class="input-group mb-3">

                <input type="text" class="form-control"
                    name="{{ $vistaCategoria->id_categoria }}_{{ $fechas[$i] }}" style="font-family: FontAwesome"
                    id="{{ $vistaCategoria->id_categoria }}_{{ $fechas[$i] }}" placeholder="&#xf0d6;"
                    @if (isset($egreso[$i][$vistaCategoria->id_categoria])) value="{{ $egreso[$i][$vistaCategoria->id_categoria] }}"
                    @else value="" @endif
                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">

                <a href="" data-toggle="modal"
                    data-target="#modal_{{ $vistaCategoria->id_categoria }}_{{ $fechas[$i] }}"><i
                        class="material-icons">description</i></a>

                <div id="modal_{{ $vistaCategoria->id_categoria }}_{{ $fechas[$i] }}" class="modal fade"
                    tabindex="-1" role="dialog" aria-labelledby="exampleModalPopoversLabel" style="display: none;"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalPopoversLabel">
                                    Detalle
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Detalle</label>
                                    @if (isset($detalle[$i][$vistaCategoria->id_categoria]))
                                        <textarea class="form-control" name="detalle_{{ $vistaCategoria->id_categoria }}_{{ $fechas[$i] }}"
                                            id="detalle_{{ $vistaCategoria->id_categoria }}_{{ $fechas[$i] }}"
                                            rows="5">{{ $detalle[$i][$vistaCategoria->id_categoria] }}</textarea>
                                    @else
                                        <textarea class="form-control" name="detalle_{{ $vistaCategoria->id_categoria }}_{{ $fechas[$i] }}"
                                            id="detalle_{{ $vistaCategoria->id_categoria }}_{{ $fechas[$i] }}"
                                            rows="3"></textarea>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </td>
    @endfor

    @if ($total_ejecutado_subcategoria[$vistaCategoria->id_categoria] > 0)
        <th scope="row" bgcolor="#fec87c">
            <div id="monto_ejecutado_{{ $vistaCategoria->id_categoria }}">
                <span>
                    {{ $total_ejecutado_subcategoria[$vistaCategoria->id_categoria] }}
                </span>
            </div>
        </th>
    @else
        <th scope="row" bgcolor="#fec87c">
            <div id="monto_ejecutado_{{ $vistaCategoria->id_categoria }}">
                <span>0</span>
            </div>
        </th>
    @endif

    @if ($total_programado_subcategoria[$vistaCategoria->id_categoria] > 0)
        <th scope="row" bgcolor="#ff7777">
            <div id="monto_programado_{{ $vistaCategoria->id_categoria }}">
                <span>
                    {{ $total_programado_subcategoria[$vistaCategoria->id_categoria] }}
                </span>
            </div>
        </th>
    @else
        <th scope="row" bgcolor="#ff7777">
            <div id="monto_programado_{{ $vistaCategoria->id_categoria }}">
                <span>0</span>
            </div>
        </th>
    @endif

    @if ($diferencia[$vistaCategoria->id_categoria] == 0)
        <th scope="row" bgcolor="{{ $color_porcentaje[$vistaCategoria->id_categoria] }}" id="th_diferencia_{{ $vistaCategoria->id_categoria }}">
            <div id="diferencia_{{ $vistaCategoria->id_categoria }}">
                <span>0</span>
            </div>
        </th>
    @else
        <th scope="row" bgcolor="{{ $color_porcentaje[$vistaCategoria->id_categoria] }}" id="th_diferencia_{{ $vistaCategoria->id_categoria }}">
            <div id="diferencia_{{ $vistaCategoria->id_categoria }}">
                <span>
                    {{ $diferencia[$vistaCategoria->id_categoria] }}
                </span>
            </div>
        </th>
    @endif

    @if ($porcentaje[$vistaCategoria->id_categoria] > 0)
        <th scope="row" bgcolor="{{ $color_porcentaje[$vistaCategoria->id_categoria] }}" id="th_porcentaje_{{ $vistaCategoria->id_categoria }}">
            <div id="porcentaje_{{ $vistaCategoria->id_categoria }}">
                <span>
                    {{ $porcentaje[$vistaCategoria->id_categoria] }}
                </span>
            </div>
        </th>
    @else
        <th scope="row" bgcolor="{{ $color_porcentaje[$vistaCategoria->id_categoria] }}" id="th_porcentaje_{{ $vistaCategoria->id_categoria }}">
            <div id="porcentaje_{{ $vistaCategoria->id_categoria }}">
                <span>0</span>
            </div>
        </th>
    @endif
</tr>
