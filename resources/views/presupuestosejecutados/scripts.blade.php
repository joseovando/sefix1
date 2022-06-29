<script>
    $(function() {
        /* Storage Inicial */
        var categoriaSearch = 0;
        localStorage.setItem("categoria_search", categoriaSearch);
        localStorage.setItem("llave_ajax", categoriaSearch);
        localStorage.setItem("vistaCategorias",
            JSON.stringify(""));
        localStorage.setItem("array_categoria",
            JSON.stringify(""));
        localStorage.setItem("fechas",
            JSON.stringify(""));
        localStorage.setItem("id_categoria", categoriaSearch);
        localStorage.setItem("date", "");
    });

    function momentGet(date) {
        var userDate = date;
        var date_string = moment(userDate, "DD.MM.YY").format("YYYY-MM-DD");

        if (date_string == "Invalid date") {
            date_string = '';
        }

        return date_string;
    }

    function momentSet(date) {
        var userDate = date;
        var date_string = moment(userDate, "YYYY-MM-DD").format("DD/MM/YY");

        if (date_string == "Invalid date") {
            date_string = '';
        }

        return date_string;
    }
</script>

<script type="text/javascript" class="init">
    $(document).ready(function() {
        $('#example').DataTable({
            scrollY: '50vh',
            scrollX: '50vh',
            scrollCollapse: true,
            paging: false,
            ordering: false,
            info: false,
            searching: false,
        });
    });
</script>

