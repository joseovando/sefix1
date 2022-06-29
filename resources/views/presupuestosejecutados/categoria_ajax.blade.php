@for ($j = 0; $j <= $n_ajax; $j++)
    <tr id="tr_ajax_{{ $j }}" hidden>
        <th scope="row">
            <div id="categoria_ajax_{{ $j }}">
                <span></span>
            </div>
        </th>
        @for ($i = 0; $i <= $n_inputs; $i++)
            <td>
                <div class="input-group mb-3">

                    <input type="text" class="form-control" name="monto_ajax_{{ $j }}_{{ $i }}"
                        style="font-family: FontAwesome" id="monto_ajax_{{ $j }}_{{ $i }}"
                        placeholder="&#xf0d6;" value=""
                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">

                    <a href="" data-toggle="modal" data-target="#modal_ajax_{{ $j }}_{{ $i }}"><i
                            class="material-icons">description</i></a>

                    <div id="modal_ajax_{{ $j }}_{{ $i }}" class="modal fade" tabindex="-1"
                        role="dialog" aria-labelledby="exampleModalPopoversLabel" style="display: none;"
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

                                        <textarea class="form-control" name="detalle_ajax_{{ $j }}_{{ $i }}"
                                            id="detalle_ajax_{{ $j }}_{{ $i }}"
                                            rows="5"></textarea>

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

        <th scope="row" bgcolor="#fec87c">
            <div id="monto_ejecutado_ajax_{{ $j }}">
                <span></span>
            </div>
        </th>

        <th scope="row" bgcolor="#0cd0e8">
            <div id="monto_programado_ajax_{{ $j }}">
                <span></span>
            </div>
        </th>

        <th scope="row" bgcolor="#0cd0e8" id="th_diferencia_ajax_{{ $j }}">
            <div id="diferencia_ajax_{{ $j }}">
                <span></span>
            </div>
        </th>

        <th scope="row" bgcolor="#0cd0e8" id="th_porcentaje_ajax_{{ $j }}">
            <div id="porcentaje_ajax_{{ $j }}">
                <span></span>
            </div>
        </th>

    </tr>
@endfor
