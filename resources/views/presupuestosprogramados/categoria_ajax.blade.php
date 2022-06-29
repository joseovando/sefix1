@for ($i = 0; $i <= $cantidad_tr; $i++)
    <tr id="tr_ajax_{{ $i }}" hidden>

        {{-- valores iniciales --}}
        <script>
            $(function() {
                if ($("#monto_ajax_{{ $i }}").val() > 0) {

                    if ($("#frecuencia_ajax_{{ $i }}").val() == 1) {
                        div_ajax_{{ $i }}.style.display = 'none';
                        fin_ajax_{{ $i }}.removeAttribute("required");
                        div2_ajax_{{ $i }}.style.display = 'none';
                        sin_caducidad_ajax_{{ $i }}.removeAttribute("required");
                    }

                    if ($("#sin_caducidad_ajax_{{ $i }}").is(":checked") == true) {
                        div_ajax_{{ $i }}.style.display = 'none';
                        fin_ajax_{{ $i }}.removeAttribute("required");
                    }
                }
            });
        </script>
        {{-- valores iniciales --}}

        {{-- categoria desactivar --}}
        <td><input type="hidden" name="id_ajax_{{ $i }}" id="id_ajax_{{ $i }}" value="">
            <input type="hidden" name="id_categoria_ajax_{{ $i }}"
                id="id_categoria_ajax_{{ $i }}" value="">
        </td>
        {{-- categoria desactivar --}}

        {{-- input nueva subcategoria --}}
        <th scope="row" id="categoria_ajax_{{ $i }}">
        </th>
        {{-- input nueva subcategoria --}}

        {{-- categoria monto --}}
        <td>
            <div class="col-sm">
                <input class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}"
                    name="monto_ajax_{{ $i }}" id="monto_ajax_{{ $i }}" type="text" value=""
                    style="font-family: FontAwesome" placeholder="&#xf0d6; monto" style="width: 50px"
                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                <span id="result"></span>
                <script>
                    $("#monto_ajax_{{ $i }}").change(function() {
                        if ($("#monto_ajax_{{ $i }}").val() > 0) {
                            frecuencia_ajax_{{ $i }}.setAttribute("required", "")
                        } else {
                            frecuencia_ajax_{{ $i }}.removeAttribute("required");
                            inicio_ajax_{{ $i }}.removeAttribute("required");
                            div_ajax_{{ $i }}.style.display = 'initial';
                            fin_ajax_{{ $i }}.removeAttribute("required");
                            div2_ajax_{{ $i }}.style.display = 'initial';
                        }
                    });
                </script>
            </div>
        </td>
        {{-- categoria monto --}}

        {{-- categoria frecuencia --}}
        <td>
            <div class="col-sm">
                <div class="form-group">
                    <select class="form-control" id="frecuencia_ajax_{{ $i }}"
                        name="frecuencia_ajax_{{ $i }}">
                        <option value="">Frecuencia</option>
                        @foreach ($frecuencias as $frecuencia)
                            <option value="{{ $frecuencia->id }}">
                                {{ $frecuencia->frecuencia }}
                            </option>
                        @endforeach
                    </select>
                    <script>
                        document.getElementById('frecuencia_ajax_' + '{!! $i !!}').addEventListener('change', function(
                            event) {

                            if ($("#monto_ajax_{{ $i }}").val() > 0) {
                                if ($("#frecuencia_ajax_{{ $i }}").val() == 1) {
                                    inicio_ajax_{{ $i }}.setAttribute("required", "");
                                    div_ajax_{{ $i }}.style.display = 'none';
                                    fin_ajax_{{ $i }}.removeAttribute("required");
                                    div2_ajax_{{ $i }}.style.display = 'none';
                                    sin_caducidad_ajax_{{ $i }}.removeAttribute("required");
                                }

                                if ($("#frecuencia_ajax_{{ $i }}").val() > 1) {
                                    inicio_ajax_{{ $i }}.setAttribute("required", "");
                                    div_ajax_{{ $i }}.style.display = 'initial';
                                    fin_ajax_{{ $i }}.setAttribute("required", "");
                                    div2_ajax_{{ $i }}.style.display = 'initial';
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
                <div class="form-check form-check-inline" id="div2_ajax_{{ $i }}">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="sin_caducidad_ajax_{{ $i }}"
                            name="sin_caducidad_ajax_{{ $i }}">
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
            </div>
            <script type="text/javascript">
                $("#sin_caducidad_ajax_{{ $i }}").change(function() {

                    if ($("#monto_ajax_{{ $i }}").val() > 0) {
                        if (document.getElementById('sin_caducidad_ajax_' + '{!! $i !!}').checked === true) {
                            div_ajax_{{ $i }}.style.display = 'none';
                            fin_ajax_{{ $i }}.removeAttribute("required");
                        } else {
                            div_ajax_{{ $i }}.style.display = 'initial';
                            fin_ajax_{{ $i }}.setAttribute("required", "");
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
                    <input id="inicio_ajax_{{ $i }}" width="80" name="inicio_ajax_{{ $i }}" />
                    <script>
                        var html = '#inicio_ajax_' + '{!! $i !!}';
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
            <div class="col-sm" id="div_ajax_{{ $i }}" style="initial">
                <div class="form-group">
                    <input id="fin_ajax_{{ $i }}" width="80" name="fin_ajax_{{ $i }}" />
                    <script>
                        var html = '#fin_ajax_' + '{!! $i !!}';
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
@endfor
