    {{-- categoria desactivada --}}
    <tr id="tr_{{ $vistaCategoria->id }}" @if (isset($categoria_desactivada[$vistaCategoria->id])) hidden @endif>
        {{-- categoria desactivada --}}

        {{-- valores iniciales --}}
        <script>
            $(function() {
                if ($("#monto_{{ $vistaCategoria->id }}").val() > 0) {

                    if ($("#frecuencia_{{ $vistaCategoria->id }}").val() == 1) {
                        div_{{ $vistaCategoria->id }}.style.display = 'none';
                        fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                        div2_{{ $vistaCategoria->id }}.style.display = 'none';
                        sin_caducidad_{{ $vistaCategoria->id }}.removeAttribute("required");
                    }

                    if ($("#sin_caducidad_{{ $vistaCategoria->id }}").is(":checked") == true) {
                        div_{{ $vistaCategoria->id }}.style.display = 'none';
                        fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                    }
                }
            });
        </script>
        {{-- valores iniciales --}}

        {{-- categoria desactivar --}}
        <td>
            <div class="togglebutton">
                <label>
                    <input type="checkbox" checked="" onclick="desactivarCategoria({{ $vistaCategoria->id }})"
                        name="check_{{ $vistaCategoria->id }}" id="check_{{ $vistaCategoria->id }}">
                    <span class="toggle toggle-danger"></span>
                </label>
            </div>
        </td>
        {{-- categoria desactivar --}}

        <th scope="row">{{ $vistaCategoria->categoria }}</th>

        {{-- categoria monto --}}
        <td>
            <div class="col-sm">
                <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}"
                        name="monto_{{ $vistaCategoria->id }}" id="monto_{{ $vistaCategoria->id }}" type="text"
                        style="font-family: FontAwesome" placeholder="&#xf0d6; monto"
                        @if (isset($monto[$vistaCategoria->id])) value="{{ $monto[$vistaCategoria->id] }}" @endif
                        style="width: 50px"
                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                    <span id="result"></span>
                    <script>
                        $("#monto_{{ $vistaCategoria->id }}").change(function() {
                            if ($("#monto_{{ $vistaCategoria->id }}").val() > 0) {
                                frecuencia_{{ $vistaCategoria->id }}.setAttribute("required", "")
                            } else {
                                frecuencia_{{ $vistaCategoria->id }}.removeAttribute("required");
                                inicio_{{ $vistaCategoria->id }}.removeAttribute("required");
                                div_{{ $vistaCategoria->id }}.style.display = 'initial';
                                fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                                div2_{{ $vistaCategoria->id }}.style.display = 'initial';
                            }
                        });
                    </script>
                </div>
            </div>

            <input type="hidden" name="id_{{ $vistaCategoria->id }}" id="id_{{ $vistaCategoria->id }}"
                @if (isset($id_ingreso_programado[$vistaCategoria->id])) value="{{ $id_ingreso_programado[$vistaCategoria->id] }}" @endif>
        </td>
        {{-- categoria monto --}}

        {{-- categoria frecuencia --}}
        <td>
            <div class="col-sm">
                <div class="form-group">
                    <select class="form-control" id="frecuencia_{{ $vistaCategoria->id }}"
                        name="frecuencia_{{ $vistaCategoria->id }}">
                        <option value="">Frecuencia</option>
                        @foreach ($frecuencias as $frecuencia)
                            <option value="{{ $frecuencia->id }}"
                                @if (isset($id_frecuencia[$vistaCategoria->id])) @if ($id_frecuencia[$vistaCategoria->id] == $frecuencia->id) 
                                                                        selected @endif
                                @endif
                                >
                                {{ $frecuencia->frecuencia }}
                            </option>
                        @endforeach
                    </select>
                    <script>
                        document.getElementById('frecuencia_' + '{!! $vistaCategoria->id !!}').addEventListener('change', function(
                            event) {

                            if ($("#monto_{{ $vistaCategoria->id }}").val() > 0) {
                                if ($("#frecuencia_{{ $vistaCategoria->id }}").val() == 1) {
                                    inicio_{{ $vistaCategoria->id }}.setAttribute("required", "");
                                    div_{{ $vistaCategoria->id }}.style.display = 'none';
                                    fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                                    div2_{{ $vistaCategoria->id }}.style.display = 'none';
                                    sin_caducidad_{{ $vistaCategoria->id }}.removeAttribute("required");
                                }

                                if ($("#frecuencia_{{ $vistaCategoria->id }}").val() > 1) {
                                    inicio_{{ $vistaCategoria->id }}.setAttribute("required", "");
                                    div_{{ $vistaCategoria->id }}.style.display = 'initial';
                                    fin_{{ $vistaCategoria->id }}.setAttribute("required", "");
                                    div2_{{ $vistaCategoria->id }}.style.display = 'initial';
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </td>
        {{-- categoria frecuencia --}}

        {{-- categoria caducidad --}}
        <td align="center">
            <div class="col-sm">
                <div class="form-check form-check-inline" id="div2_{{ $vistaCategoria->id }}">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="sin_caducidad_{{ $vistaCategoria->id }}"
                            @if (isset($caducidad[$vistaCategoria->id])) @if ($caducidad[$vistaCategoria->id] == 1) value="1" checked
                                                                @else
                                                                value="1" @endif
                            @endif
                        name="sin_caducidad_{{ $vistaCategoria->id }}">
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
            </div>
            <script type="text/javascript">
                $("#sin_caducidad_{{ $vistaCategoria->id }}").change(function() {

                    if ($("#monto_{{ $vistaCategoria->id }}").val() > 0) {
                        if (document.getElementById('sin_caducidad_' + '{!! $vistaCategoria->id !!}').checked === true) {
                            div_{{ $vistaCategoria->id }}.style.display = 'none';
                            fin_{{ $vistaCategoria->id }}.removeAttribute("required");
                        } else {
                            div_{{ $vistaCategoria->id }}.style.display = 'initial';
                            fin_{{ $vistaCategoria->id }}.setAttribute("required", "");
                        }
                    }
                });
            </script>
        </td>
        {{-- categoria caducidad --}}

        {{-- categoria fecha inicio --}}
        <td>
            <div class="col-sm">
                <div class="form-group">
                    <input id="inicio_{{ $vistaCategoria->id }}" width="80"
                        name="inicio_{{ $vistaCategoria->id }}"
                        @if (isset($fecha_inicio[$vistaCategoria->id])) value="{{ date('d/m/y', strtotime($fecha_inicio[$vistaCategoria->id])) }}" @endif />
                    <script>
                        var html = '#inicio_' + '{!! $vistaCategoria->id !!}';
                        $(html).datepicker({
                            showOtherMonths: true,
                            locale: 'es-es',
                            format: 'dd/mm/yy'
                        });
                    </script>
                </div>
            </div>
        </td>
        {{-- categoria fecha inicio --}}

        {{-- categoria fecha fin --}}
        <td>
            <div class="col-sm" id="div_{{ $vistaCategoria->id }}" style="initial">
                <div class="form-group">
                    <input id="fin_{{ $vistaCategoria->id }}" width="80" name="fin_{{ $vistaCategoria->id }}"
                        @if (isset($fecha_fin[$vistaCategoria->id])) value="{{ date('d/m/y', strtotime($fecha_fin[$vistaCategoria->id])) }}" @endif />
                    <script>
                        var html = '#fin_' + '{!! $vistaCategoria->id !!}';
                        $(html).datepicker({
                            showOtherMonths: true,
                            locale: 'es-es',
                            format: 'dd/mm/yy'
                        });
                    </script>
                </div>
            </div>
        </td>
        {{-- categoria fecha fin --}}
    </tr>
