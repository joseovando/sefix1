@csrf

<div>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>

                {{-- Adicionar Subcategoria --}}
                <th width="1%">
                    <input type="button" name="addRowButton" id="addRowCategoria" value="+"
                        class="btn btn-success btn-fab">
                </th>
                {{-- Adicionar Subcategoria --}}

                {{-- Cambiar Categoria --}}
                <th>
                    <div class="form-group">
                        <select onChange="" class="custom-select mr-sm-2" id="select_categoria"
                            name="select_categoria" @if ($navegador_mobile == 0) style="width:200px" @endif>
                            @foreach ($vistaCategoriaPadres as $vistaCategoriaPadre)
                                @if ($vistaCategoriaPadre->plantilla == 1)
                                    <option value="{{ $vistaCategoriaPadre->id }}"
                                        @if ($id == $vistaCategoriaPadre->id) selected @endif>
                                        {{ $vistaCategoriaPadre->categoria }}
                                    </option>
                                @else
                                    @if ($vistaCategoriaPadre->id_user == auth()->id())
                                        <option value="{{ $vistaCategoriaPadre->id }}"
                                            @if ($id == $vistaCategoriaPadre->id) selected @endif>
                                            {{ $vistaCategoriaPadre->categoria }}
                                        </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>

                        <input type="hidden" name="id_categoria" value="{{ $id }}">
                        <input type="hidden" name="tipo" value="{{ $tipo }}">
                        <input type="hidden" name="menu" value="{{ $menu }}">
                        <input type="hidden" name="mes_actual" value="{{ $mes_actual }}">
                        <input type="hidden" name="ano_actual" value="{{ $ano_actual }}">
                        <input type="hidden" name="cantidad_tr" value="{{ $cantidad_tr }}">
                        <input type="hidden" name="tr_adicional" id="tr_adicional" value="0">

                    </div>
                </th>
                {{-- Cambiar Categoria --}}

                <th width="24%">Monto</th>
                <th width="15%">Frecuencia</th>
                <th width="15%">Sin Caducidad</th>
                <th width="15%">Desde Fecha</th>
                <th width="15%">Hasta Fecha</th>
            </tr>
        </thead>
        <tbody>
            @include('presupuestosprogramados.categoria_adicional')
            @include('presupuestosprogramados.categoria_inicial')
        </tbody>
        <tfoot>
            <th></th>
            <th bgcolor="#7adf7f" align="right">Total Programado</th>
            <th bgcolor="#7adf7f" align="right">
                <div id="total_programado">
                    <span>{{ $monto_total }}</span>
                </div>
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tfoot>
    </table>
</div>
<div class="row">
    <div class="card-footer ml-auto mr-auto">
        <button type="submit" id="guardarProgramado" class="btn btn-primary"><i class="fa fa-floppy-o"
                aria-hidden="true"></i>&nbsp;&nbsp;{{ __('Guardar Programación') }}</button>
    </div>
</div>
</form>
