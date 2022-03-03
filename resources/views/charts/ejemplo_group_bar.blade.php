@extends('layouts.app', ['activePage' => 'Graficos', 'titlePage' => __('Graficas')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <canvas id="bar-chart-grouped" width="800" height="450"></canvas>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
    $(document).ready(function() {
        const cData = JSON.parse(`<?php echo $data; ?>`);
        console.log(cData);

        new Chart(document.getElementById("bar-chart-grouped"), {
            type: 'bar',
            data: {
                labels: cData.label,
                datasets: [{
                    label: "Programado",
                    backgroundColor: "#3e95cd",
                    data: cData.programado
                }, {
                    label: "Ejecutado",
                    backgroundColor: "#8e5ea2",
                    data: cData.ejecutado
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Gastos Transporte por Mes'
                }
            }
        });
    });
</script>
@endpush