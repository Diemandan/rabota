@extends('layouts.app')

@section('content')

    <div style="display: flex; justify-content: space-around;">

        <div style="width: 300px; margin: 0 auto;">
            @php
                $days = $totalStatistic['totalDays'];
                $earnings = $totalStatistic['totalSalary'];
            @endphp

            <div style="display: flex; margin-bottom: 10px;">
                <div style="background-color: blue; width: {{ $days }}px;">&nbsp;</div>
            </div>

            <div>Дней с начала года:{{ $days }} </div>
        </div>

        <div style="width: 300px; margin: 0 auto;">
            <div style="display: flex; margin-bottom: 10px;">
                <div style="background-color: green; width: {{ $earnings }}px;">&nbsp;</div>
            </div>

            <div>Заработано с начала года: {{ $earnings }} евро</div>
        </div>

        <div style="width: 300px; margin: 0 auto;">
            <div style="display: flex; margin-bottom: 10px;">
                <div style="background-color: orange; width: {{ ($earnings / $days * 30) }}px;">&nbsp;</div>
            </div>

            <div>Средний заработок в месяц: {{ round(($earnings / $days * 30), 2) }}euro</div>
            <br>
        </div>
    </div>


@endsection
