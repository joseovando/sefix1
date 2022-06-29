<form autocomplete="off" class="form-horizontal">
    @csrf
    <div class="row">

        <div class="col-sm">

            <div class="form-group">
                <input id="date" width="276" name="date"
                    value="{{ date('d/m/y', strtotime($date)) }}" />
                <script>
                    $('#date').datepicker({
                        showOtherMonths: true,
                        locale: 'es-es',
                        format: 'dd/mm/yy',
                        weekStartDay: 1
                    });
                </script>
            </div>
        </div>
        <div class="col-sm">
            <button type="submit" class="btn btn-primary"
                id="cambiarFecha">{{ __('Cambiar Rango de Fechas') }}</button>
            <button class="btn btn-social btn-just-icon btn-twitter" id="cargarGrafica">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>
            </button>
        </div>
        <div class="col-sm">
            <input type="hidden" name="id_categoria" value="{{ $id_categoria }}">
            <input type="hidden" name="date_original" value="{{ $date }}">
            <input type="hidden" name="llave_form" value="1">
        </div>
    </div>
</form>

<br>