<script>
    function nav(value) {
        if (value != "") {
            location.href = value;
        }
    }

    function round(num) {
        var m = Number((Math.abs(num) * 100).toPrecision(15));
        return Math.round(m) / 100 * Math.sign(num);
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#guardarEjecutado').click(function(e) {
            e.preventDefault();

            /* guardado categoria inicial */
            var _token = $("input[name='_token']").val();
            var vistaCategorias = @json($vistaCategorias);
            var array_categoria = @json($array_categoria);
            var id_user = @json(auth()->id());
            var n_inputs = @json($n_inputs);
            var fecha = @json($fechas);
            var tipo = @json($tipo);
            var monto = '';
            var monto_search = '';
            var monto_ajax = '';
            var date = @json($date);
            var id_categoria = @json($id_categoria);

            for (var i = 0; i < vistaCategorias.length; ++i) {

                if (array_categoria[vistaCategorias[i].id_categoria]['plantilla'] == 1) {

                    for (var j = 0; j <= n_inputs; ++j) {

                        input_monto = "#" + vistaCategorias[i].id_categoria + "_" + fecha[j];
                        input_detalle = "#detalle_" + vistaCategorias[i].id_categoria + "_" + fecha[j];

                        monto += $(input_monto).val() + ".||" +
                            vistaCategorias[i].id_categoria + ".||" +
                            fecha[j] + ".||" +
                            $(input_detalle).val() + ".|||";
                    }
                }

                if (array_categoria[vistaCategorias[i].id_categoria]['id_user'] == id_user) {

                    for (var k = 0; k <= n_inputs; ++k) {

                        input_monto = "#" + vistaCategorias[i].id_categoria + "_" + fecha[k];
                        input_detalle = "#detalle_" + vistaCategorias[i].id_categoria + "_" + fecha[k];

                        monto += $(input_monto).val() + ".||" +
                            vistaCategorias[i].id_categoria + ".||" +
                            fecha[k] + ".||" +
                            $(input_detalle).val() + ".|||";
                    }
                }
            }

            /* guardado search */
            for (var j = 0; j <= n_inputs; ++j) {

                input_monto = "#search_" + fecha[j];
                input_detalle = "#detalle_" + fecha[j];
                var categoriaSearch = parseInt(localStorage.getItem("categoria_search"));

                monto_search += $(input_monto).val() + ".||" +
                    categoriaSearch + ".||" +
                    fecha[j] + ".||" +
                    $(input_detalle).val() + ".|||";
            }

            /* guardado ajax */
            var vistaCategoriaAjax = JSON.parse(localStorage.getItem("vistaCategorias"));
            var array_categoria_ajax = JSON.parse(window.localStorage.getItem("array_categoria"));
            var fecha_ajax = JSON.parse(window.localStorage.getItem("fechas"));

            for (var i = 0; i < vistaCategoriaAjax.length; ++i) {

                if (array_categoria_ajax[vistaCategoriaAjax[i].id_categoria]['plantilla'] == 1) {

                    for (var j = 0; j <= n_inputs; ++j) {

                        input_monto = "#monto_ajax_" + i + "_" + j;
                        input_detalle = "#detalle_ajax_" + i + "_" + j;

                        monto_ajax += $(input_monto).val() + ".||" +
                            vistaCategoriaAjax[i].id_categoria + ".||" +
                            fecha_ajax[j] + ".||" +
                            $(input_detalle).val() + ".|||";
                    }
                }

                if (array_categoria_ajax[vistaCategoriaAjax[i].id_categoria]['id_user'] == id_user) {

                    for (var k = 0; k <= n_inputs; ++k) {

                        input_monto = "#monto_ajax_" + i + "_" + k;
                        input_detalle = "#detalle_ajax_" + i + "_" + k;

                        monto_ajax += $(input_monto).val() + ".||" +
                            vistaCategoriaAjax[i].id_categoria + ".||" +
                            fecha_ajax[k] + ".||" +
                            $(input_detalle).val() + ".|||";
                    }
                }
            }

            console.log(monto);

            $.ajax({
                url: "{{ route('presupuestosejecutados.store') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    monto: monto,
                    monto_search: monto_search,
                    monto_ajax: monto_ajax,
                    tipo: tipo,
                    date: date,
                    fecha: fecha,
                    id_categoria: id_categoria
                },
                success: function(data) {
                    var llave_ajax = parseInt(
                        localStorage.getItem("llave_ajax"));

                    if (llave_ajax == 1) {
                        cargarTotalAjax();
                    } else {

                        if (data.llave_categoria == 0) {
                            totalPrimario(data);
                        } else {
                            totalSearch(data);
                        }
                    }

                    printMsg(data);
                }
            });
        });

        function printMsg(msg) {
            if ($.isEmptyObject(msg.error)) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Registro Guardado Correctamente, Información Actualizada',
                    showConfirmButton: false,
                    timer: 2000
                })

            } else {
                $.each(msg.error, function(key, value) {
                    $('.' + key + '_err').text(value);
                });
            }
        }

        $('#buscarCategoria').click(function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            var search = $("#autoComplete").val();
            var tipo = @json($tipo);
            var date = @json($date);

            $.ajax({
                url: "{{ route('presupuestosejecutados.search') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    search: search,
                    tipo: tipo,
                    date: date
                },
                success: function(data) {
                    cargarSearch(data);
                    totalSearch(data);
                }
            });
        });

        function cargarSearch(data) {
            var vistaCategoria = @json($vistaCategorias);
            var n_inputs = @json($n_inputs);
            var categoria = data.vistaCategoria;
            var egreso = data.egreso_search;
            var detalle = data.detalle;
            var fechas = data.fechas;

            /* ocultar categorias iniciales */
            for (var i in vistaCategoria) {
                var tr = "tr_inicial_" + vistaCategoria[i].id_categoria;
                let element_exist = !!document.getElementById(tr);
                let element = document.getElementById(tr);

                if (element_exist == true) {
                    element.setAttribute("hidden", "hidden");
                }
            };

            /* mostrar categorias search */
            var tr_hidden = "tr_search";
            let element = document.getElementById(tr_hidden);
            element.removeAttribute("hidden", "hidden");
            document.getElementById("search_categoria").innerHTML = categoria.categoria;
            localStorage.setItem("categoria_search", categoria.id);

            /* cargar data search */
            for (var i = 0; i <= n_inputs; ++i) {
                egreso_search = "search_" + fechas[i];
                detalle_search = "detalle_" + fechas[i];

                if (egreso[i] > 0) {
                    document.getElementById(egreso_search).value = egreso[i];
                    document.getElementById(detalle_search).value = detalle[i];
                }
            }
        }

        function totalSearch(data) {
            var n_inputs = @json($n_inputs);
            var egreso = data.egreso_search;
            total_ejecutado_mes = data.total_ejecutado_mes_search;
            total_programado_mes = data.total_programado_mes_search;
            diferencia_mes = data.diferencia_mes_search;
            porcentaje_mes = data.porcentaje_mes_search;
            var tipo = @json($tipo);

            for (var i = 0; i <= n_inputs; ++i) {
                total_search = "#total_dia_" + i + " span";

                if (egreso[i] > 0) {
                    $(total_search).text(egreso[i])
                } else {
                    $(total_search).text("");
                }
            }

            $("#total_ejecutado span").text(total_ejecutado_mes);
            $("#total_programado span").text(total_programado_mes);
            $("#monto_ejecutado span").text(total_ejecutado_mes);
            $("#monto_programado span").text(total_programado_mes);
            $("#diferencia_mes span").text(diferencia_mes);
            $("#porcentaje_mes span").text(porcentaje_mes);

            if (tipo == 1) {
                if (porcentaje_mes >= 0 &&
                    porcentaje_mes < 70) {
                    var th_diferencia = "th_diferencia_search";
                    document.getElementById(th_diferencia).style.backgroundColor = "#f087b9";
                    var th_porcentaje = "th_porcentaje_search";
                    document.getElementById(th_porcentaje).style.backgroundColor = "#f087b9";
                }
                if (porcentaje_mes >= 70 &&
                    porcentaje_mes < 90) {
                    var th_diferencia = "th_diferencia_search";
                    document.getElementById(th_diferencia).style.backgroundColor = "#fa9e39";
                    var th_porcentaje = "th_porcentaje_search";
                    document.getElementById(th_porcentaje).style.backgroundColor = "#fa9e39";
                }
                if (porcentaje_mes >= 90) {
                    var th_diferencia = "th_diferencia_search";
                    document.getElementById(th_diferencia).style.backgroundColor = "#35d3ee";
                    var th_porcentaje = "th_porcentaje_search";
                    document.getElementById(th_porcentaje).style.backgroundColor = "#35d3ee";
                }
            } else {
                if (porcentaje_mes >= 0 &&
                    porcentaje_mes < 70) {
                    var th_diferencia = "th_diferencia_search";
                    document.getElementById(th_diferencia).style.backgroundColor = "#b1d537";
                    var th_porcentaje = "th_porcentaje_search";
                    document.getElementById(th_porcentaje).style.backgroundColor = "#b1d537";
                }
                if (porcentaje_mes >= 70 &&
                    porcentaje_mes < 90) {
                    var th_diferencia = "th_diferencia_search";
                    document.getElementById(th_diferencia).style.backgroundColor = "#fae033";
                    var th_porcentaje = "th_porcentaje_search";
                    document.getElementById(th_porcentaje).style.backgroundColor = "#fae033";
                }
                if (porcentaje_mes >= 90) {
                    var th_diferencia = "th_diferencia_search";
                    document.getElementById(th_diferencia).style.backgroundColor = "#f96666";
                    var th_porcentaje = "th_porcentaje_search";
                    document.getElementById(th_porcentaje).style.backgroundColor = "#f96666";
                }
            }
        }

        function totalPrimario(data) {
            var n_inputs = @json($n_inputs);
            var egreso = data.egreso_primario;
            total_ejecutado_mes = data.total_ejecutado_mes_primario;
            total_programado_mes = data.total_programado_mes_primario;
            diferencia_mes = data.diferencia_mes_primario;
            porcentaje_mes = data.porcentaje_mes_primario;
            total_ejecutado = data.total_ejecutado;
            total_programado = data.total_programado;
            var vistaCategoria = @json($vistaCategorias);
            var tipo = @json($tipo);

            for (var i = 0; i <= n_inputs; ++i) {
                total_search = "#total_dia_" + i + " span";

                if (egreso[i] > 0) {
                    $(total_search).text(round(egreso[i]))

                } else {
                    $(total_search).text("");
                }
            }

            for (var i in vistaCategoria) {

                if (tipo == 1) {
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 0 &&
                        porcentaje_mes[vistaCategoria[i].id_categoria] < 70) {
                        var th_diferencia = "th_diferencia_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_diferencia).style.backgroundColor = "#f087b9";
                        var th_porcentaje = "th_porcentaje_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#f087b9";
                    }
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 70 &&
                        porcentaje_mes[vistaCategoria[i].id_categoria] < 90) {
                        var th_diferencia = "th_diferencia_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_diferencia).style.backgroundColor = "#fa9e39";
                        var th_porcentaje = "th_porcentaje_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#fa9e39";
                    }
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 90) {
                        var th_diferencia = "th_diferencia_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_diferencia).style.backgroundColor = "#35d3ee";
                        var th_porcentaje = "th_porcentaje_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#35d3ee";
                    }
                } else {
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 0 &&
                        porcentaje_mes[vistaCategoria[i].id_categoria] < 70) {
                        var th_diferencia = "th_diferencia_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_diferencia).style.backgroundColor = "#b1d537";
                        var th_porcentaje = "th_porcentaje_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#b1d537";
                    }
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 70 &&
                        porcentaje_mes[vistaCategoria[i].id_categoria] < 90) {
                        var th_diferencia = "th_diferencia_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_diferencia).style.backgroundColor = "#fae033";
                        var th_porcentaje = "th_porcentaje_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#fae033";
                    }
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 90) {
                        var th_diferencia = "th_diferencia_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_diferencia).style.backgroundColor = "#f96666";
                        var th_porcentaje = "th_porcentaje_" + vistaCategoria[i].id_categoria;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#f96666";
                    }
                }

                var monto_ejecutado_primario = "#monto_ejecutado_" + vistaCategoria[i].id_categoria + " span";
                var monto_programado_primario = "#monto_programado_" + vistaCategoria[i].id_categoria + " span";
                var diferencia_primario = "#diferencia_" + vistaCategoria[i].id_categoria + " span";
                var porcentaje_primario = "#porcentaje_" + vistaCategoria[i].id_categoria + " span";

                $(monto_ejecutado_primario).text(round(total_ejecutado_mes[vistaCategoria[i].id_categoria]));
                $(monto_programado_primario).text(round(total_programado_mes[vistaCategoria[i].id_categoria]));
                $(diferencia_primario).text(round(diferencia_mes[vistaCategoria[i].id_categoria]));
                $(porcentaje_primario).text(round(porcentaje_mes[vistaCategoria[i].id_categoria]));

                $("#total_ejecutado span").text(total_ejecutado);
                $("#total_programado span").text(total_programado);
            };
        }

        $('#reloadCategoria').click(function(e) {
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var vistaCategoria = @json($vistaCategorias);
            var fecha = @json($fechas);
            var id_categoria = @json($id_categoria);
            var tipo = @json($tipo);
            var date = @json($date);

            /* mostar categorias iniciales */
            for (var i in vistaCategoria) {
                var tr = "tr_inicial_" + vistaCategoria[i].id_categoria;
                let element_exist = !!document.getElementById(tr);
                let element = document.getElementById(tr);

                if (element_exist == true) {
                    element.removeAttribute("hidden", "hidden");
                }
            };

            /* ocultar categorias search */
            var tr_hidden = "tr_search";
            let element = document.getElementById(tr_hidden);
            element.setAttribute("hidden", "hidden");

            $.ajax({
                url: "{{ route('presupuestosejecutados.totales') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    fecha: fecha,
                    id_categoria: id_categoria,
                    tipo: tipo,
                    date: date
                },
                success: function(data) {
                    totalPrimario(data);
                }
            });

        });

        $('#cambiarFecha').click(function(e) {
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var id_categoria = @json($id_categoria);
            var llave_form = 1;
            var tipo = @json($tipo);
            var date = momentGet($("#date").val());

            $.ajax({
                url: "{{ route('presupuestosejecutados.cambiar_fecha') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    id_categoria: id_categoria,
                    llave_form: llave_form,
                    tipo: tipo,
                    date: date
                },
                success: function(data) {
                    localStorage.setItem("vistaCategorias",
                        JSON.stringify(data.vistaCategorias));
                    localStorage.setItem("array_categoria",
                        JSON.stringify(data.array_categoria));
                    localStorage.setItem("fechas",
                        JSON.stringify(data.fechas));
                    localStorage.setItem("id_categoria", data.id_categoria);
                    localStorage.setItem("date", data.date);
                    localStorage.setItem("llave_ajax", 1);

                    cargarAjax(data);
                }
            });
        });

        function cargarTotalAjax() {
            var _token = $("input[name='_token']").val();
            var fecha = JSON.parse(window.localStorage.getItem("fechas"));
            var id_categoria = parseInt(localStorage.getItem("id_categoria"));
            var tipo = @json($tipo);
            var date = parseInt(localStorage.getItem("date"));

            $.ajax({
                url: "{{ route('presupuestosejecutados.totales') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    fecha: fecha,
                    id_categoria: id_categoria,
                    tipo: tipo,
                    date: date
                },
                success: function(data) {
                    totalAjax(data);
                }
            });
        }

        function totalAjax(data) {
            var n_inputs = @json($n_inputs);
            var egreso = data.egreso_primario;
            total_ejecutado_mes = data.total_ejecutado_mes_primario;
            total_programado_mes = data.total_programado_mes_primario;
            diferencia_mes = data.diferencia_mes_primario;
            porcentaje_mes = data.porcentaje_mes_primario;
            total_ejecutado = data.total_ejecutado;
            total_programado = data.total_programado;
            var tipo = @json($tipo);
            _
            var llave_ajax = parseInt(localStorage.getItem("llave_ajax"));

            if (llave_ajax == 1) {
                var vistaCategoria = JSON.parse(localStorage.getItem("vistaCategorias"));
            } else {
                var vistaCategoria = @json($vistaCategorias);
            }

            for (var i = 0; i <= n_inputs; ++i) {
                total_search = "#total_dia_" + i + " span";

                if (egreso[i] > 0) {
                    $(total_search).text(round(egreso[i]))

                } else {
                    $(total_search).text("");
                }
            }

            for (var i in vistaCategoria) {

                if (tipo == 1) {
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 0 &&
                        porcentaje_mes[vistaCategoria[i].id_categoria] < 70) {
                        var th_diferencia = "th_diferencia_ajax_" + i;
                        document.getElementById(th_diferencia).style.backgroundColor = "#f087b9";
                        var th_porcentaje = "th_porcentaje_ajax_" + i;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#f087b9";
                    }
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 70 &&
                        porcentaje_mes[vistaCategoria[i].id_categoria] < 90) {
                        var th_diferencia = "th_diferencia_ajax_" + i;
                        document.getElementById(th_diferencia).style.backgroundColor = "#fa9e39";
                        var th_porcentaje = "th_porcentaje_ajax_" + i;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#fa9e39";
                    }
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 90) {
                        var th_diferencia = "th_diferencia_ajax_" + i;
                        document.getElementById(th_diferencia).style.backgroundColor = "#35d3ee";
                        var th_porcentaje = "th_porcentaje_ajax_" + i;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#35d3ee";
                    }
                } else {
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 0 &&
                        porcentaje_mes[vistaCategoria[i].id_categoria] < 70) {
                        var th_diferencia = "th_diferencia_ajax_" + i;
                        document.getElementById(th_diferencia).style.backgroundColor = "#b1d537";
                        var th_porcentaje = "th_porcentaje_ajax_" + i;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#b1d537";
                    }
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 70 &&
                        porcentaje_mes[vistaCategoria[i].id_categoria] < 90) {
                        var th_diferencia = "th_diferencia_ajax_" + i;
                        document.getElementById(th_diferencia).style.backgroundColor = "#fae033";
                        var th_porcentaje = "th_porcentaje_ajax_" + i;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#fae033";
                    }
                    if (porcentaje_mes[vistaCategoria[i].id_categoria] >= 90) {
                        var th_diferencia = "th_diferencia_ajax_" + i;
                        document.getElementById(th_diferencia).style.backgroundColor = "#f96666";
                        var th_porcentaje = "th_porcentaje_ajax_" + i;
                        document.getElementById(th_porcentaje).style.backgroundColor = "#f96666";
                    }
                }

                var monto_ejecutado_ajax = "#monto_ejecutado_ajax_" + i + " span";
                var monto_programado_ajax = "#monto_programado_ajax_" + i + " span";
                var diferencia_ajax = "#diferencia_ajax_" + i + " span";
                var porcentaje_ajax = "#porcentaje_ajax_" + i + " span";

                $(monto_ejecutado_ajax).text(round(total_ejecutado_mes[vistaCategoria[i].id_categoria]));
                $(monto_programado_ajax).text(round(total_programado_mes[vistaCategoria[i].id_categoria]));
                $(diferencia_ajax).text(round(diferencia_mes[vistaCategoria[i].id_categoria]));
                $(porcentaje_ajax).text(round(porcentaje_mes[vistaCategoria[i].id_categoria]));

                $("#total_ejecutado span").text(total_ejecutado)
                $("#total_programado span").text(total_programado);
            };
        }

        function cargarAjax(data) {
            var _token = $("input[name='_token']").val();
            var vistaCategorias = data.vistaCategorias;
            var array_categoria = data.array_categoria;
            var n_categorias = @json($vistaCategorias);
            var n_inputs = data.n_inputs;
            var calendario = data.calendario;
            var fecha = data.fechas;
            var egreso = data.egreso;
            var detalle = data.detalle;
            var id_categoria = data.id_categoria;
            var date = data.date;
            var id_user = @json(auth()->id());
            var tipo = @json($tipo);

            /* ocultar categorias iniciales */
            for (var i in n_categorias) {
                var tr = "tr_inicial_" + n_categorias[i].id_categoria;
                let element_exist = !!document.getElementById(tr);
                let element = document.getElementById(tr);

                if (element_exist == true) {
                    element.setAttribute("hidden", "hidden");
                }
            };

            for (var i = 0; i < vistaCategorias.length; ++i) {

                /* mostrar categorias ajax */
                var tr_hidden = "tr_ajax_" + i;
                let element = document.getElementById(tr_hidden);
                element.removeAttribute("hidden", "hidden");

                for (var j = 0; j <= n_inputs; ++j) {
                    th_calendario = "#calendario_" + j + " span";
                    console.log(th_calendario);
                    $(th_calendario).text(calendario[j]);
                }

                if (array_categoria[vistaCategorias[i].id_categoria]['plantilla'] == 1) {

                    /* Titulo Categoria */
                    categoria_ajax = "#categoria_ajax_" + i + " span";
                    $(categoria_ajax).text(array_categoria[vistaCategorias[i].id_categoria]['id_categoria']);

                    for (var j = 0; j <= n_inputs; ++j) {

                        input_monto = "monto_ajax_" + i + "_" + j;
                        input_detalle = "detalle_ajax_" + i + "_" + j;
                        document.getElementById(input_monto).value = '';
                        document.getElementById(input_detalle).value = '';

                        /* cargar data monto */
                        if (egreso[j] !== undefined) {

                            if (egreso[j][vistaCategorias[i].id_categoria] === undefined) {} else {
                                var egreso_val = egreso[j][vistaCategorias[i].id_categoria];

                                var detalle_val = detalle[j][vistaCategorias[i].id_categoria];
                                document.getElementById(input_detalle).value = detalle_val;

                                if (egreso_val > 0) {
                                    document.getElementById(input_monto).value = egreso_val;
                                }
                            }
                        }
                    }

                }

                if (array_categoria[vistaCategorias[i].id_categoria]['id_user'] == id_user) {

                    /* Titulo Categoria */
                    categoria_ajax = "#categoria_ajax_" + i + " span";
                    $(categoria_ajax).text(array_categoria[vistaCategorias[i].id_categoria]['id_categoria']);

                    for (var j = 0; j <= n_inputs; ++j) {

                        input_monto = "monto_ajax_" + i + "_" + j;
                        input_detalle = "detalle_ajax_" + i + "_" + j;
                        document.getElementById(input_monto).value = '';
                        document.getElementById(input_detalle).value = '';

                        /* cargar data monto */
                        if (egreso[j] !== undefined) {

                            if (egreso[j][vistaCategorias[i].id_categoria] === undefined) {} else {
                                var egreso_val = egreso[j][vistaCategorias[i].id_categoria];

                                var detalle_val = detalle[j][vistaCategorias[i].id_categoria];
                                document.getElementById(input_detalle).value = detalle_val;

                                if (egreso_val > 0) {
                                    document.getElementById(input_monto).value = egreso_val;
                                }
                            }
                        }
                    }
                }
            }

            $.ajax({
                url: "{{ route('presupuestosejecutados.totales') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    fecha: fecha,
                    id_categoria: id_categoria,
                    tipo: tipo,
                    date: date
                },
                success: function(data2) {
                    totalAjax(data2);
                }
            });
        }

        $("#select_categoria").on("change", function() {
            var _token = $("input[name='_token']").val();
            var id_categoria = $("#select_categoria").val();
            var llave_form = 1;
            var tipo = @json($tipo);
            var llave_ajax = parseInt(localStorage.getItem("llave_ajax"));

            if (llave_ajax == 1) {
                var date = localStorage.getItem("date");
            } else {
                var date = @json($date);
            }

            $.ajax({
                url: "{{ route('presupuestosejecutados.cambiar_fecha') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    id_categoria: id_categoria,
                    llave_form: llave_form,
                    tipo: tipo,
                    date: date
                },
                success: function(data) {
                    localStorage.setItem("vistaCategorias",
                        JSON.stringify(data.vistaCategorias));
                    localStorage.setItem("array_categoria",
                        JSON.stringify(data.array_categoria));
                    localStorage.setItem("fechas",
                        JSON.stringify(data.fechas));
                    localStorage.setItem("id_categoria", data.id_categoria);
                    localStorage.setItem("date", data.date);
                    localStorage.setItem("llave_ajax", 1);

                    cargarAjax(data);
                }
            });
        });

        $('#cargarGrafica').click(function(e) {
            e.preventDefault();
            let element = document.getElementById("div_reporte");
            element.removeAttribute("hidden", "hidden");
            document.getElementById("bar-ingresos-egresos-anual").style.height = "300px";
        });

    });
