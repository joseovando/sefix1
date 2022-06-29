<form>
    <div class="row">
        <div class="col-sm">
            <div class="form-group">
                <select class="form-control" id="ano_actual" name="ano_actual">
                    @for ($i = $ano_actual_inicio; $i <= $ano_actual_fin; $i++)
                        <option value="{{ $i }}" @if ($i == $ano_actual) selected @endif>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
                <input type="hidden" name="llave_form" value="1">
            </div>
        </div>

        <div class="col-sm">
            <div class="form-group">
                <select class="form-control" id="mes_actual" name="mes_actual">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" @if ($i == $mes_actual) selected @endif>
                            {{ $meses[$i] }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="col-sm">
            <button type="submit" class="btn btn-primary"
                id="cambiar_mes_programado">{{ __('Cambiar Mes Programado') }}</button>
        </div>
</form>
<form autocomplete="off" class="form-horizontal" id="form_guardar_programado">
    <div class="col-sm"></div>
    <div class="col-sm"></div>
    <div class="col-sm"></div>
    <div class="col-sm"><button type="submit" id="guardarProgramado" class="btn btn-primary"><i class="fa fa-floppy-o"
                aria-hidden="true"></i>&nbsp;&nbsp;{{ __('Guardar Programación') }}</button></div>
    </div>
