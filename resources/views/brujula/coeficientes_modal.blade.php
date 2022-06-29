<div class="modal fade" id="ModalCoeficientes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Coeficiente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="alert alert-success alert-block" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong class="success-msg"></strong>
                </div>
            </div>
            <form autocomplete="off" id="form_guardar_coeficientes">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Coeficiente</label>
                            <select class="form-control selectpicker show-tick" data-live-search="true" id="coeficiente"
                                name="coeficiente" required>
                                <option value="">Seleccione Coeficiente</option>
                                <optgroup label="Tipo Ingreso">
                                    @foreach ($vistaCategoriaIngresos as $vistaCategoriaIngreso)
                                        @if ($vistaCategoriaIngreso->plantilla == 1)
                                            <option value="{{ $vistaCategoriaIngreso->id }}">
                                                {{ $vistaCategoriaIngreso->categoria_padre }} /
                                                {{ $vistaCategoriaIngreso->categoria }}
                                            </option>
                                        @else
                                            @if ($vistaCategoriaIngreso->id_user == auth()->id())
                                                <option value="{{ $vistaCategoriaIngreso->id }}">
                                                    {{ $vistaCategoriaIngreso->categoria_padre }} /
                                                    {{ $vistaCategoriaIngreso->categoria }}
                                                </option>
                                            @endif
                                        @endif
                                    @endforeach
                                </optgroup>
                                <optgroup label="Tipo Egreso">
                                    @foreach ($vistaCategoriaEgresos as $vistaCategoriaEgreso)
                                        @if ($vistaCategoriaEgreso->plantilla == 1)
                                            <option value="{{ $vistaCategoriaEgreso->id }}">
                                                {{ $vistaCategoriaEgreso->categoria_padre }} /
                                                {{ $vistaCategoriaEgreso->categoria }}
                                            </option>
                                        @else
                                            @if ($vistaCategoriaEgreso->id_user == auth()->id())
                                                <option value="{{ $vistaCategoriaEgreso->id }}">
                                                    {{ $vistaCategoriaEgreso->categoria_padre }} /
                                                    {{ $vistaCategoriaEgreso->categoria }}
                                                </option>
                                            @endif
                                        @endif
                                    @endforeach
                                </optgroup>
                            </select>
                            <input type="hidden" name="id_brujula_coeficiente" id="id_brujula_coeficiente" value="">
                        </div>
                    </div>

                    <p></p>

                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Valor de cálculo</label>
                            <select class="form-control" id="valor_calculo" name="valor_calculo" required>
                                <option value="">Seleccione una opción</option>
                                <option value="O">Determinado por el Sistema</option>
                                <option value="I">Personalizado</option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label for="label">Valor Personalizado</label>
                            <div class="col">
                                <input
                                    @if ($navegador_mobile == 1) type="number" 
                                @else
                                type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                    class="form-control" id="valor_personalizado" name="valor_personalizado"
                                    placeholder="Valor Personalizado" value="">
                            </div>
                        </div>
                    </div>

                    <p></p>

                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Información Adicional</label>
                            <div class="col">
                                <input type="text" class="form-control" id="informacion_adicional"
                                    name="informacion_adicional" placeholder="Información Adicional" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-submit" id="guardarCuenta">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
