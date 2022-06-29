<div class="modal fade" id="ModalEgresosCorrientes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Egreso Corriente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="alert alert-success alert-block" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong class="success-msg"></strong>
                </div>
            </div>
            <form autocomplete="off" id="form_guardar_egresos_corrientes">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Categoría</label>
                            <select class="form-control selectpicker show-tick" data-live-search="true" id="categoria_egreso"
                                name="categoria_egreso" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($vistaCategoriaEgresoPadres as $vistaCategoriaEgreso)
                                    @if ($vistaCategoriaEgreso->plantilla == 1)
                                        <option value="{{ $vistaCategoriaEgreso->id }}">
                                            {{ $vistaCategoriaEgreso->categoria }}</option>
                                    @endif
                                    @if ($vistaCategoriaEgreso->id_user == auth()->id())
                                        <option value="{{ $vistaCategoriaEgreso->id }}">
                                            {{ $vistaCategoriaEgreso->categoria }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input type="hidden" name="tipo_corriente_egreso" id="tipo_corriente_egreso" value="2">
                            <input type="hidden" name="id_brujula_corriente_egreso" id="id_brujula_corriente_egreso" value="">
                        </div>
                        <div class="col-sm">
                            <label for="label">Cuenta</label>
                            <div class="col">
                                <input type="text" class="form-control" id="cuenta_egreso" name="cuenta_egreso" placeholder="Cuenta"
                                    value="" required>
                            </div>
                        </div>
                    </div>

                    <p></p>

                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Año Inicio</label>
                            <div class="col">
                                <input
                                    @if ($navegador_mobile == 1) type="number" 
                                @else
                                type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                    class="form-control" id="ano_inicio_egreso" name="ano_inicio_egreso" placeholder="Año Inicio"
                                    value="" required>
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="label">Año Culminación</label>
                            <div class="col">
                                <input
                                    @if ($navegador_mobile == 1) type="number" 
                                @else
                                type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                    class="form-control" id="ano_culminacion_egreso" name="ano_culminacion_egreso"
                                    placeholder="Año Culminación" value="" required>
                            </div>
                        </div>
                    </div>

                    <p></p>

                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Tipo de Monto</label>
                            <select class="form-control" id="tipo_monto_egreso" name="tipo_monto_egreso" required>
                                <option value="">Seleccione una opción</option>
                                <option value="I">Valor Futuro
                                </option>
                                <option value="O">Valor Actual
                                </option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label for="label">Monto</label>
                            <div class="col">
                                <input
                                    @if ($navegador_mobile == 1) type="number" 
                                @else
                                type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                    class="form-control" id="monto_egreso" name="monto_egreso" placeholder="Monto" value=""
                                    required>
                            </div>
                        </div>
                    </div>

                    <p></p>

                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Porcentaje de Coeficiente de Crecimiento</label>
                            <div class="col">
                                <input
                                    @if ($navegador_mobile == 1) type="number" 
                                @else
                                type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                    class="form-control" id="coeficiente_crecimiento_egreso" name="coeficiente_crecimiento_egreso"
                                    placeholder="Porcentaje de Coeficiente de Crecimiento" value="">
                            </div>
                        </div>
                        <div class="col-sm">
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
