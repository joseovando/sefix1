@extends('layouts.app', ['activePage' => 'Graficos', 'titlePage' => __('Graficas')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <canvas id="pie-chart" width="800" height="450"></canvas>
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
        /*  console.log(cData); */
        var ctx = $("#pie-chart");

        new Chart(document.getElementById("pie-chart"), {
            type: 'pie',
            data: {
                labels: cData.label,
                datasets: [{
                    label: "Enero",
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850", "#DEB887", "#A9A9A9", "#DC143C"],
                    data: cData.data
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Distribucion del Gasto en Porcentaje de Febrero'
                }
            }
        });







    });
</script>
@endpush