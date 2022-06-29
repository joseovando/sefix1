<div class="modal fade" id="configModal" tabindex="-1" role="dialog" aria-labelledby="configModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Categorias Favoritas</h5>
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
                <div class="modal-body">
                    <section>
                        <ul class="list-group list-group-sortable" id="ul_activar_categoria">
                            @foreach ($vistaCategorias as $vistaCategoria)
                                {{-- categorias plantilla --}}
                                @if ($vistaCategoria->plantilla == 1)
                                    <li class="list-group-item">
                                        <input type="checkbox" class="form-check-input"
                                            name="check_{{ $vistaCategoria->id }}"
                                            id="check_{{ $vistaCategoria->id }}"
                                            @if (isset($categoria_desactivada[$vistaCategoria->id])) @else checked @endif>
                                        {{ $vistaCategoria->categoria }}
                                    </li>
                                @else
                                    {{-- categorias plantilla --}}

                                    {{-- categorias usuario --}}
                                    @if ($vistaCategoria->id_user == auth()->id())
                                        <li class="list-group-item">
                                            <input type="checkbox" class="form-check-input"
                                                name="check_{{ $vistaCategoria->id }}"
                                                id="check_{{ $vistaCategoria->id }}"
                                                @if (isset($categoria_desactivada[$vistaCategoria->id])) @else checked @endif>
                                            {{ $vistaCategoria->categoria }}
                                        </li>
                                    @endif
                                    {{-- categorias usuario --}}
                                @endif
                            @endforeach
                        </ul>
                    </section>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-submit" id="activarCategoria">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
