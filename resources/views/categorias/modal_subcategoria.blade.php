<div class="modal fade" id="saveModal2" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="alert alert-success alert-block" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong class="success-msg"></strong>
                </div>
            </div>
            <form>
                @csrf
                <div class="modal-body margin">

                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">

                                <label for="exampleFormControlSelect1">Categoria</label><br>

                                <select class="form-control selectpicker show-tick" data-live-search="true"
                                    id="_categoria" name="categoria" required>
                                    <option value="">Seleccione Categoria</option>
                                    <optgroup label="Tipo Ingreso">
                                        @foreach ($vistaCategoriaIngresos as $vistaCategoriaIngreso)
                                            @if ($vistaCategoriaIngreso->plantilla == 1)
                                                <option value="{{ $vistaCategoriaIngreso->id }}">
                                                    {{ $vistaCategoriaIngreso->categoria }}
                                                </option>
                                            @else
                                                @if ($vistaCategoriaIngreso->id_user == auth()->id())
                                                    <option value="{{ $vistaCategoriaIngreso->id }}">
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
                                                    {{ $vistaCategoriaEgreso->categoria }}
                                                </option>
                                            @else
                                                @if ($vistaCategoriaEgreso->id_user == auth()->id())
                                                    <option value="{{ $vistaCategoriaEgreso->id }}">
                                                        {{ $vistaCategoriaEgreso->categoria }}
                                                    </option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm">
                            <label for="exampleFormControlSelect1">Subcategoria</label>
                                        <div class="col-sm-7">
                                            <div
                                                class="form-group{{ $errors->has('subcategoria') ? ' has-danger' : '' }}">
                                                <input
                                                    class="form-control{{ $errors->has('subcategoria') ? ' is-invalid' : '' }}"
                                                    name="subcategoria" id="subcategoria" type="text"
                                                    placeholder="{{ __('subcategoria') }}"
                                                    value="{{ old('subcategoria', auth()->user()->subcategoria) }}"
                                                    required />
                                                @if ($errors->has('subcategoria'))
                                                @endif
                                            </div>
                                        </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-submit" id="GuardarSubCategoria">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
