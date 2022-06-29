<script type="text/javascript">
    window.onload = function() {
        var base_path = '{{ url('/') }}';
        var llaveswitch = localStorage.getItem("htmlswitch");

        if (llaveswitch == "checked") {
            var comercial = 1;
            $("#switch").prop('checked', true);
            var htmlSwitch = "<h4>&nbsp;&nbsp;Cuenta Comercial</h4>";
            $('#label_switch').html(htmlSwitch);
        } else {
            var comercial = 0;
            $("#switch").prop('checked', false);
            var htmlSwitch = "<h4>&nbsp;&nbsp;Cuenta Personal</h4>";
            $('#label_switch').html(htmlSwitch);
        }

        var href_ingreso_programado = base_path + "/categorias/1/" + comercial + "/0/index";
        $("#ingreso_programado").prop('href', href_ingreso_programado);
        var href_ingreso_ejecutado = base_path + "/categorias/2/" + comercial + "/0/index";
        $("#ingreso_ejecutado").prop('href', href_ingreso_ejecutado);
        var href_egreso_programado = base_path + "/categorias/3/" + comercial + "/0/index";
        $("#egreso_programado").prop('href', href_egreso_programado);
        var href_egreso_ejecutado = base_path + "/categorias/4/" + comercial + "/0/index";
        $("#egreso_ejecutado").prop('href', href_egreso_ejecutado);

        var href_categoria_tablero_categoria = base_path + "/categorias/" + comercial + "/tablero_categoria";
        $("#categoria_tablero_categoria").prop('href', href_categoria_tablero_categoria);
        var href_categoria_tablero = base_path + "/categorias/" + comercial + "/tablero";
        $("#categoria_tablero").prop('href', href_categoria_tablero);
    }

    function handleOnClick() {
        var base_path = '{{ url('/') }}';
        var llaveswitch = localStorage.getItem("htmlswitch");

        $.ajax({
            url: base_path + "/home/" + llaveswitch + "/switch",
            method: 'GET',
            success: function(data) {
                var comercial = data.comercial;

                if ($("#switch").prop('checked')) {
                    var htmlSwitch = "<h4>&nbsp;&nbsp;Cuenta Comercial</h4>";
                    localStorage.setItem("htmlswitch", "checked");
                    $('#label_switch').html(htmlSwitch);
                } else {
                    var htmlSwitch = "<h4>&nbsp;&nbsp;Cuenta Personal</h4>";
                    localStorage.setItem("htmlswitch", "unchecked");
                    $('#label_switch').html(htmlSwitch);
                }

                var href_ingreso_programado = base_path + "/categorias/1/" + comercial + "/0/index";
                $("#ingreso_programado").prop('href', href_ingreso_programado);
                var href_ingreso_ejecutado = base_path + "/categorias/2/" + comercial + "/0/index";
                $("#ingreso_ejecutado").prop('href', href_ingreso_ejecutado);
                var href_egreso_programado = base_path + "/categorias/3/" + comercial + "/0/index";
                $("#egreso_programado").prop('href', href_egreso_programado);
                var href_egreso_ejecutado = base_path + "/categorias/4/" + comercial + "/0/index";
                $("#egreso_ejecutado").prop('href', href_egreso_ejecutado);

                var href_categoria_tablero_categoria = base_path + "/categorias/" + comercial +
                    "/tablero_categoria";
                $("#categoria_tablero_categoria").prop('href', href_categoria_tablero_categoria);
                var href_categoria_tablero = base_path + "/categorias/" + comercial + "/tablero";
                $("#categoria_tablero").prop('href', href_categoria_tablero);

                window.location.replace("{{ route('home') }}");
            }
        });
    }
</script>
