<script type="text/javascript" class="init">
    $(document).ready(function() {
        $('#table_ingresos_corrientes').DataTable({
            scrollCollapse: true,
            paging: true,
            ordering: true,
            info: true,
            searching: true,
        });
        $('#table_ingresos_inversiones').DataTable({
            scrollCollapse: true,
            paging: true,
            ordering: true,
            info: true,
            searching: true,
        });
        $('#table_egresos_corrientes').DataTable({
            scrollCollapse: true,
            paging: true,
            ordering: true,
            info: true,
            searching: true,
        });
        $('#table_prestamos').DataTable({
            scrollCollapse: true,
            paging: true,
            ordering: true,
            info: true,
            searching: true,
        });
        $('#table_coeficientes').DataTable({
            scrollCollapse: true,
            paging: true,
            ordering: true,
            info: true,
            searching: true,
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#form_guardar_datos_basicos").validate();
    });

    function momentGet(date) {
        var userDate = date;
        var date_string = moment(userDate, "DD.MM.YYYY").format("YYYY-MM-DD");
        if (date_string == "Invalid date") {
            date_string = '';
        }

        return date_string;
    }

    function momentSet(date) {
        var userDate = date;
        var date_string = moment(userDate, "YYYY-MM-DD").format("DD/MM/YYYY");

        if (date_string == "Invalid date") {
            date_string = '';
        }

        return date_string;
    }

    function printMsg(data) {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Registro Guardado Correctamente, Información Actualizada',
            showConfirmButton: false,
            timer: 2000
        })
    }

    function getAnoNacimiento() {
        var ano_nacimiento = parseInt($("#ano_nacimiento").val()) + 0;
        return ano_nacimiento;
    }

    function getAnoJubilacionMax() {
        var ano_nacimiento = parseInt($("#ano_nacimiento").val()) + 0;
        var expectativa_vida = parseInt($("#expectativa_vida").val()) + 0;

        var max = ano_nacimiento + expectativa_vida;
        return max;
    }

    $("#expectativa_vida").change(function() {
        var expectativa_vida = parseInt($("#expectativa_vida").val()) + 0;
        if (expectativa_vida >= 50) {
            $("#ano_jubilacion").rules("add", {
                required: true,
                min: getAnoNacimiento(),
                max: getAnoJubilacionMax(),
                messages: {
                    required: "Required input",
                    minlength: jQuery.validator.format(
                        "Elija un Año de Jubilación mayor a la Fecha de Nacimiento y menor al año de Expectativa de vida"
                    )
                }
            });
        }
    })

    $("#fecha_nacimiento_conyuge").change(function() {
        var fecha_nacimiento_conyuge = momentGet($("#fecha_nacimiento_conyuge").val());
        ano_nacimiento_conyuge = parseInt(fecha_nacimiento_conyuge.substr(0, 4)) + 0;
        var expectativa_vida = parseInt($("#expectativa_vida").val()) + 0;
        var max_ano_nacimiento_conyuge = ano_nacimiento_conyuge + expectativa_vida;

        $("#ano_jubilacion_conyuge").rules("add", {
            required: true,
            min: ano_nacimiento_conyuge,
            max: max_ano_nacimiento_conyuge,
            messages: {
                required: "Required input",
                minlength: jQuery.validator.format(
                    "Elija un Año de Jubilación mayor a la Fecha de Nacimiento y menor al año de Expectativa de vida"
                )
            }
        });
    })

    $("#ano_culminacion").change(function() {
        var ano_inicio = parseInt($("#ano_inicio").val()) + 0;

        $("#ano_culminacion").rules("add", {
            required: true,
            min: ano_inicio,
            max: ano_culminacion_max(),
            messages: {
                required: "Required input",
                minlength: jQuery.validator.format(
                    "Elija un Año de Jubilación mayor a la Fecha de Nacimiento y menor al año de Expectativa de vida"
                )
            }
        });

    })

    $("#ano_culminacion_egreso").change(function() {
        var ano_inicio = parseInt($("#ano_inicio_egreso").val()) + 0;

        $("#ano_culminacion_egreso").rules("add", {
            required: true,
            min: ano_inicio,
            max: ano_culminacion_max(),
            messages: {
                required: "Required input",
                minlength: jQuery.validator.format(
                    "Elija un Año de Jubilación mayor a la Fecha de Nacimiento y menor al año de Expectativa de vida"
                )
            }
        });

    })

    /*     $("#ano_culminacion_inversion").change(function() {
            var ano_inicio = parseInt($("#ano_inicio_inversion").val()) + 0;

            $("#ano_culminacion_inversion").rules("add", {
                required: true,
                min: ano_inicio,
                max: ano_culminacion_max(),
                messages: {
                    required: "Required input",
                    minlength: jQuery.validator.format(
                        "Elija un Año de Jubilación mayor a la Fecha de Nacimiento y menor al año de Expectativa de vida"
                    )
                }
            });

        }) */

    $('#form_guardar_datos_basicos').validate({
        rules: {
            expectativa_vida: {
                required: true,
                min: 50,
                max: 100
            },
            porcentaje_renta: {
                required: true,
                min: 1,
                max: 100
            },
            porcentaje_renta_conyuge: {
                required: true,
                min: 1,
                max: 100
            },
        },
        submitHandler: function(form) {

            var _token = $("input[name='_token']").val();
            var id_datos_basicos = $("#id_datos_basicos").val();
            var expectativa_vida = $("#expectativa_vida").val();
            var select_jubilacion = $("#select_jubilacion").val();
            var ano_jubilacion = $("#ano_jubilacion").val();
            var porcentaje_renta = $("#porcentaje_renta").val();
            var select_conyuge = $("#select_conyuge").val();
            var fecha_nacimiento_conyuge = momentGet($("#fecha_nacimiento_conyuge").val());
            var select_jubilacion_conyuge = $("#select_jubilacion_conyuge").val();
            var ano_jubilacion_conyuge = $("#ano_jubilacion_conyuge").val();
            var porcentaje_renta_conyuge = $("#porcentaje_renta_conyuge").val();

            $.ajax({
                url: "{{ route('brujula.store_basicos') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    id_datos_basicos: id_datos_basicos,
                    expectativa_vida: expectativa_vida,
                    select_jubilacion: select_jubilacion,
                    ano_jubilacion: ano_jubilacion,
                    porcentaje_renta: porcentaje_renta,
                    select_conyuge: select_conyuge,
                    fecha_nacimiento_conyuge: fecha_nacimiento_conyuge,
                    select_jubilacion_conyuge: select_jubilacion_conyuge,
                    ano_jubilacion_conyuge: ano_jubilacion_conyuge,
                    porcentaje_renta_conyuge: porcentaje_renta_conyuge
                },
                success: function(data) {
                    document.getElementById("id_datos_basicos").value = data.brujulaDatosBasicos
                        .id;
                    printMsg(data);
                }
            });

        }
    })

    function cargarTablaCorriente(data) {
        var vistaBrujulaCorrientes = data.vistaBrujulaCorrientes;
        var tipo_corriente = data.tipo_corriente;
        var id_brujula_corriente = data.id_brujula_corriente;
        var table = '';
        var button_edit = '';
        var button_delete = '';
        var contador_corrientes = '';

        for (var i = 0; i < vistaBrujulaCorrientes.length; ++i) {

            contador_corrientes++;

            if (tipo_corriente == 1) {
                button_edit = '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"';
                button_edit += 'data-target="#ModalIngresosCorrientes"';
                button_edit += 'onclick="editarCorriente(' + vistaBrujulaCorrientes[i].id + ')">';
                button_edit += '<i class="material-icons">edit</i>';
                button_edit += '</button>';
            }

            if (tipo_corriente == 2) {
                button_edit = '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"';
                button_edit += 'data-target="#ModalEgresosCorrientes"';
                button_edit += 'onclick="editarCorriente(' + vistaBrujulaCorrientes[i].id + ')">';
                button_edit += '<i class="material-icons">edit</i>';
                button_edit += '</button>';
            }

            button_delete = '<button class="btn btn-danger btn-fab btn-fab-mini"';
            button_delete += 'onclick="borrarCorriente(' + vistaBrujulaCorrientes[i].id + ')">';
            button_delete += '<i class="material-icons">close</i>';
            button_delete += '</button>';

            if (vistaBrujulaCorrientes[i].tipo == tipo_corriente) {
                table += '<tr>';
                table += '<td>' + vistaBrujulaCorrientes[i].categoria + '</td>';
                table += '<td>' + vistaBrujulaCorrientes[i].cuenta + '</td>';
                table += '<td>' + vistaBrujulaCorrientes[i].ano_inicio + '</td>';
                table += '<td>' + vistaBrujulaCorrientes[i].ano_culminacion + '</td>';

                if (vistaBrujulaCorrientes[i].id_tipo_monto == 1) {
                    table += '<td>Valor Futuro</td>';
                } else {
                    table += '<td>Valor Actual</td>';
                }

                table += '<td>' + vistaBrujulaCorrientes[i].monto + '</td>';
                table += '<td>' + vistaBrujulaCorrientes[i].coeficiente_crecimiento + '</td>';
                table += '<td width="1%">' + button_edit + '</td>';
                table += '<td width="1%">' + button_delete + '</td>';
                table += '</tr>';
            }
        }

        if (tipo_corriente == 1) {
            $('#table_ingresos_corrientes tbody').html(table);
            $("#span_ingresos_corrientes").text(contador_corrientes);
            document.getElementById("tipo_corriente").value = tipo_corriente;
            document.getElementById("id_brujula_corriente").value = id_brujula_corriente;
        }

        if (tipo_corriente == 2) {
            $('#table_egresos_corrientes tbody').html(table);
            $("#span_egresos_corrientes").text(contador_corrientes);
            document.getElementById("tipo_corriente_egreso").value = tipo_corriente;
            document.getElementById("id_brujula_corriente_egreso").value = id_brujula_corriente;
        }
    }

    function cargarTablaCoeficiente(data) {
        var vistaBrujulaCoeficientes = data.vistaBrujulaCoeficientes;
        var id_brujula_coeficiente = data.id_brujula_coeficiente;
        var table = '';
        var button_edit = '';
        var button_delete = '';

        for (var i = 0; i < vistaBrujulaCoeficientes.length; ++i) {

            button_edit = '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"';
            button_edit += 'data-target="#ModalCoeficientes"';
            button_edit += 'onclick="editarCoeficientes(' + vistaBrujulaCoeficientes[i].id + ')">';
            button_edit += '<i class="material-icons">edit</i>';
            button_edit += '</button>';

            button_delete = '<button class="btn btn-danger btn-fab btn-fab-mini"';
            button_delete += 'onclick="borrarCoeficientes(' + vistaBrujulaCoeficientes[i].id + ')">';
            button_delete += '<i class="material-icons">close</i>';
            button_delete += '</button>';

            table += '<tr>';
            table += '<td>' + vistaBrujulaCoeficientes[i].tipo_categoria + '</td>';
            table += '<td>' + vistaBrujulaCoeficientes[i].categoria + '</td>';

            if (vistaBrujulaCoeficientes[i].id_valor_calculo == 1) {
                table += '<td>Personalizado</td>';
            } else {
                table += '<td>Determinado por el Sistema</td>';
            }

            table += '<td>' + vistaBrujulaCoeficientes[i].valor_sistema + '</td>';
            table += '<td>' + vistaBrujulaCoeficientes[i].valor_usuario + '</td>';
            table += '<td>' + vistaBrujulaCoeficientes[i].informacion_adicional + '</td>';
            table += '<td width="1%">' + button_edit + '</td>';
            table += '<td width="1%">' + button_delete + '</td>';
            table += '</tr>';
        }

        $('#table_coeficientes tbody').html(table);
        document.getElementById("id_brujula_coeficiente").value = id_brujula_coeficiente;
    }

    function cargarTablaInversiones(data) {

        var brujulaInversiones = data.brujulaInversiones;
        var id_brujula_inversion = data.id_brujula_inversion;
        var tipo_inversion = data.tipo_inversion;
        var table = '';
        var button_edit = '';
        var button_delete = '';
        var contador_inversiones = '';

        for (var i = 0; i < brujulaInversiones.length; ++i) {

            contador_inversiones++;

            if (tipo_inversion == 1) {
                button_edit = '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"';
                button_edit += 'data-target="#ModalIngresosInversiones"';
                button_edit += 'onclick="editarInversiones(' + brujulaInversiones[i].id + ')">';
                button_edit += '<i class="material-icons">edit</i>';
                button_edit += '</button>';
            }

            if (tipo_inversion == 2) {
                button_edit = '<button class="btn btn-warning btn-fab btn-fab-mini" data-toggle="modal"';
                button_edit += 'data-target="#ModalPrestamos"';
                button_edit += 'onclick="editarInversiones(' + brujulaInversiones[i].id + ')">';
                button_edit += '<i class="material-icons">edit</i>';
                button_edit += '</button>';
            }

            button_delete = '<button class="btn btn-danger btn-fab btn-fab-mini"';
            button_delete += 'onclick="borrarInversiones(' + brujulaInversiones[i].id + ')">';
            button_delete += '<i class="material-icons">close</i>';
            button_delete += '</button>';

            table += '<tr>';
            table += '<td>' + brujulaInversiones[i].cuenta + '</td>';
            table += '<td>' + brujulaInversiones[i].ano_inicio + '</td>';
            table += '<td>' + brujulaInversiones[i].ano_culminacion + '</td>';

            if (brujulaInversiones[i].id_tipo_capital == 1) {
                table += '<td>Valor Futuro</td>';
            } else {
                table += '<td>Valor Actual</td>';
            }

            table += '<td>' + brujulaInversiones[i].capital + '</td>';
            table += '<td>' + brujulaInversiones[i].porcentaje_interes_anual + '</td>';

            if (tipo_inversion == 1) {
                if (brujulaInversiones[i].tiene_devolucion_capital == 1) {
                    table += '<td>Si Aplica</td>';
                } else {
                    table += '<td>No Aplica</td>';
                }

                table += '<td>' + brujulaInversiones[i].coeficiente_crecimiento + '</td>';
            }

            table += '<td width="1%">' + button_edit + '</td>';
            table += '<td width="1%">' + button_delete + '</td>';
            table += '</tr>';
        }

        if (tipo_inversion == 1) {
            $('#table_ingresos_inversiones tbody').html(table);
            $("#span_ingresos_inversiones").text(contador_inversiones);
            document.getElementById("id_brujula_inversion").value = id_brujula_inversion;
        }

        if (tipo_inversion == 2) {
            $('#table_prestamos tbody').html(table);
            $("#span_prestamos").text(contador_inversiones);
            document.getElementById("id_brujula_prestamo").value = id_brujula_inversion;
        }
    }

    function ano_actual() {
        var currentTime = new Date();
        var year = currentTime.getFullYear();
        return year;
    }

    function ano_culminacion_max() {
        var expectativa_vida = $("#expectativa_vida").val();
        var ano_nacimiento = @json(substr($vistaUsersSpecific->fecha_nacimiento, 0, 4));
        var ano_culminacion = parseInt(ano_nacimiento) + parseInt(expectativa_vida);
        return ano_culminacion;
    }

    $('#form_guardar_ingresos_corrientes').validate({

        rules: {
            ano_inicio: {
                required: true,
                min: ano_actual(),
                max: ano_culminacion_max()
            },
            monto: {
                required: true,
                min: 1
            },
            coeficiente_crecimiento: {
                required: true,
                min: 1,
                max: 100
            },
        },

        submitHandler: function(form) {

            var _token = $("input[name='_token']").val();
            var id_brujula_corriente = $("#id_brujula_corriente").val();
            var tipo_corriente = $("#tipo_corriente").val();
            var categoria = $("#categoria").val();
            var cuenta = $("#cuenta").val();
            var ano_inicio = $("#ano_inicio").val();
            var ano_culminacion = $("#ano_culminacion").val();
            var tipo_monto = $("#tipo_monto").val();
            var monto = $("#monto").val();
            var coeficiente_crecimiento = $("#coeficiente_crecimiento").val();

            $.ajax({
                url: "{{ route('brujula.store_corrientes') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    id_brujula_corriente: id_brujula_corriente,
                    tipo_corriente: tipo_corriente,
                    categoria: categoria,
                    cuenta: cuenta,
                    ano_inicio: ano_inicio,
                    ano_culminacion: ano_culminacion,
                    tipo_monto: tipo_monto,
                    monto: monto,
                    coeficiente_crecimiento: coeficiente_crecimiento
                },
                success: function(data) {
                    printMsg(data);
                    cargarTablaCorriente(data);
                }
            });

        }
    });

    $('#form_guardar_egresos_corrientes').validate({

        rules: {
            ano_inicio_egreso: {
                required: true,
                min: ano_actual(),
                max: ano_culminacion_max()
            },
            monto_egreso: {
                required: true,
                min: 1
            },
            coeficiente_crecimiento_egreso: {
                required: false,
                min: 1,
                max: 100
            },
        },

        submitHandler: function(form) {

            var _token = $("input[name='_token']").val();
            var id_brujula_corriente = $("#id_brujula_corriente_egreso").val();
            var tipo_corriente = $("#tipo_corriente_egreso").val();
            var categoria = $("#categoria_egreso").val();
            var cuenta = $("#cuenta_egreso").val();
            var ano_inicio = $("#ano_inicio_egreso").val();
            var ano_culminacion = $("#ano_culminacion_egreso").val();
            var tipo_monto = $("#tipo_monto_egreso").val();
            var monto = $("#monto_egreso").val();
            var coeficiente_crecimiento = $("#coeficiente_crecimiento_egreso").val();

            $.ajax({
                url: "{{ route('brujula.store_corrientes') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    id_brujula_corriente: id_brujula_corriente,
                    tipo_corriente: tipo_corriente,
                    categoria: categoria,
                    cuenta: cuenta,
                    ano_inicio: ano_inicio,
                    ano_culminacion: ano_culminacion,
                    tipo_monto: tipo_monto,
                    monto: monto,
                    coeficiente_crecimiento: coeficiente_crecimiento
                },
                success: function(data) {
                    printMsg(data);
                    cargarTablaCorriente(data);
                }
            });

        }
    });

    $('#form_guardar_ingresos_inversiones').validate({

        rules: {
            ano_inicio_inversion: {
                required: true,
                min: ano_actual(),
                max: ano_culminacion_max()
            },
        },

        submitHandler: function(form) {

            var _token = $("input[name='_token']").val();
            var id_brujula_inversion = $("#id_brujula_inversion").val();
            var tipo_inversion = $("#tipo_inversion").val();
            var cuenta = $("#cuenta_inversion").val();
            var ano_inicio = $("#ano_inicio_inversion").val();
            var ano_culminacion = $("#ano_culminacion_inversion").val();
            var tipo_capital = $("#tipo_capital").val();
            var capital = $("#capital").val();
            var interes_anual = $("#interes_anual").val();
            var devolucion_capital = $("#devolucion_capital").val();
            var coeficiente_crecimiento = $("#coeficiente_crecimiento_inversion").val();

            $.ajax({
                url: "{{ route('brujula.store_inversiones') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    id_brujula_inversion: id_brujula_inversion,
                    tipo_inversion: tipo_inversion,
                    cuenta: cuenta,
                    ano_inicio: ano_inicio,
                    ano_culminacion: ano_culminacion,
                    tipo_capital: tipo_capital,
                    capital: capital,
                    interes_anual: interes_anual,
                    devolucion_capital: devolucion_capital,
                    coeficiente_crecimiento: coeficiente_crecimiento
                },
                success: function(data) {
                    cargarTablaInversiones(data);
                    printMsg(data);
                }
            });

        }
    });

    $('#form_guardar_prestamos').validate({

        rules: {
            ano_inicio_prestamo: {
                required: true,
                min: ano_actual(),
                max: ano_culminacion_max()
            },
        },

        submitHandler: function(form) {

            var _token = $("input[name='_token']").val();
            var id_brujula_inversion = $("#id_brujula_prestamo").val();
            var tipo_inversion = $("#tipo_prestamo").val();
            var cuenta = $("#cuenta_prestamo").val();
            var ano_inicio = $("#ano_inicio_prestamo").val();
            var ano_culminacion = $("#ano_culminacion_prestamo").val();
            var tipo_capital = $("#tipo_capital_prestamo").val();
            var capital = $("#capital_prestamo").val();
            var interes_anual = $("#interes_anual_prestamo").val();
            var devolucion_capital = 0;
            var coeficiente_crecimiento = 0;

            $.ajax({
                url: "{{ route('brujula.store_inversiones') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    id_brujula_inversion: id_brujula_inversion,
                    tipo_inversion: tipo_inversion,
                    cuenta: cuenta,
                    ano_inicio: ano_inicio,
                    ano_culminacion: ano_culminacion,
                    tipo_capital: tipo_capital,
                    capital: capital,
                    interes_anual: interes_anual,
                    devolucion_capital: devolucion_capital,
                    coeficiente_crecimiento: coeficiente_crecimiento
                },
                success: function(data) {
                    cargarTablaInversiones(data);
                    printMsg(data);
                }
            });

        }
    });

    $('#form_guardar_coeficientes').validate({

        submitHandler: function(form) {

            var _token = $("input[name='_token']").val();
            var coeficiente = $("#coeficiente").val();
            var id_coeficiente = $("#id_brujula_coeficiente").val();
            var valor_calculo = $("#valor_calculo").val();
            var valor_personalizado = $("#valor_personalizado").val();
            var informacion_adicional = $("#informacion_adicional").val();

            $.ajax({
                url: "{{ route('brujula.store_coeficientes') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    coeficiente: coeficiente,
                    id_coeficiente: id_coeficiente,
                    valor_calculo: valor_calculo,
                    valor_personalizado: valor_personalizado,
                    informacion_adicional: informacion_adicional
                },
                success: function(data) {
                    cargarTablaCoeficiente(data);
                    printMsg(data);
                }
            });

        }
    });

    $(document).ready(function() {
        jQuery.extend(jQuery.validator.messages, {
            required: "<h4>Este campo es obligatorio.</h4>",
        });
    });

    function rentaJubilacion(sel) {
        let element1 = document.getElementById("div_ano_renta");
        let element2 = document.getElementById("div_porcentaje_renta");
        let element3 = document.getElementById("ano_jubilacion");
        let element4 = document.getElementById("porcentaje_renta");

        if (sel.value == "I") {
            element1.removeAttribute("hidden", "hidden");
            element2.removeAttribute("hidden", "hidden");
            element3.setAttribute("required", "");
            element4.setAttribute("required", "");

        } else {
            element1.setAttribute("hidden", "hidden");
            element2.setAttribute("hidden", "hidden");
            element3.removeAttribute("required", "");
            element4.removeAttribute("required", "");
        }
    }

    function selectConyuge(sel) {
        let element1 = document.getElementById("div_fecha_nacimiento_conyuge");
        let element2 = document.getElementById("fecha_nacimiento_conyuge");
        let element3 = document.getElementById("row_conjuge");
        let element4 = document.getElementById("select_jubilacion_conyuge");

        if (sel.value == "I") {
            element1.removeAttribute("hidden", "hidden");
            element3.removeAttribute("hidden", "hidden");
            element2.setAttribute("required", "");
            element4.setAttribute("required", "");
        } else {
            element1.setAttribute("hidden", "hidden");
            element3.setAttribute("hidden", "hidden");
            element2.removeAttribute("required", "");
            element4.removeAttribute("required", "");
        }
    }

    function selectJubilacionConyuge(sel) {
        let element1 = document.getElementById("div_ano_jubilacion_conyuge");
        let element2 = document.getElementById("ano_jubilacion_conyuge");
        let element3 = document.getElementById("div_porcentaje_renta_conyuge");
        let element4 = document.getElementById("porcentaje_renta_conyuge");

        if (sel.value == "I") {
            element1.removeAttribute("hidden", "hidden");
            element3.removeAttribute("hidden", "hidden");
            element2.setAttribute("required", "");
            element4.setAttribute("required", "");
        } else {
            element1.setAttribute("hidden", "hidden");
            element3.setAttribute("hidden", "hidden");
            element2.removeAttribute("required", "");
            element4.removeAttribute("required", "");
        }
    }

    function editarCorriente(id) {
        var base_path = '{{ url('/') }}';
        $.ajax({
            url: base_path + "/brujula/" + id + "/edit_corrientes",
            method: 'GET',
            success: function(data) {

                if (data.vistaBrujulaCorriente.id_tipo_monto == 1) {
                    var selected1 = 'selected';
                    var selected2 = '';
                } else {
                    var selected1 = '';
                    var selected2 = 'selected';
                }

                html = '<option value="">Seleccione una opción</option>';
                html += '<option value="I" ' + selected1 + '>Valor Futuro</option>';
                html += '<option value="O" ' + selected2 + '>Valor Actual</option>';


                var vistaCategoriaIngreso = data.vistaCategoriaIngresos;
                var id_user = @json(auth()->id());
                var option = '';
                var html_option = '';

                for (var i = 0; i < vistaCategoriaIngreso.length; ++i) {

                    option = '<option value="' + vistaCategoriaIngreso[i].id + '">';
                    option += vistaCategoriaIngreso[i].categoria + '--2</option>';

                    if (vistaCategoriaIngreso[i].plantilla == 1) {
                        html_option += option;
                    }

                    if (vistaCategoriaIngreso[i].id_user == id_user) {
                        html_option += option;
                    }
                }

                if (data.vistaBrujulaCorriente.tipo == 1) {
                    $('#tipo_monto').html(html);
                    $('#categoria').html(html_option);

                    document.getElementById("tipo_corriente").value = data.vistaBrujulaCorriente.tipo;
                    document.getElementById("id_brujula_corriente").value = data.vistaBrujulaCorriente
                        .id;
                    document.getElementById("cuenta").value = data.vistaBrujulaCorriente.cuenta;
                    document.getElementById("ano_inicio").value = data.vistaBrujulaCorriente.ano_inicio;
                    document.getElementById("ano_culminacion").value = data.vistaBrujulaCorriente
                        .ano_culminacion;
                    document.getElementById("monto").value = data.vistaBrujulaCorriente.monto;
                    document.getElementById("coeficiente_crecimiento").value = data
                        .vistaBrujulaCorriente
                        .coeficiente_crecimiento;
                } else {
                    $('#tipo_monto_egreso').html(html);
                    $('#categoria_egreso').html(html_option);

                    document.getElementById("tipo_corriente_egreso").value = data.vistaBrujulaCorriente
                        .tipo;
                    document.getElementById("id_brujula_corriente_egreso").value = data
                        .vistaBrujulaCorriente
                        .id;
                    document.getElementById("cuenta_egreso").value = data.vistaBrujulaCorriente.cuenta;
                    document.getElementById("ano_inicio_egreso").value = data.vistaBrujulaCorriente
                        .ano_inicio;
                    document.getElementById("ano_culminacion_egreso").value = data.vistaBrujulaCorriente
                        .ano_culminacion;
                    document.getElementById("monto_egreso").value = data.vistaBrujulaCorriente.monto;
                    document.getElementById("coeficiente_crecimiento_egreso").value = data
                        .vistaBrujulaCorriente
                        .coeficiente_crecimiento;
                }


            }
        });
    }

    function destroyCorriente(id) {
        var base_path = '{{ url('/') }}';
        $.ajax({
            url: base_path + "/brujula/" + id + "/delete_corrientes",
            method: 'GET',
            success: function(data) {
                cargarTablaCorriente(data);
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

    function borrarCorriente(id) {
        Swal.fire({
            title: '¿Esta seguro de eliminar el registro?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Si',
            denyButtonText: `No`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                destroyCorriente(id);
            } else if (result.isDenied) {}
        })
    }

    function editarInversiones(id) {
        var base_path = '{{ url('/') }}';
        $.ajax({
            url: base_path + "/brujula/" + id + "/edit_inversiones",
            method: 'GET',
            success: function(data) {

                if (data.brujulaInversiones.tipo == 1) {

                    document.getElementById("id_brujula_inversion").value = data.brujulaInversiones.id;
                    document.getElementById("cuenta_inversion").value = data.brujulaInversiones.cuenta;
                    document.getElementById("ano_inicio_inversion").value = data.brujulaInversiones
                        .ano_inicio;
                    document.getElementById("ano_culminacion_inversion").value = data.brujulaInversiones
                        .ano_culminacion;

                    if (data.brujulaInversiones.id_tipo_capital == 1) {
                        var selected1 = 'selected';
                        var selected2 = '';
                    } else {
                        var selected1 = '';
                        var selected2 = 'selected';
                    }

                    html = '<option value="">Seleccione una opción</option>';
                    html += '<option value="I" ' + selected1 + '>Valor Futuro</option>';
                    html += '<option value="O" ' + selected2 + '>Valor Actual</option>';
                    $('#tipo_capital').html(html);

                    document.getElementById("capital").value = data.brujulaInversiones.capital;
                    document.getElementById("interes_anual").value = data.brujulaInversiones
                        .porcentaje_interes_anual;

                    if (data.brujulaInversiones.tiene_devolucion_capital == 1) {
                        var selected1 = 'selected';
                        var selected2 = '';
                    } else {
                        var selected1 = '';
                        var selected2 = 'selected';
                    }

                    html = '<option value="">Seleccione una opción</option>';
                    html += '<option value="I" ' + selected1 + '>Si Aplica</option>';
                    html += '<option value="O" ' + selected2 + '>No Aplica</option>';
                    $('#devolucion_capital').html(html);

                    document.getElementById("coeficiente_crecimiento_inversion").value = data
                        .brujulaInversiones
                        .coeficiente_crecimiento;
                } else {

                    document.getElementById("id_brujula_prestamo").value = data.brujulaInversiones.id;
                    document.getElementById("cuenta_prestamo").value = data.brujulaInversiones.cuenta;
                    document.getElementById("ano_inicio_prestamo").value = data.brujulaInversiones
                        .ano_inicio;
                    document.getElementById("ano_culminacion_prestamo").value = data.brujulaInversiones
                        .ano_culminacion;

                    if (data.brujulaInversiones.id_tipo_capital == 1) {
                        var selected1 = 'selected';
                        var selected2 = '';
                    } else {
                        var selected1 = '';
                        var selected2 = 'selected';
                    }

                    html = '<option value="">Seleccione una opción</option>';
                    html += '<option value="I" ' + selected1 + '>Valor Futuro</option>';
                    html += '<option value="O" ' + selected2 + '>Valor Actual</option>';
                    $('#tipo_capital_prestamo').html(html);

                    document.getElementById("capital_prestamo").value = data.brujulaInversiones.capital;
                    document.getElementById("interes_anual_prestamo").value = data.brujulaInversiones
                        .porcentaje_interes_anual;
                }
            }
        });
    }

    function destroyInversiones(id) {
        var base_path = '{{ url('/') }}';
        $.ajax({
            url: base_path + "/brujula/" + id + "/delete_inversiones",
            method: 'GET',
            success: function(data) {
                cargarTablaInversiones(data);
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

    function borrarInversiones(id) {
        Swal.fire({
            title: '¿Esta seguro de eliminar el registro?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Si',
            denyButtonText: `No`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                destroyInversiones(id);
            } else if (result.isDenied) {}
        })
    }

    function editarCoeficientes(id) {
        var base_path = '{{ url('/') }}';
        $.ajax({
            url: base_path + "/brujula/" + id + "/edit_coeficientes",
            method: 'GET',
            success: function(data) {

                document.getElementById("id_brujula_coeficiente").value = data.vistaBrujulaCoeficientes.id;

                if (data.vistaBrujulaCoeficientes.id_valor_calculo == 1) {
                    var selected1 = 'selected';
                    var selected2 = '';
                } else {
                    var selected1 = '';
                    var selected2 = 'selected';
                }

                html = '<option value="">Seleccione una opción</option>';
                html += '<option value="I" ' + selected1 + '>Personalizado</option>';
                html += '<option value="O" ' + selected2 + '>Determinado por el Sistema</option>';

                $('#valor_calculo').html(html);

                document.getElementById("valor_personalizado").value = data.vistaBrujulaCoeficientes
                    .valor_usuario;
                document.getElementById("informacion_adicional").value = data.vistaBrujulaCoeficientes
                    .informacion_adicional;
            }
        });
    }

    function destroyCoeficientes(id) {
        var base_path = '{{ url('/') }}';
        $.ajax({
            url: base_path + "/brujula/" + id + "/delete_coeficientes",
            method: 'GET',
            success: function(data) {
                cargarTablaCoeficiente(data);
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

    function borrarCoeficientes(id) {
        Swal.fire({
            title: '¿Esta seguro de eliminar el registro?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Si',
            denyButtonText: `No`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                destroyCoeficientes(id);
            } else if (result.isDenied) {}
        })
    }
</script>