</script>

<script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('js/chartjs-plugin-labels.js') }}"></script>

<script>
    const cDataTotalIngresoMes = JSON.parse(`<?php echo $data_total_ingreso_mes; ?>`);
    const cDataTotalIngresoProgramadoMes = JSON.parse(`<?php echo $data_total_ingreso_programado_mes; ?>`);
    const cDataTotalEgresoMes = JSON.parse(`<?php echo $data_total_egreso_mes; ?>`);
    const cDataTotalEgresoProgramadoMes = JSON.parse(`<?php echo $data_total_egreso_programado_mes; ?>`);

    $(document).ready(function() {

        new Chart(document.getElementById('bar-ingresos-egresos-anual'), {
            type: 'bar',
            data: {
                labels: ['ENE',
                    'FEB',
                    'MAR',
                    'ABR',
                    'MAY',
                    'JUN',
                    'JUL',
                    'AGO',
                    'SEP',
                    'OCT',
                    'NOV',
                    'DIC',
                ],
                datasets: [{
                        label: 'Ingreso Ejecutado',
                        data: cDataTotalIngresoMes,
                        backgroundColor: [
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                            '#FF6384',
                        ]
                    },
                    {
                        label: 'Ingreso Programado',
                        data: cDataTotalIngresoProgramadoMes,
                        backgroundColor: [
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                            '#36A2EB',
                        ]
                    },
                    {
                        label: 'Egreso Ejecutado',
                        data: cDataTotalEgresoMes,
                        backgroundColor: [
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                            '#c663ff',
                        ]
                    },
                    {
                        label: 'Egreso Programado',
                        data: cDataTotalEgresoProgramadoMes,
                        backgroundColor: [
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                            '#6dff63',
                        ]
                    },
                ]
            },
            options: {
                title: {
                    display: true,
                    text: '',
                    position: 'top',
                    fontSize: 16,
                    fontColor: '#111',
                    padding: 20
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        fontColor: '#111',
                        padding: 15
                    }
                },
                tooltips: {
                    enabled: true
                },
                plugins: {
                    labels: {
                        render: 'value'
                    }
                }
            }
        });

    });
</script>
