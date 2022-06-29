<div class="modal fade" id="ModalPrestamos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Préstamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="alert alert-success alert-block" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong class="success-msg"></strong>
                </div>
            </div>
            <form autocomplete="off" id="form_guardar_prestamos">
                @csrf
                <div class="modal-body">
                    <div clainversionrow">
                        <div class="col-sm">
                            <label for="label">Cuenta</label>
                            <div class="col">
                                <input type="text" class="form-control" id="cuenta_prestamo" name="cuenta_prestamo"
                                    placeholder="Cuenta" value="" required>
                                <input type="hidden" name="tipo_prestamo" id="tipo_prestamo" value="2">
                                <input type="hidden" name="id_brujula_prestamo" id="id_brujula_prestamo"
                                    value="">
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
                                    class="form-control" id="ano_inicio_prestamo" name="ano_inicio_prestamo"
                                    placeholder="Año Inicio" value="" required>
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="label">Año Culminación</label>
                            <div class="col">
                                <input
                                    @if ($navegador_mobile == 1) type="number" 
                                @else
                                type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                    class="form-control" id="ano_culminacion_prestamo" name="ano_culminacion_prestamo"
                                    placeholder="Año Culminación" value="">
                            </div>
                        </div>
                    </div>

                    <p></p>

                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Tipo de Capital</label>
                            <select class="form-control" id="tipo_capital_prestamo" name="tipo_capital_prestamo"
                                required>
                                <option value="">Seleccione una opción</option>
                                <option value="I">Valor Futuro
                                </option>
                                <option value="O">Valor Actual
                                </option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label for="label">Capital</label>
                            <div class="col">
                                <input
                                    @if ($navegador_mobile == 1) type="number" 
                                @else
                                type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                    class="form-control" id="capital_prestamo" name="capital_prestamo"
                                    placeholder="Capital" value="" required>
                            </div>
                        </div>
                    </div>

                    <p></p>

                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Porcentaje de Interés Anual</label>
                            <div class="col">
                                <input
                                    @if ($navegador_mobile == 1) type="number" 
                                @else
                                type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" @endif
                                    class="form-control" id="interes_anual_prestamo" name="interes_anual_prestamo"
                                    placeholder="Porcentaje de Interés Anual" value="">
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
