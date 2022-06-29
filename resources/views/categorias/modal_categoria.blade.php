<div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel"
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
                                <select class="form-control" id="tipo_categoria" name="tipo_categoria" required>
                                    <option value="">Seleccione Tipo de Categoria</option>
                                    @foreach ($categoriaTipos as $categoriaTipo)
                                        <option value="{{ $categoriaTipo->id }}">
                                            {{ $categoriaTipo->tipo_categoria }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="id_categoria" id="id_categoria" value="">
                        </div>

                        <div class="col-sm">
                            <div class="form-group{{ $errors->has('categoria') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('categoria') ? ' is-invalid' : '' }}"
                                    name="categoria" id="categoria" type="text" placeholder="{{ __('Categoria') }}"
                                    value="{{ old('categoria', auth()->user()->categoria) }}" required />
                                @if ($errors->has('categoria'))
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <select class="form-control selectpicker" id="logo_categoria" name="logo_categoria"
                                    required>
                                    <option value="">Seleccione Logo</option>
                                    @foreach ($categoriaLogos as $categoriaLogo)
                                        <option value="{{ $categoriaLogo->icono }} {{ $categoriaLogo->tamano }}"
                                            data-icon="{{ $categoriaLogo->icono }}">
                                            - {{ $categoriaLogo->label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <select class="form-control selectpicker" id="fondo_categoria" name="fondo_categoria"
                                    required>
                                    <option value="">Seleccione Fondo Categoria</option>
                                    <option value="bg-secondary" class="bg-secondary">Plomo</option>
                                    <option value="bg-primary" class="bg-primary">Azul</option>
                                    <option value="bg-danger" class="bg-danger">Rojo</option>
                                    <option value="bg-warning" class="bg-warning">Amarillo</option>
                                    <option value="bg-info" class="bg-info">Celeste</option>
                                    <option value="bg-dark" class="bg-dark" style="color: #fff">Negro
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-submit" id="GuardarCategoria">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
