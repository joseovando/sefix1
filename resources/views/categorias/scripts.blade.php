<script type="text/javascript" class="init">
    $(document).ready(function() {
        $('#example').DataTable({
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }]
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#GuardarCategoria').click(function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            var categoria = $("#categoria").val();
            var id_categoria = $("#id_categoria").val();
            var logo_categoria = $("#logo_categoria").val();
            var fondo_categoria = $("#fondo_categoria").val();
            var tipo_categoria = $("#tipo_categoria").val();
            var comercial = @json($comercial);

            console.log(categoria);
            console.log(logo_categoria);
            console.log(fondo_categoria);
            console.log(tipo_categoria);

            $.ajax({
                url: "{{ route('categorias.store_ajax_categoria') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    categoria: categoria,
                    id_categoria: id_categoria,
                    logo_categoria: logo_categoria,
                    fondo_categoria: fondo_categoria,
                    tipo_categoria: tipo_categoria,
                    comercial: comercial,
                },
                success: function(data) {

                    document.getElementById("id_categoria").value = data.categoria.id;
                    cargarTabla(data);

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro Guardado Correctamente, Información Actualizada',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            });

        });
    });

    function cargarTabla(data) {

        var table = '';
        var vistaCategoria = data.vistaCategorias;
        var llave_padre = data.llave_padre;
        var categoria = data.categoria;
        var vistaUserRol = data.vistaUserRol;
        var id_user = @json(auth()->id());

        if (llave_padre == 1) {
            table += '<tr>';

            if (categoria.tipo == 1) {
                table += '<td>Ingreso</td>';
            } else {
                table += '<td>Egreso</td>';
            }

            table += '<td>' + categoria.categoria + '</td>';
            table += '<td width="1%">';
            table += '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"';
            table += 'data-target="#saveModal"';
            table += 'onclick="editarCategoria(' + categoria.id + ')">';
            table += '<i class="material-icons">edit</i>';
            table += '</button>';
            table += '</td>';
            table += '<td width="1%">';
            table += '<button class="btn btn-danger btn-fab btn-fab-mini"';
            table += 'onclick="borrarCategoria(' + categoria.id + ')">';
            table += '<i class="material-icons">close</i>';
            table += '</button>';
            table += '</td>';
            table += '<td></td>';
            table += '<td width="1%">';
            table += '</td>';
            table += '<td width="1%">';
            table += '</td>';
            table += '</tr>';
        }

        for (var i = 0; i < vistaCategoria.length; ++i) {


            table += '<tr>';
            table += '<td>' + vistaCategoria[i].tipo_categoria + '</td>';
            table += '<td>' + vistaCategoria[i].categoria_padre + '</td>';
            table += '<td width="1%">';

            if (vistaCategoria[i].plantilla_padre == 1) {
                if (vistaUserRol.rol_name == "administrator") {
                    table += '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"';
                    table += 'data-target="#saveModal"';
                    table += 'onclick="editarCategoria(' + vistaCategoria[i].id_padre + ')">';
                    table += '<i class="material-icons">edit</i>';
                    table += '</button>';
                }
            } else {
                if (vistaCategoria[i].user_padre == id_user) {
                    table += '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"';
                    table += 'data-target="#saveModal"';
                    table += 'onclick="editarCategoria(' + vistaCategoria[i].id_padre + ')">';
                    table += '<i class="material-icons">edit</i>';
                    table += '</button>';
                }
            }

            table += '</td>';
            table += '<td width="1%">';

            if (vistaCategoria[i].plantilla_padre == 1) {
                if (vistaUserRol.rol_name == "administrator") {
                    table += '<button class="btn btn-danger btn-fab btn-fab-mini"';
                    table += 'onclick="borrarCategoria(' + vistaCategoria[i].id_padre + ')">';
                    table += '<i class="material-icons">close</i>';
                    table += '</button>';
                }
            } else {
                if (vistaCategoria[i].user_padre == id_user) {
                    table += '<button class="btn btn-danger btn-fab btn-fab-mini"';
                    table += 'onclick="borrarCategoria(' + vistaCategoria[i].id_padre + ')">';
                    table += '<i class="material-icons">close</i>';
                    table += '</button>';
                }
            }

            table += '</td>';
            table += '<td>' + vistaCategoria[i].categoria + '</td>';
            table += '<td width="1%">';
            table += '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"';
            table += 'data-target="#saveModal2" onclick="editarSubCategoria(' + vistaCategoria[i].id + ')">';
            table += '<i class="material-icons">edit</i>';
            table += '</button>';
            table += '</td>';
            table += '<td width="1%">';
            table += '<button class="btn btn-danger btn-fab btn-fab-mini"';
            table += 'onclick="borrarSubCategoria(' + vistaCategoria[i].id + ')">';
            table += '<i class="material-icons">close</i>';
            table += '</button>';
            table += '</td>';
            table += '</tr>';
        }

        $('#example tbody').html(table);
    }

    function editarCategoria(id) {
        console.log(id);
        var base_path = '{{ url('/') }}';
        $.ajax({
            url: base_path + "/categorias/" + id + "/edit_categoria",
            method: 'GET',
            success: function(data) {

                console.log(data);
                var vistaCategoriaPadre = data.vistaCategoriaPadre;
                var categoriaTipo = data.categoriaTipos;
                var categoriaLogo = data.categoriaLogos;
                var option_tipo = '<option value="">Seleccione Tipo de Categoria</option>';
                var option_logo = '<option value="">Seleccione Logo</option>';
                var logo_temp = '';

                document.getElementById("id_categoria").value = vistaCategoriaPadre.id;
                document.getElementById("categoria").value = vistaCategoriaPadre.categoria;


                for (var i = 0; i < categoriaTipo.length; ++i) {
                    option_tipo += '<option value="' + categoriaTipo[i].id + '"';

                    if (vistaCategoriaPadre.tipo == categoriaTipo[i].id) {
                        option_tipo += 'selected'
                    }

                    option_tipo += '>';
                    option_tipo += categoriaTipo[i].tipo_categoria;
                    option_tipo += ' </option>';
                }

                $('#tipo_categoria').html(option_tipo);
            }
        });
    }

    function deleteCategoria(id) {
        var base_path = '{{ url('/') }}';
        $.ajax({
            url: base_path + "/categorias/" + id + "/delete",
            method: 'GET',
            success: function(data) {
                cargarTabla();
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Registro Eliminado Correctamente, Información Actualizada',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        });
    }

    function borrarCategoria(id) {
        Swal.fire({
            title: '¿Esta seguro de eliminar toda la categoria y sus Subcategorias?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Si',
            denyButtonText: `No`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                deletecategoria(id);
            } else if (result.isDenied) {}
        })
    }

</script>
