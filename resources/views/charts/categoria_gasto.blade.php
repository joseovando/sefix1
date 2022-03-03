@extends('layouts.app', ['activePage' => 'Graficos', 'titlePage' => __('Graficas')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <canvas id="chart-envios" style="display: block; width: 100%; height: 600px">

            </canvas>
        </div>
    </div>
</div>
@endsection

@push('js')
{{-- <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
</script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        const cData = JSON.parse(`<?php echo $data; ?>`);
        /*  console.log(cData); */
        var ctx = $("#chart-envios");

        const data = {
            labels: cData.label,
            datasets: [{
                label: 'Dristribución de Gasto por Categoria',
                data: cData.data,
                backgroundColor: [
                    "#DEB887",
                    "#A9A9A9",
                    "#DC143C",
                    "#F4A460",
                    "#2E8B57",
                    "#1D7A46",
                    "#CDA776",
                ],
                borderColor: [
                    "#CDA776",
                    "#989898",
                    "#CB252B",
                    "#E39371",
                    "#1D7A46",
                    "#F4A460",
                    "#CDA776",
                ],
                borderWidth: 1
            }]
        };

        const stackedBar = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });




    });
</script>
@endpush