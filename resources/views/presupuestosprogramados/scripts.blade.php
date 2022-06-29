  <script>
      $(document).ready(function() {
          $("#form_guardar_programado").validate();
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
  </script>

  <script type="text/javascript" class="init">
      $(document).ready(function() {
          $('#example').DataTable({
              scrollY: '50vh',
              scrollCollapse: true,
              paging: false,
              ordering: false,
              info: false,
              searching: false,
          });
      });
  </script>

  <script>
      $(function() {
          /* valores iniciales Storage */
          var valor_inicial = 0;
          localStorage.setItem("contador_search", valor_inicial);
          localStorage.setItem("contador_ajax", valor_inicial);
          localStorage.setItem("contador_adicional", valor_inicial);
          localStorage.setItem("id_categoria", @json($id));
          localStorage.setItem("mes_actual", @json($mes_actual));
          localStorage.setItem("ano_actual", @json($ano_actual));
          localStorage.setItem("llave_ajax", valor_inicial);
          localStorage.setItem("llave_ajax_temp", valor_inicial);
          localStorage.setItem("llave_search", valor_inicial);
          localStorage.setItem("total_search", valor_inicial);
          localStorage.setItem("llave_reload", valor_inicial);
          localStorage.setItem("cantidad_tr_search", valor_inicial);
          localStorage.setItem("llave_cambiar_fecha", valor_inicial);
          localStorage.setItem("vistaCategorias", JSON.stringify(""));
      });
  </script>

  <script>
      function nav(value) {
          if (value != "") {
              location.href = value;
          }
      }
  </script>

  <script type="text/javascript">
      $(document).ready(function() {
          $('#buscarCategoria').click(function(e) {
              e.preventDefault();

              var _token = $("input[name='_token']").val();
              var search = $("#autoComplete").val();
              var tipo = @json($tipo);
              var comercial = @json($comercial);
              var llave_form = 1;
              var llave_cambiar_fecha = parseInt(localStorage.getItem("llave_cambiar_fecha"));

              if (llave_cambiar_fecha == 1) {
                  var ano_actual = parseInt(localStorage.getItem("ano_actual"));
                  var mes_actual = parseInt(localStorage.getItem("mes_actual"));
              } else {
                  var ano_actual = $("#ano_actual").val();
                  var mes_actual = $("#mes_actual").val();
              }

              $.ajax({
                  url: "{{ route('presupuestosprogramados.search') }}",
                  type: 'POST',
                  data: {
                      _token: _token,
                      search: search,
                      tipo: tipo,
                      ano_actual: ano_actual,
                      mes_actual: mes_actual,
                      llave_form: llave_form,
                      comercial: comercial,
                  },
                  success: function(data) {

                      if (data.search_result == 1) {
                          localStorage.setItem("llave_search", 1);
                          localStorage.setItem("llave_ajax", 0);
                          localStorage.setItem("id_categoria", data.id_categoria);
                          localStorage.setItem("cantidad_tr_search", 1);
                          localStorage.setItem("total_search", data.monto);
                          let element = document.getElementById("boton_activar_categorias");
                          element.setAttribute("hidden", "hidden");
                          let element2 = document.getElementById("reloadCategoria");
                          element2.removeAttribute("hidden", "hidden");

                          totalProgramado();
                          cargarTabla(data);
                      } else {
                          Swal.fire({
                              position: 'top-end',
                              icon: 'error',
                              title: 'Ningun registro encontrado, intente la busqueda de nuevo',
                              showConfirmButton: false,
                              timer: 4000
                          })
                      }
                  }
              });
          });

          $('#cambiar_mes_programado').click(function(e) {

              e.preventDefault();

              Swal.fire({
                  title: '¿Esta seguro de cambiar mes programado?',
                  showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: 'Si',
                  denyButtonText: `No`,
              }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {

                      var _token = $("input[name='_token']").val();
                      var ano_actual = $("#ano_actual").val();
                      var mes_actual = $("#mes_actual").val();
                      var llave_form = 1;
                      var tipo = @json($tipo);
                      var comercial = @json($comercial);
                      var llave_ajax = parseInt(localStorage.getItem("llave_ajax"));
                      var llave_search = parseInt(localStorage.getItem("llave_search"));
                      var id_categoria = @json($id);

                      if (llave_ajax == 1) {
                          var id_categoria = parseInt(localStorage.getItem("id_categoria"));
                      }

                      if (llave_search == 1) {
                          var id_categoria = parseInt(localStorage.getItem("id_categoria"));
                      }

                      $.ajax({
                          url: "{{ route('presupuestosprogramados.cambiar_fecha') }}",
                          type: 'POST',
                          data: {
                              _token: _token,
                              ano_actual: ano_actual,
                              mes_actual: mes_actual,
                              llave_form: llave_form,
                              tipo: tipo,
                              comercial: comercial,
                              id_categoria: id_categoria
                          },
                          success: function(data) {

                              localStorage.setItem("mes_actual", data.mes_actual);
                              localStorage.setItem("ano_actual", data.ano_actual);
                              localStorage.setItem("llave_cambiar_fecha", 1);

                              totalProgramado();
                              cargarTabla(data);
                          }
                      });

                  } else if (result.isDenied) {}
              })
          });

          $("#select_categoria").on("change", function() {
              Swal.fire({
                  title: '¿Esta seguro de cambiar de Categoria?',
                  showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: 'Si',
                  denyButtonText: `No`,
              }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {

                      var _token = $("input[name='_token']").val();
                      var llave_cambiar_fecha = parseInt(localStorage.getItem(
                          "llave_cambiar_fecha"));

                      if (llave_cambiar_fecha == 1) {
                          var ano_actual = parseInt(localStorage.getItem("ano_actual"));
                          var mes_actual = parseInt(localStorage.getItem("mes_actual"));
                      } else {
                          var ano_actual = $("#ano_actual").val();
                          var mes_actual = $("#mes_actual").val();
                      }

                      var llave_form = 1;
                      var tipo = @json($tipo);
                      var comercial = @json($comercial);
                      var id_categoria = $("#select_categoria").val();

                      $.ajax({
                          url: "{{ route('presupuestosprogramados.cambiar_fecha') }}",
                          type: 'POST',
                          data: {
                              _token: _token,
                              ano_actual: ano_actual,
                              mes_actual: mes_actual,
                              llave_form: llave_form,
                              tipo: tipo,
                              comercial: comercial,
                              id_categoria: id_categoria
                          },
                          success: function(data) {
                              localStorage.setItem("llave_ajax", 1);
                              localStorage.setItem("llave_search", 0);
                              localStorage.setItem("id_categoria", data.id_categoria);
                              localStorage.setItem("vistaCategorias",
                                  JSON.stringify(data.vistaCategorias));

                              totalProgramado();
                              cargarTabla(data);
                              cambiarActivarCategoria(data);
                          }
                      });

                  } else if (result.isDenied) {}
              })
          });

          function cargarTabla(data) {

              var cantidad_tr = @json($cantidad_tr);
              var id_categoria_array = data.id_categoria_array;
              var categoria_name = data.categoria_name;
              var categoria_plantilla = data.categoria_plantilla;
              var categoria_user = data.categoria_user;
              var subcategoria_favorita_array = data.subcategoria_favorita_array;
              var id_user = @json(auth()->id());
              var id_ingreso_programado = data.id_ingreso_programado;
              var monto = data.monto;
              var id_frecuencia = data.id_frecuencia;
              var caducidad = data.caducidad;
              var fecha_inicio = data.fecha_inicio;
              var fecha_fin = data.fecha_fin;
              var llave_ajax = parseInt(localStorage.getItem("llave_ajax"));
              var llave_search = parseInt(localStorage.getItem("llave_search"));
              var llave_reload = parseInt(localStorage.getItem("llave_reload"));

              /* ocultar categorias iniciales */
              if (llave_ajax == 1 || llave_search == 1 || llave_reload == 1) {
                  for (var j = 0; j < cantidad_tr; ++j) {

                      var tr = "tr_" + j;
                      let element_exist = !!document.getElementById(tr);
                      let element = document.getElementById(tr);

                      if (element_exist == true) {
                          element.setAttribute("hidden", "hidden");
                      }
                  }
              }

              if (llave_search == 1) {
                  cantidad_tr = parseInt(localStorage.getItem("cantidad_tr_search"));
              }

              for (var i = 0; i < cantidad_tr; ++i) {

                  input_id_inicial = "id_" + i;
                  input_monto_inicial = "monto_" + i;
                  input_frecuencia_inicial = "frecuencia_" + i;
                  input_sin_caducidad_inicial = "sin_caducidad_" + i;
                  input_inicio_inicial = "inicio_" + i;
                  input_fin_inicial = "fin_" + i;
                  div_inicial = "div_" + i;
                  div2_inicial = "div2_" + i;
                  input_categoria_name = "#categoria_name_" + i + " span";

                  /* resetear categorias inicial */
                  let element_exist = !!document.getElementById(input_id_inicial);
                  if (element_exist == true) {
                      document.getElementById(input_id_inicial).value = '';
                      document.getElementById(input_monto_inicial).value = '';
                      document.getElementById(input_monto_inicial).removeAttribute("required");
                      document.getElementById(input_frecuencia_inicial).value = '';
                      document.getElementById(input_frecuencia_inicial).removeAttribute("required");
                      document.getElementById(input_sin_caducidad_inicial).checked = false;
                      document.getElementById(input_sin_caducidad_inicial).removeAttribute("required");
                      document.getElementById(input_inicio_inicial).value = '';
                      document.getElementById(input_inicio_inicial).removeAttribute("required");
                      document.getElementById(input_fin_inicial).value = '';
                      document.getElementById(input_fin_inicial).removeAttribute("required");
                      document.getElementById(div_inicial).style.display = 'initial';
                      document.getElementById(div2_inicial).style.display = 'initial';
                  }

                  /* cargar subcategorias cambiadas */
                  if (llave_ajax == 1 || llave_reload == 1) {
                      $(input_categoria_name).text(categoria_name[i]);

                      /* ocultar subcategorias favoritas */
                      if (id_categoria_array[i] != subcategoria_favorita_array[i]) {
                          var tr = "tr_" + i;
                          element_exist = !!document.getElementById(tr);
                          element = document.getElementById(tr);

                          if (element_exist == true) {
                              element.removeAttribute("hidden", "hidden");
                          }
                      }
                  }

                  if (llave_search == 1) {
                      if (id_categoria_array[i] > 0) {
                          $(input_categoria_name).text(categoria_name[i]);
                          var tr = "tr_" + i;
                          element_exist = !!document.getElementById(tr);
                          element = document.getElementById(tr);

                          if (element_exist == true) {
                              element.removeAttribute("hidden", "hidden");
                          }
                      }
                  }

                  if (categoria_plantilla[i] == 1) {

                      if (monto[i] > 0) {

                          /* cargar data a categoria */
                          document.getElementById(input_id_inicial).value = id_ingreso_programado[i];
                          document.getElementById(input_monto_inicial).value = monto[i];
                          document.getElementById(input_frecuencia_inicial).value = id_frecuencia[i];
                          document.getElementById(input_sin_caducidad_inicial).value = caducidad[i];

                          if (caducidad[i] == 1) {
                              document.getElementById(input_sin_caducidad_inicial).checked = true;
                          }

                          document.getElementById(input_inicio_inicial).value = momentSet(fecha_inicio[i]);
                          document.getElementById(input_fin_inicial).value = momentSet(fecha_fin[i]);

                          /* reglas de validacion */
                          if (id_frecuencia[i] == 1) {
                              document.getElementById(input_inicio_inicial).setAttribute("required", "");
                              document.getElementById(div_inicial).style.display = 'none';
                              document.getElementById(input_fin_inicial).removeAttribute("required");
                              document.getElementById(div2_inicial).style.display = 'none';
                              document.getElementById(input_sin_caducidad_inicial).removeAttribute(
                                  "required");
                          }

                          if (id_frecuencia[i] > 1) {
                              document.getElementById(input_inicio_inicial).setAttribute("required", "");
                              document.getElementById(div_inicial).style.display = 'initial';
                              document.getElementById(input_fin_inicial).setAttribute("required", "");
                              document.getElementById(div2_inicial).style.display = 'initial';
                          }

                          if (caducidad[i] == 1) {
                              document.getElementById(div_inicial).style.display = 'none';
                              document.getElementById(input_fin_inicial).removeAttribute("required");
                          }
                      } else {
                          let element_exist = !!document.getElementById(input_monto_inicial);

                          if (element_exist == true) {
                              document.getElementById(input_monto_inicial).value = ''
                          }
                      }
                  }

                  if (categoria_user[i] == id_user) {

                      if (monto[i] > 0) {

                          /* cargar data a categoria */
                          document.getElementById(input_id_inicial).value = id_ingreso_programado[i];
                          document.getElementById(input_monto_inicial).value = monto[i];
                          document.getElementById(input_frecuencia_inicial).value = id_frecuencia[i];
                          document.getElementById(input_sin_caducidad_inicial).value = caducidad[i];

                          if (caducidad[i] == 1) {
                              document.getElementById(input_sin_caducidad_inicial).checked = true;
                          }

                          document.getElementById(input_inicio_inicial).value = momentSet(fecha_inicio[i]);
                          document.getElementById(input_fin_inicial).value = momentSet(fecha_fin[i]);

                          /* reglas de validacion */
                          if (id_frecuencia[i] == 1) {
                              document.getElementById(input_inicio_inicial).setAttribute("required", "");
                              document.getElementById(div_inicial).style.display = 'none';
                              document.getElementById(input_fin_inicial).removeAttribute("required");
                              document.getElementById(div2_inicial).style.display = 'none';
                              document.getElementById(input_sin_caducidad_inicial).removeAttribute(
                                  "required");
                          }

                          if (id_frecuencia[i] > 1) {
                              document.getElementById(input_inicio_inicial).setAttribute("required", "");
                              document.getElementById(div_inicial).style.display = 'initial';
                              document.getElementById(input_fin_inicial).setAttribute("required", "");
                              document.getElementById(div2_inicial).style.display = 'initial';
                          }

                          if (caducidad[i] == 1) {
                              document.getElementById(div_inicial).style.display = 'none';
                              document.getElementById(input_fin_inicial).removeAttribute("required");
                          }
                      } else {
                          let element_exist = !!document.getElementById(input_monto_inicial);

                          if (element_exist == true) {
                              document.getElementById(input_monto_inicial).value = ''
                          }
                      }
                  }
              }
          }

          function cambiarActivarCategoria(data) {
              var id_categoria_array = data.id_categoria_array;
              var categoria_plantilla = data.categoria_plantilla;
              var categoria_user = data.categoria_user;
              var id_user = @json(auth()->id());
              var vistaCategoria = data.vistaCategorias;
              var subcategoria_favorita_array = data.subcategoria_favorita_array;
              var li = '';

              for (var i = 0; i < vistaCategoria.length; ++i) {

                  if (categoria_plantilla[i] == 1) {

                      li += '<li class = "list-group-item">';
                      li += '<input type = "checkbox" class = "form-check-input"';
                      li += 'name = "check_' + vistaCategoria[i].id + '" ';
                      li += 'id = "check_' + vistaCategoria[i].id + '" ';

                      if (vistaCategoria[i].id != subcategoria_favorita_array[i]) {
                          li += ' checked';
                      }

                      li += '>' + vistaCategoria[i].categoria + '</li>';
                  }

                  if (categoria_user[i] == id_user) {

                  }
              }

              $('#ul_activar_categoria').html(li);

          }

          $('#activarCategoria').click(function(e) {
              e.preventDefault();
              var _token = $("input[name='_token']").val();
              var llave_ajax = parseInt(localStorage.getItem("llave_ajax"));

              if (llave_ajax == 1) {
                  var vistaCategoria = JSON.parse(localStorage.getItem("vistaCategorias"));
              } else {
                  var vistaCategoria = @json($vistaCategorias);
              }

              var check_categorias = [];

              for (var i in vistaCategoria) {
                  var check = "check_" + vistaCategoria[i].id;
                  check_categorias[vistaCategoria[i].id] = document.getElementById(check).checked;
              }

              $.ajax({
                  url: "{{ route('presupuestosprogramados.activar_categorias') }}",
                  type: 'POST',
                  data: {
                      _token: _token,
                      vistaCategoria: vistaCategoria,
                      check_categorias: check_categorias,
                  },
                  success: function(data) {
                      var arrayDisabled = data.arrayDisabled;

                      for (var i in vistaCategoria) {
                          activar_check = "#check_" + i;
                          tr = "tr_" + i;
                          let element = document.getElementById(tr);
                          if (arrayDisabled[vistaCategoria[i].id] == 1) {
                              element.setAttribute("hidden", "hidden");
                          } else {
                              element.removeAttribute("hidden", "hidden");
                          }
                      }

                      totalProgramado();
                      printMsg(data);
                  }
              });
          });

          $('#reloadCategoria').click(function(e) {

              e.preventDefault();
              var _token = $("input[name='_token']").val();
              var llave_form = 1;
              var tipo = @json($tipo);
              var comercial = @json($comercial);
              var llave_cambiar_fecha = parseInt(localStorage.getItem("llave_cambiar_fecha"));
              var llave_ajax_temp = parseInt(localStorage.getItem("llave_ajax_temp"));
              localStorage.setItem("llave_ajax", llave_ajax_temp);
              var llave_ajax = parseInt(localStorage.getItem("llave_ajax"));
              var llave_search = parseInt(localStorage.getItem("llave_search"));

              if (llave_cambiar_fecha == 1) {
                  var ano_actual = parseInt(localStorage.getItem("ano_actual"));
                  var mes_actual = parseInt(localStorage.getItem("mes_actual"));
              } else {
                  var ano_actual = $("#ano_actual").val();
                  var mes_actual = $("#mes_actual").val();
              }

              if (llave_ajax == 1) {
                  var id_categoria = parseInt(localStorage.getItem("id_categoria"));
              } else {
                  var id_categoria = @json($id);
              }

              $.ajax({
                  url: "{{ route('presupuestosprogramados.cambiar_fecha') }}",
                  type: 'POST',
                  data: {
                      _token: _token,
                      ano_actual: ano_actual,
                      mes_actual: mes_actual,
                      llave_form: llave_form,
                      tipo: tipo,
                      comercial: comercial,
                      id_categoria: id_categoria
                  },
                  success: function(data) {

                      localStorage.setItem("llave_search", 0);
                      localStorage.setItem("llave_reload", 1);
                      let element = document.getElementById("boton_activar_categorias");
                      let element2 = document.getElementById("reloadCategoria");
                      element2.setAttribute("hidden", "hidden");
                      element.removeAttribute("hidden", "hidden");

                      totalProgramado();
                      cargarTabla(data);
                  }
              });

          });
      });
  </script>

  <script>
      function desactivarCategoria(id) {
          var check = "check_" + parseInt(id);
          var tr = "tr_" + parseInt(id);
          var categoria_id = $("#id_categoria_" + parseInt(id)).val();
          var activar_check = "#check_" + categoria_id;
          let element = document.getElementById(tr);
          element.setAttribute("hidden", "hidden");
          $(activar_check).prop("checked", false);

          if (document.getElementById(check).checked == false) {
              var base_path = '{{ url('/') }}';
              $.ajax({
                  url: base_path + "/presupuestosprogramados/" + categoria_id +
                      "/desactivar_categorias",
                  method: 'GET',
                  success: function(data) {

                  }
              });
          }
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

      $('#form_guardar_programado').validate({
          submitHandler: function(form) {

              var _token = $("input[name='_token']").val();
              var tipo = @json($tipo);

              /* data categoria inicial */
              var id_inicial = [];
              var categoria_inicial = [0];
              var monto_inicial = [];
              var frecuencia_inicial = [];
              var sin_caducidad_inicial = [];
              var inicio_inicial = [];
              var fin_inicial = [];
              var llave_ajax = parseInt(localStorage.getItem("llave_ajax"));
              var llave_cambiar_fecha = parseInt(localStorage.getItem("llave_cambiar_fecha"));

              if (llave_cambiar_fecha == 1) {
                  var ano_actual = parseInt(localStorage.getItem("ano_actual"));
                  var mes_actual = parseInt(localStorage.getItem("mes_actual"));
              } else {
                  var ano_actual = $("#ano_actual").val();
                  var mes_actual = $("#mes_actual").val();
              }

              if (llave_ajax == 1) {
                  var vistaCategoriaInicial = JSON.parse(localStorage.getItem("vistaCategorias"));
              } else {
                  var vistaCategoriaInicial = @json($vistaCategorias);
              }

              for (var i = 0; i < vistaCategoriaInicial.length; ++i) {
                  var input = parseInt(i);
                  if (!!document.getElementById("monto_" + input) == true) {
                      categoria_inicial[i] = vistaCategoriaInicial[i].id;
                      id_inicial[i] = $("#id_" + input).val();
                      monto_inicial[i] = $("#monto_" + input).val();
                      frecuencia_inicial[i] = $("#frecuencia_" + input).val();
                      sin_caducidad_inicial[i] = document.getElementById("sin_caducidad_" + input).checked;
                      inicio_inicial[i] = momentGet($("#inicio_" + input).val());
                      fin_inicial[i] = momentGet($("#fin_" + input).val());
                  }
              }

              /* data categoria adicional */
              var categoria_adicional = [];
              var monto_adicional = [];
              var id_categoria_adicional = [];
              var id_adicional = [];
              var categoria_adicional = [];
              var monto_adicional = [];
              var frecuencia_adicional = [];
              var sin_caducidad_adicional = [];
              var inicio_adicional = [];
              var fin_adicional = [];
              var cantidad_tr = @json($cantidad_tr);
              var id_categoria = @json($id);
              var comercial = @json($comercial);

              for (var i = 0; i < cantidad_tr; ++i) {
                  id_categoria_adicional[i] = $("#id_categoria_adicional_" + i).val();;
                  id_adicional[i] = $("#id_adicional_" + i).val();;
                  categoria_adicional[i] = $("#subcategoria_adicional_" + i).val();
                  monto_adicional[i] = $("#monto_adicional_" + i).val();
                  frecuencia_adicional[i] = $("#frecuencia_adicional_" + i).val();
                  sin_caducidad_adicional[i] = document.getElementById("sin_caducidad_adicional_" +
                      i).checked;
                  inicio_adicional[i] = momentGet($("#inicio_adicional_" + i).val());
                  fin_adicional[i] = momentGet($("#fin_adicional_" + i).val());
              }

              $.ajax({
                  url: "{{ route('presupuestosprogramados.store') }}",
                  type: 'POST',
                  data: {
                      _token: _token,
                      tipo: tipo,
                      categoria_inicial: categoria_inicial,
                      id_inicial: id_inicial,
                      monto_inicial: monto_inicial,
                      frecuencia_inicial: frecuencia_inicial,
                      sin_caducidad_inicial: sin_caducidad_inicial,
                      inicio_inicial: inicio_inicial,
                      fin_inicial: fin_inicial,
                      ano_actual: ano_actual,
                      mes_actual: mes_actual,

                      id_categoria_adicional: id_categoria_adicional,
                      id_adicional: id_adicional,
                      categoria_adicional: categoria_adicional,
                      monto_adicional: monto_adicional,
                      frecuencia_adicional: frecuencia_adicional,
                      sin_caducidad_adicional: sin_caducidad_adicional,
                      inicio_adicional: inicio_adicional,
                      fin_adicional: fin_adicional,
                      id_categoria: id_categoria,
                      comercial: comercial,
                      cantidad_tr: cantidad_tr,
                  },
                  success: function(data) {
                      totalProgramado();
                      cargarTablaAdicional(data);
                      console.log(data);
                      printMsg(data);
                  }
              });

          }
      });

      function cargarTablaAdicional(data) {
          var nueva_categoria_id = data.nueva_categoria_id;
          var categoria_adicional = data.categoria_adicional_id;

          for (var i = 0; i < nueva_categoria_id.length; ++i) {
              id_categoria_adicional = "id_categoria_adicional_" + i;
              id_adicional = "id_adicional_" + i

              document.getElementById(id_categoria_adicional).value = categoria_adicional[i];
              document.getElementById(id_adicional).value = nueva_categoria_id[i];
          }
      }

      function totalProgramado() {
          var _token = $("input[name='_token']").val();
          var llave_form = 1;
          var tipo = @json($tipo);
          var id_categoria = @json($id);
          var llave_cambiar_fecha = parseInt(localStorage.getItem("llave_cambiar_fecha"));
          var llave_ajax = parseInt(localStorage.getItem("llave_ajax"));
          var llave_search = parseInt(localStorage.getItem("llave_search"));
          var total_search = parseInt(localStorage.getItem("total_search"));

          if (llave_ajax == 1) {
              var id_categoria = parseInt(localStorage.getItem("id_categoria"));
          }

          if (llave_cambiar_fecha == 1) {
              var ano_actual = parseInt(localStorage.getItem("ano_actual"));
              var mes_actual = parseInt(localStorage.getItem("mes_actual"));
          } else {
              var ano_actual = $("#ano_actual").val();
              var mes_actual = $("#mes_actual").val();
          }

          if (llave_search == 0) {

              $.ajax({
                  url: "{{ route('presupuestosprogramados.total_programado') }}",
                  type: 'POST',
                  data: {
                      _token: _token,
                      ano_actual: ano_actual,
                      mes_actual: mes_actual,
                      llave_form: llave_form,
                      tipo: tipo,
                      id_categoria: id_categoria
                  },
                  success: function(data) {
                      $("#total_programado span").text(data.monto_total);
                  }
              });
          } else {
              $("#total_programado span").text(total_search);
          }
      }
  </script>

  <script>
      $(document).ready(function() {
          jQuery.extend(jQuery.validator.messages, {
              required: "<h4>Este campo es obligatorio.</h4>",
          });
      });
  </script>

  <script>
      $(document).on('click', '#addRowCategoria', function() {
          var tr_adicional = parseInt(localStorage.getItem("contador_adicional"));
          var tr_hidden = "tr_adicional_" + tr_adicional;
          let element = document.getElementById(tr_hidden);
          element.removeAttribute("hidden", "hidden");
          var neo_value = tr_adicional + 1;
          localStorage.setItem("contador_adicional", neo_value);
      });
  </script>
