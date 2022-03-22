$(function () {
    $('#_categoria').on('change', onSelectCategriaChange);
});

function onSelectCategriaChange() {
    var categoria_id = $(this).val();

    // AJAX
    $.get('/api/subcategorias/' + categoria_id, function (data) {
        var html_select = '<option value="">Seleccione Subcategoria</option>';
        for (var i = 0; i < data.length; ++i) {
            html_select += '<option value="' + data[i].id + '">' + data[i].categoria + '</option>';
        }
        $('#_subcategoria').html(html_select);
    });

};
