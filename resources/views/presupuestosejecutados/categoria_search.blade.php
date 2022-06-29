<tr id="tr_search" hidden>
    <th scope="row" id="search_categoria"></th>

    @for ($i = 0; $i <= $n_inputs; $i++)
        <td>
            <div class="input-group mb-3">

                <input type="text" class="form-control" name="search_{{ $fechas[$i] }}"
                    style="font-family: FontAwesome" id="search_{{ $fechas[$i] }}" placeholder="&#xf0d6;" value=""
                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">

                <a href="" data-toggle="modal" data-target="#search_modal_{{ $fechas[$i] }}"><i
                        class="material-icons">description</i></a>

                <div id="search_modal_{{ $fechas[$i] }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalPopoversLabel" style="display: none;" aria-hidden="true">
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
                                    <textarea class="form-control" name="detalle_{{ $fechas[$i] }}" id="detalle_{{ $fechas[$i] }}"
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
        <div id="monto_ejecutado">
            <span></span>
        </div>
    </th>
    <th scope="row" bgcolor="#ff7777">
        <div id="monto_programado">
            <span></span>
        </div>
    </th>
    <th scope="row" bgcolor="" id="th_diferencia_search">
        <div id="diferencia_mes">
            <span></span>
        </div>
    </th>
    <th scope="row" bgcolor="" id="th_porcentaje_search">
        <div id="porcentaje_mes">
            <span></span>
        </div>
    </th>

</tr>
