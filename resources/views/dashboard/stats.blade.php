@extends('layouts.layout-dashboard')

@section('stats')

    <div class="statistics-box">

        <h1>
            Le tue statistiche
        </h1>

        <h3>
            Visualizza i tuoi piatti più ordinati
        </h3>

        <div class="graph">
            {!! $chartjs1->render() !!}
        </div>

        <h3>
            Controlla le tue recensioni
        </h3>

        <div class="graph">
            {!! $chartjs2->render() !!}
        </div>

        <h3>
            Verifica le vendite del tuo anno con noi
        </h3>

        <div class="graph">
            {!! $chartjs3->render() !!}
        </div>

    </div>

@endsection