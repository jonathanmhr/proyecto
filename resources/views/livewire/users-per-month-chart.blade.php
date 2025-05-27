<div>
    {{-- Contenedor del gráfico --}}
    {!! $chart->container() !!}

    {{-- Script de ApexCharts CDN --}}
    <script src="{{ $chart->cdn() }}"></script>

    {{-- Script para renderizar el gráfico --}}
    {{ $chart->script() }}
</div>
