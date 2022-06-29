<div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Datos Básicos</h4>
            <p class="card-category"></p>
        </div>
        <form autocomplete="off" id="form_guardar_datos_basicos">
            @csrf
            <div class="card-body">
                <div class="form-row">
                    <div class="col-sm">
                        <label for="label">Fecha de Nacimiento</label>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Fecha de Nacimiento"
                                @if (isset($vistaUsersSpecific->fecha_nacimiento)) value="{{ date('d/m/Y', strtotime($vistaUsersSpecific->fecha_nacimiento)) }}"
                            @else
                                value="" @endif
                                readonly>
                            <input type="hidden" name="ano_nacimiento" id="ano_nacimiento"
                                @if (isset($vistaUsersSpecific->fecha_nacimiento)) value="{{ substr($vistaUsersSpecific->fecha_nacimiento, 0, 4) }}"
                            @else
                                value="" @endif>

                            <input type="hidden" name="id_datos_basicos" id="id_datos_basicos">
                        </div>
                    </div>
                    <div class="col-sm">
                        <label for="label">Expectativa de vida (años)</label>
                        <div class="col">
                            <input
                                @if ($navegador_mobile == 1) type="number" 
                            @else
                            type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                class="form-control" placeholder="Expectativa (años)" name="expectativa_vida"
                                id="expectativa_vida"
                                @if (isset($brujulaDatosBasicos->expectativa_vida)) value="{{ $brujulaDatosBasicos->expectativa_vida }}"
                                @else
                                    value="" @endif
                                required>
                        </div>
                    </div>
                </div>

                <p></p>

                {{-- Renta Jubilacion --}}
                <div class="form-row">
                    <div class="col-sm">
                        <label for="label">¿Renta de Jubilación?</label>
                        <select class="form-control" id="select_jubilacion" name="select_jubilacion"
                            onchange="rentaJubilacion(this);" required>
                            <option value="">Seleccione una opción</option>
                            <option value="O"
                                @if (isset($brujulaDatosBasicos->renta_jubilacion)) @if ($brujulaDatosBasicos->renta_jubilacion == 0) selected @endif
                                @endif
                                > Sin renta de Jubilación
                            </option>
                            <option value="I"
                                @if (isset($brujulaDatosBasicos->renta_jubilacion)) @if ($brujulaDatosBasicos->renta_jubilacion == 1) selected @endif
                                @endif
                                > Con renta de Jubilación
                            </option>
                        </select>
                    </div>
                    <div class="col-sm" id="div_ano_renta"
                        @if (isset($brujulaDatosBasicos->renta_jubilacion)) @if ($brujulaDatosBasicos->renta_jubilacion == 0)
                    hidden @endif
                    @else hidden @endif
                        >
                        <label for="label">Año de Jubilación</label>
                        <div class="col">
                            <input
                                @if ($navegador_mobile == 1) type="number" 
                            @else
                            type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                class="form-control" placeholder="Año de Jubilación" name="ano_jubilacion"
                                id="ano_jubilacion"
                                @if (isset($brujulaDatosBasicos->ano_renta_jubilacion)) value="{{ $brujulaDatosBasicos->ano_renta_jubilacion }}"  
                                    @else
                                       value="" @endif>
                        </div>
                    </div>
                    <div class="col-sm" id="div_porcentaje_renta"
                        @if (isset($brujulaDatosBasicos->renta_jubilacion)) @if ($brujulaDatosBasicos->renta_jubilacion == 0)
                    hidden @endif
                    @else hidden @endif
                        >
                        <label for="label">Porcentaje de Renta</label>
                        <div class="col">
                            <input
                                @if ($navegador_mobile == 1) type="number" 
                            @else
                            type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                class="form-control" placeholder="% Renta" name="porcentaje_renta" id="porcentaje_renta"
                                @if (isset($brujulaDatosBasicos->porcentaje_renta_jubilacion)) value="{{ $brujulaDatosBasicos->porcentaje_renta_jubilacion }}"
                                @else
                                    value="" @endif>
                        </div>
                    </div>
                </div>
                {{-- Renta Jubilacion --}}

                <p></p>

                {{-- Conyuge --}}
                <div class="form-row">
                    <div class="col-sm">
                        <label for="label">¿Tiene Conyuge?</label>
                        <select class="form-control" id="select_conyuge" name="select_conyuge"
                            onchange="selectConyuge(this);" required>
                            <option value="">Seleccione una opción</option>
                            <option value="I"
                                @if (isset($brujulaDatosBasicos->tiene_conyuge)) @if ($brujulaDatosBasicos->tiene_conyuge == 1) selected @endif
                                @endif
                                >Si tengo Conyuge
                            </option>
                            <option value="O"
                                @if (isset($brujulaDatosBasicos->tiene_conyuge)) @if ($brujulaDatosBasicos->tiene_conyuge == 0) selected @endif
                                @endif
                                >No tengo Conyuge
                            </option>
                        </select>
                    </div>
                    <div class="col-sm" id="div_fecha_nacimiento_conyuge"
                        @if (isset($brujulaDatosBasicos->tiene_conyuge)) @if ($brujulaDatosBasicos->tiene_conyuge == 0)
                    hidden @endif
                    @else hidden @endif
                        >
                        <label for="label">Fecha de Nacimiento Conyuge</label>
                        <div class="col">
                            {{-- <input id="fecha_nacimiento_conyuge" name="fecha_nacimiento_conyuge"
                                @if (isset($brujulaDatosBasicos->fecha_nacimiento_conyuge)) value="{{ date('d/m/y', strtotime($brujulaDatosBasicos->fecha_nacimiento_conyuge)) }}"
                            @else
                                value="" @endif />
                            <script>
                                $('#fecha_nacimiento_conyuge').datepicker({
                                    showOtherMonths: true,
                                    locale: 'es-es',
                                    format: 'dd/mm/yy',
                                });
                            </script> --}}
                            <input type="text" id="fecha_nacimiento_conyuge" name="fecha_nacimiento_conyuge"
                                class="form-control" style="font-family: FontAwesome" placeholder="&#xf073;"
                                @if (isset($brujulaDatosBasicos->fecha_nacimiento_conyuge)) value="{{ date('d/m/Y', strtotime($brujulaDatosBasicos->fecha_nacimiento_conyuge)) }}"
                            @else
                                value="" @endif>
                            <script>
                                $.datepicker.setDefaults($.datepicker.regional['es']);
                                $("#fecha_nacimiento_conyuge").datepicker({
                                    changeMonth: true,
                                    changeYear: true,
                                    yearRange: "1950:2060"
                                });
                            </script>


                        </div>
                    </div>
                </div>

                <p></p>

                {{-- Renta Jubilacion Conyuge --}}
                <div class="form-row" id="row_conjuge"
                    @if (isset($brujulaDatosBasicos->tiene_conyuge)) @if ($brujulaDatosBasicos->tiene_conyuge == 0)
                    hidden @endif
                @else hidden @endif
                    >
                    <div class="col-sm" id="div_select_jubilacion_conyuge">
                        <label for="label">¿Renta de Jubilación Conyuge?</label>
                        <select class="form-control" id="select_jubilacion_conyuge" name="select_jubilacion_conyuge"
                            onchange="selectJubilacionConyuge(this);">
                            <option value="">Seleccione una opción</option>
                            <option value="O"
                                @if (isset($brujulaDatosBasicos->renta_jubilacion_conyuge)) @if ($brujulaDatosBasicos->renta_jubilacion_conyuge == 0) selected @endif
                                @endif
                                >Sin renta de
                                Jubilación
                            </option>
                            <option value="I"
                                @if (isset($brujulaDatosBasicos->renta_jubilacion_conyuge)) @if ($brujulaDatosBasicos->renta_jubilacion_conyuge == 1) selected @endif
                                @endif
                                > Con renta de
                                Jubilación
                            </option>
                        </select>
                    </div>
                    <div class="col-sm" id="div_ano_jubilacion_conyuge"
                        @if (isset($brujulaDatosBasicos->renta_jubilacion_conyuge)) @if ($brujulaDatosBasicos->renta_jubilacion_conyuge == 0)
                    hidden @endif
                    @else hidden @endif>
                        <label for="label">Año de Jubilación Conyuge</label>
                        <div class="col">
                            <input
                                @if ($navegador_mobile == 1) type="number" 
                            @else
                            type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                class="form-control" placeholder="Año de Jubilación" name="ano_jubilacion_conyuge"
                                id="ano_jubilacion_conyuge"
                                @if (isset($brujulaDatosBasicos->ano_renta_jubilacion_conyuge)) value="{{ $brujulaDatosBasicos->ano_renta_jubilacion_conyuge }}"
                                @else
                                  value="" @endif>
                        </div>
                    </div>
                    <div class="col-sm" id="div_porcentaje_renta_conyuge"
                        @if (isset($brujulaDatosBasicos->renta_jubilacion_conyuge)) @if ($brujulaDatosBasicos->renta_jubilacion_conyuge == 0)
                    hidden @endif
                    @else hidden @endif>
                        <label for="label">Porcentaje de Renta Conyuge</label>
                        <div class="col">
                            <input
                                @if ($navegador_mobile == 1) type="number" 
                            @else
                            type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                class="form-control" placeholder="% Renta" name="porcentaje_renta_conyuge"
                                id="porcentaje_renta_conyuge"
                                @if (isset($brujulaDatosBasicos->porcentaje_renta_jubilacion_conyuge)) value="{{ $brujulaDatosBasicos->porcentaje_renta_jubilacion_conyuge }}" 
                                @else
                                   value="" @endif>
                        </div>
                    </div>
                </div>
                {{-- Renta Jubilacion Conyuge --}}

                {{-- Conyuge --}}
            </div>
            <div class="card-footer">
                <div class="col-sm-10"></div>
                <div class="col">
                    <button type="submit" class="btn btn-primary btn-submit" id="guardarCuenta">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
