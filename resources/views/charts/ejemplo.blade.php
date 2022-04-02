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
    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
        $(document).ready(function() {
            const cData = JSON.parse(`<?php echo $data; ?>`);
            /*  console.log(cData); */
            var ctx = $("#chart-envios");

            const data = {
                labels: cData.label,
                datasets: [{
                    label: 'Dristribución de Gasto Vivienda por Mes',
                    data: cData.data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
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
