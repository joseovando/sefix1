<div class="modal fade" id="ModalIngresosInversiones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Ingreso Inversión</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="alert alert-success alert-block" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong class="success-msg"></strong>
                </div>
            </div>
            <form autocomplete="off" id="form_guardar_ingresos_inversiones">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Cuenta</label>
                            <div class="col">
                                <input type="text" class="form-control" id="cuenta_inversion" name="cuenta_inversion"
                                    placeholder="Cuenta" value="" required>
                                <input type="hidden" name="tipo_inversion" id="tipo_inversion" value="1">
                                <input type="hidden" name="id_brujula_inversion" id="id_brujula_inversion"
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
                                    class="form-control" id="ano_inicio_inversion" name="ano_inicio_inversion" placeholder="Año Inicio"
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
                                    class="form-control" id="ano_culminacion_inversion" name="ano_culminacion_inversion"
                                    placeholder="Año Culminación" value="">
                            </div>
                        </div>
                    </div>

                    <p></p>

                    <div class="form-row">
                        <div class="col-sm">
                            <label for="label">Tipo de Capital</label>
                            <select class="form-control" id="tipo_capital" name="tipo_capital" required>
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
                                    class="form-control" id="capital" name="capital" placeholder="Capital"
                                    value="" required>
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
                                    class="form-control" id="interes_anual" name="interes_anual"
                                    placeholder="Porcentaje de Interés Anual" value="">
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="label">Tiene devolución de Capital</label>
                            <select class="form-control" id="devolucion_capital" name="devolucion_capital" required>
                                <option value="">Seleccione una opción</option>
                                <option value="I">Si Aplica
                                </option>
                                <option value="O">No Aplica
                                </option>
                            </select>
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
                                    class="form-control" id="coeficiente_crecimiento_inversion" name="coeficiente_crecimiento_inversion"
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
