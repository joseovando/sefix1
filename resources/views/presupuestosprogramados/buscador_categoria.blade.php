<form autocomplete="off" class="form-horizontal">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <div class="autoComplete_wrapper">
                <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off"
                    autocapitalize="off" name="search">
            </div>
            <script src="{{ asset('js/autoComplete.min.js') }}"></script>
            <script>
                var data = @json($json);
                const autoCompleteJS = new autoComplete({
                    selector: "#autoComplete",
                    placeHolder: "Busque Categoria...",
                    data: {
                        src: data,
                        cache: true,
                    },
                    resultsList: {
                        element: (list, data) => {
                            if (!data.results.length) {
                                // Create "No Results" message element
                                const message = document.createElement("div");
                                // Add class to the created element
                                message.setAttribute("class", "no_result");
                                // Add message text content
                                message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
                                // Append message element to the results list
                                list.prepend(message);
                            }
                        },
                        noResults: true,
                    },
                    diacritics: true,
                    resultItem: {
                        highlight: true
                    },

                    events: {
                        input: {
                            selection: (event) => {
                                const selection = event.detail.selection.value;
                                autoCompleteJS.input.value = selection;
                            }
                        }
                    }
                });
            </script>
        </div>
        <div class="col-md-2">
            <button type="success" class="btn btn-primary" id="buscarCategoria">Buscar</button>
            <button class="btn btn-social btn-just-icon  btn-facebook" id="reloadCategoria" hidden>
                <i class="fa fa-refresh" aria-hidden="true"></i>
            </button>
        </div>
        <div class="col-md-3" id="boton_activar_categorias">
            <a href="" class="btn btn-primary" role="button" aria-disabled="true" data-toggle="modal"
                data-target="#configModal">
                <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;Activar Categorias</a>
            @include('presupuestosprogramados.activar_categoria')
        </div>
    </div>
</form>
