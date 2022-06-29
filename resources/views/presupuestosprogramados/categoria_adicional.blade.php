@for ($i = 0; $i <= $cantidad_tr; $i++)
    <tr id="tr_adicional_{{ $i }}" hidden>

        {{-- valores iniciales --}}
        <script>
            $(function() {
                if ($("#monto_adicional_{{ $i }}").val() > 0) {

                    if ($("#frecuencia_adicional_{{ $i }}").val() == 1) {
                        div_adicional_{{ $i }}.style.display = 'none';
                        fin_adicional_{{ $i }}.removeAttribute("required");
                        div2_adicional_{{ $i }}.style.display = 'none';
                        sin_caducidad_adicional_{{ $i }}.removeAttribute("required");
                    }

                    if ($("#sin_caducidad_adicional_{{ $i }}").is(":checked") == true) {
                        div_adicional_{{ $i }}.style.display = 'none';
                        fin_adicional_{{ $i }}.removeAttribute("required");
                    }
                }
            });
        </script>
        {{-- valores iniciales --}}

        {{-- categoria desactivar --}}
        <td>
        </td>
        {{-- categoria desactivar --}}

        {{-- input nueva subcategoria --}}
        <th scope="row">
            <input class="form-control" name="subcategoria_adicional_{{ $i }}"
                id="subcategoria_adicional_{{ $i }}" type="text" placeholder="Subcategoria Nueva" />
        </th>
        {{-- input nueva subcategoria --}}

        {{-- categoria monto --}}
        <td>
            <div class="col-sm">
                <input class="form-control" name="monto_adicional_{{ $i }}"
                    id="monto_adicional_{{ $i }}" type="text" style="font-family: FontAwesome"
                    placeholder="&#xf0d6; monto" style="width: 50px"
                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
                <span id="result"></span>
                <script>
                    $("#monto_adicional_{{ $i }}").change(function() {
                        if ($("#monto_adicional_{{ $i }}").val() > 0) {
                            frecuencia_adicional_{{ $i }}.setAttribute("required", "")
                        } else {
                            frecuencia_adicional_{{ $i }}.removeAttribute("required");
                            inicio_adicional_{{ $i }}.removeAttribute("required");
                            div_adicional_{{ $i }}.style.display = 'initial';
                            fin_adicional_{{ $i }}.removeAttribute("required");
                            div2_adicional_{{ $i }}.style.display = 'initial';
                        }
                    });
                </script>
                <input type="hidden" name="id_categoria_adicional_{{ $i }}"
                    id="id_categoria_adicional_{{ $i }}" value="">
                <input type="hidden" name="id_adicional_{{ $i }}" id="id_adicional_{{ $i }}"
                    value="">
            </div>
        </td>
        {{-- categoria monto --}}

        {{-- categoria frecuencia --}}
        <td>
            <div class="col-sm">
                <div class="form-group">
                    <select class="form-control" id="frecuencia_adicional_{{ $i }}"
                        name="frecuencia_adicional_{{ $i }}">
                        <option value="">Frecuencia</option>
                        @foreach ($frecuencias as $frecuencia)
                            <option value="{{ $frecuencia->id }}">
                                {{ $frecuencia->frecuencia }}
                            </option>
                        @endforeach
                    </select>
                    <script>
                        document.getElementById('frecuencia_adicional_' + '{!! $i !!}').addEventListener('change', function(
                            event) {

                            if ($("#monto_adicional_{{ $i }}").val() > 0) {
                                if ($("#frecuencia_adicional_{{ $i }}").val() == 1) {
                                    inicio_adicional_{{ $i }}.setAttribute("required", "");
                                    div_adicional_{{ $i }}.style.display = 'none';
                                    fin_adicional_{{ $i }}.removeAttribute("required");
                                    div2_adicional_{{ $i }}.style.display = 'none';
                                    sin_caducidad_adicional_{{ $i }}.removeAttribute("required");
                                }

                                if ($("#frecuencia_adicional_{{ $i }}").val() > 1) {
                                    inicio_adicional_{{ $i }}.setAttribute("required", "");
                                    div_adicional_{{ $i }}.style.display = 'initial';
                                    fin_adicional_{{ $i }}.setAttribute("required", "");
                                    div2_adicional_{{ $i }}.style.display = 'initial';
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
                <div class="form-check form-check-inline" id="div2_adicional_{{ $i }}">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="sin_caducidad_adicional_{{ $i }}"
                            name="sin_caducidad_adicional_{{ $i }}">
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
            </div>
            <script type="text/javascript">
                $("#sin_caducidad_adicional_{{ $i }}").change(function() {

                    if ($("#monto_adicional_{{ $i }}").val() > 0) {
                        if (document.getElementById('sin_caducidad_adicional_' + '{!! $i !!}').checked ===
                            true) {
                            div_adicional_{{ $i }}.style.display = 'none';
                            fin_adicional_{{ $i }}.removeAttribute("required");
                        } else {
                            div_adicional_{{ $i }}.style.display = 'initial';
                            fin_adicional_{{ $i }}.setAttribute("required", "");
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
                    <input id="inicio_adicional_{{ $i }}" width="80"
                        name="inicio_adicional_{{ $i }}" />
                    <script>
                        var html = '#inicio_adicional_' + '{!! $i !!}';
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
            <div class="col-sm" id="div_adicional_{{ $i }}" style="initial">
                <div class="form-group">
                    <input id="fin_adicional_{{ $i }}" width="80"
                        name="fin_adicional_{{ $i }}" />
                    <script>
                        var html = '#fin_adicional_' + '{!! $i !!}';
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
