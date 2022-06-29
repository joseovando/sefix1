<div id="div_reporte" hidden>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title">Relación Ingresos Egresos Anual</h4>
                <p class="card-category">{{ $mes_actual_text }}</p>
            </div>
            <div class="card-body table-responsive">
                <canvas id="bar-ingresos-egresos-anual" height=""></canvas>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> Actualizado al {{ $date }}
                </div>
            </div>
        </div>
    </div>
</div>
