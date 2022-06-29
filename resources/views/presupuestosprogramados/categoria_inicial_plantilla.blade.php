    {{-- categoria desactivada --}}
    <tr id="tr_{{ $i }}" @if (isset($categoria_desactivada[$id_categoria_array[$i]])) hidden @endif
        @if ($id_categoria_array[$i] == 0) hidden @endif>
        {{-- categoria desactivada --}}

        {{-- valores iniciales --}}
        <script>
            $(function() {
                if ($("#monto_{{ $i }}").val() > 0) {

                    if ($("#frecuencia_{{ $i }}").val() == 1) {
                        div_{{ $i }}.style.display = 'none';
                        fin_{{ $i }}.removeAttribute("required");
                        div2_{{ $i }}.style.display = 'none';
                        sin_caducidad_{{ $i }}.removeAttribute("required");
                    }

                    if ($("#sin_caducidad_{{ $i }}").is(":checked") == true) {
                        div_{{ $i }}.style.display = 'none';
                        fin_{{ $i }}.removeAttribute("required");
                    }
                }
            });
        </script>
        {{-- valores iniciales --}}

        {{-- categoria desactivar --}}
        <td>
            <div class="togglebutton">
                <label>
                    <input type="checkbox" checked="" onclick="desactivarCategoria({{ $i }})"
                        name="check_{{ $i }}" id="check_{{ $i }}">
                    <span class="toggle toggle-danger"></span>
                </label>
            </div>
        </td>
        {{-- categoria desactivar --}}

        <th scope="row">
            <div id="categoria_name_{{ $i }}">
                <span>{{ $categoria_name[$i] }}</span>
            </div>
        </th>

        {{-- categoria monto --}}
        <td>
            <div class="col-sm">
                <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}"
                        name="monto_{{ $i }}" id="monto_{{ $i }}" type="text"
                        style="font-family: FontAwesome" placeholder="&#xf0d6; monto"
                        @if (isset($monto[$i])) value="{{ $monto[$i] }}" @endif style="width: 50px"
                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                    <span id="result"></span>
                    <script>
                        $("#monto_{{ $i }}").change(function() {
                            if ($("#monto_{{ $i }}").val() > 0) {
                                frecuencia_{{ $i }}.setAttribute("required", "")
                            } else {
                                frecuencia_{{ $i }}.removeAttribute("required");
                                inicio_{{ $i }}.removeAttribute("required");
                                div_{{ $i }}.style.display = 'initial';
                                fin_{{ $i }}.removeAttribute("required");
                                div2_{{ $i }}.style.display = 'initial';
                            }
                        });
                    </script>
                </div>
            </div>

            <input type="hidden" name="id_categoria_{{ $i }}" id="id_categoria_{{ $i }}"
                value="{{ $id_categoria_array[$i] }}">
            <input type="hidden" name="id_{{ $i }}" id="id_{{ $i }}"
                @if (isset($id_ingreso_programado[$i])) value="{{ $id_ingreso_programado[$i] }}"
            @else
                value="" @endif>
        </td>
        {{-- categoria monto --}}

        {{-- categoria frecuencia --}}
        <td>
            <div class="col-sm">
                <div class="form-group">
                    <select class="form-control" id="frecuencia_{{ $i }}"
                        name="frecuencia_{{ $i }}">
                        <option value="">Frecuencia</option>
                        @foreach ($frecuencias as $frecuencia)
                            <option value="{{ $frecuencia->id }}"
                                @if (isset($id_frecuencia[$i])) @if ($id_frecuencia[$i] == $frecuencia->id) selected @endif
                                @endif
                                >
                                {{ $frecuencia->frecuencia }}
                            </option>
                        @endforeach
                    </select>
                    <script>
                        document.getElementById('frecuencia_' + '{!! $i !!}').addEventListener('change', function(
                            event) {

                            if ($("#monto_{{ $i }}").val() > 0) {
                                if ($("#frecuencia_{{ $i }}").val() == 1) {
                                    inicio_{{ $i }}.setAttribute("required", "");
                                    div_{{ $i }}.style.display = 'none';
                                    fin_{{ $i }}.removeAttribute("required");
                                    div2_{{ $i }}.style.display = 'none';
                                    sin_caducidad_{{ $i }}.removeAttribute("required");
                                }

                                if ($("#frecuencia_{{ $i }}").val() > 1) {
                                    inicio_{{ $i }}.setAttribute("required", "");
                                    div_{{ $i }}.style.display = 'initial';
                                    fin_{{ $i }}.setAttribute("required", "");
                                    div2_{{ $i }}.style.display = 'initial';
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
                <div class="form-check form-check-inline" id="div2_{{ $i }}">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="sin_caducidad_{{ $i }}"
                            @if (isset($caducidad[$i])) @if ($caducidad[$i] == 1) value="1" checked
                                                                @else
                                                                value="1" @endif
                            @endif
                        name="sin_caducidad_{{ $i }}">
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
            </div>
            <script type="text/javascript">
                $("#sin_caducidad_{{ $i }}").change(function() {

                    if ($("#monto_{{ $i }}").val() > 0) {
                        if (document.getElementById('sin_caducidad_' + '{!! $i !!}').checked === true) {
                            div_{{ $i }}.style.display = 'none';
                            fin_{{ $i }}.removeAttribute("required");
                        } else {
                            div_{{ $i }}.style.display = 'initial';
                            fin_{{ $i }}.setAttribute("required", "");
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
                    {{-- <input id="inicio_{{ $i }}" width="80" name="inicio_{{ $i }}"
                        @if (isset($fecha_inicio[$i])) value="{{ date('d/m/y', strtotime($fecha_inicio[$i])) }}" @endif />
                    <script>
                        var html = '#inicio_' + '{!! $i !!}';
                        $(html).datepicker({
                            showOtherMonths: true,
                            locale: 'es-es',
                            format: 'dd/mm/yy',
                        });
                    </script> --}}

                    <input type="text" id="inicio_{{ $i }}" width="120" class="form-control"
                        style="font-family: FontAwesome" placeholder="&#xf073;"
                        @if (isset($fecha_inicio[$i])) value="{{ date('d/m/Y', strtotime($fecha_inicio[$i])) }}" @endif>
                    <script>
                        var html = '#inicio_' + '{!! $i !!}';
                        $.datepicker.setDefaults($.datepicker.regional['es']);
                        $(html).datepicker({
                            changeMonth: true,
                            changeYear: true,
                            yearRange: "1950:2060"
                        });
                    </script>


                </div>
            </div>
        </td>
        {{-- categoria fecha inicio --}}

        {{-- categoria fecha fin --}}
        <td>
            <div class="col-sm" id="div_{{ $i }}" style="initial">
                <div class="form-group">
                    {{-- <input id="fin_{{ $i }}" width="80" name="fin_{{ $i }}"
                        @if (isset($fecha_fin[$i])) value="{{ date('d/m/y', strtotime($fecha_fin[$i])) }}" @endif />
                    <script>
                        var html = '#fin_' + '{!! $i !!}';
                        $(html).datepicker({
                            showOtherMonths: true,
                            locale: 'es-es',
                            format: 'dd/mm/yy',
                        });
                    </script> --}}

                    <input type="text" id="fin_{{ $i }}" width="120" class="form-control"
                        style="font-family: FontAwesome" placeholder="&#xf073;"
                        @if (isset($fecha_fin[$i])) value="{{ date('d/m/Y', strtotime($fecha_fin[$i])) }}" @endif>
                    <script>
                        var html = '#fin_' + '{!! $i !!}';
                        $.datepicker.setDefaults($.datepicker.regional['es']);
                        $(html).datepicker({
                            changeMonth: true,
                            changeYear: true,
                            yearRange: "1950:2060"
                        });
                    </script>


                </div>
            </div>
        </td>
        {{-- categoria fecha fin --}}

    </tr>
