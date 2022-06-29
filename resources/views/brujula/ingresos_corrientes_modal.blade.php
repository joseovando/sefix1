<div class="modal fade" id="ModalIngresosCorrientes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Ingreso Corriente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="alert alert-success alert-block" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong class="success-msg"></strong>
                </div>
            </div>
            <form autocomplete="off" id="form_guardar_ingresos_corrientes">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Categoría</label>
                            <select class="form-control selectpicker show-tick" data-live-search="true" id="categoria"
                                name="categoria" required>
                                <option value="">Seleccione una opción</option>
                                @foreach ($vistaCategoriaIngresoPadres as $vistaCategoriaIngreso)
                                    @if ($vistaCategoriaIngreso->plantilla == 1)
                                        <option value="{{ $vistaCategoriaIngreso->id }}">
                                            {{ $vistaCategoriaIngreso->categoria }}</option>
                                    @endif
                                    @if ($vistaCategoriaIngreso->id_user == auth()->id())
                                        <option value="{{ $vistaCategoriaIngreso->id }}">
                                            {{ $vistaCategoriaIngreso->categoria }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input type="hidden" name="tipo_corriente" id="tipo_corriente" value="1">
                            <input type="hidden" name="id_brujula_corriente" id="id_brujula_corriente" value="">
                        </div>
                        <div class="col-sm">
                            <label for="label">Cuenta</label>
                            <div class="col">
                                <input type="text" class="form-control" id="cuenta" name="cuenta" placeholder="Cuenta"
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
                                    class="form-control" id="ano_inicio" name="ano_inicio" placeholder="Año Inicio"
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
                                    class="form-control" id="ano_culminacion" name="ano_culminacion"
                                    placeholder="Año Culminación" value="" required>
                            </div>
                        </div>
                    </div>

                    <p></p>

                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Tipo de Monto</label>
                            <select class="form-control" id="tipo_monto" name="tipo_monto" required>
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
                                    class="form-control" id="monto" name="monto" placeholder="Monto" value=""
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
                                    class="form-control" id="coeficiente_crecimiento" name="coeficiente_crecimiento"
                                    placeholder="Porcentaje de Coeficiente de Crecimiento" value="" required>
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
