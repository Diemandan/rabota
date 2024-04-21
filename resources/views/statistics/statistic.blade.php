@extends('layouts.app')

@section('content')

    @php
        if (isset($totalStatistic)) {
            $days = $totalStatistic['totalDays'];
            $earnings = $totalStatistic['totalSalary'];
            $lastYearDays = $totalStatistic['totalLastYearDays'];
            $lastYearEarnings = $totalStatistic['lastYearSalary'];
        }
    @endphp

    <div><button class="btn btn-primary custom-btn">Текущий год итоги</button></div>
    <br>
    <div style="display: flex; justify-content: space-around;">

        <div style="width: 300px; margin: 0 auto;">


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
<br>
<br>
    <div><button class="btn btn-primary custom-btn">Предыдущий год итоги</button></div>
    <br>
    <div style="display: flex; justify-content: space-around;">

        <div style="width: 300px; margin: 0 auto;">


            <div style="display: flex; margin-bottom: 10px;">
                <div style="background-color: blue; width: {{ $days }}px;">&nbsp;</div>
            </div>

            <div>Дней с начала года:{{ $lastYearDays }} </div>
        </div>

        <div style="width: 300px; margin: 0 auto;">
            <div style="display: flex; margin-bottom: 10px;">
                <div style="background-color: green; width: {{ $earnings }}px;">&nbsp;</div>
            </div>

            <div>Заработано с начала года: {{ $lastYearEarnings }} евро</div>
        </div>

        <div style="width: 300px; margin: 0 auto;">
            <div style="display: flex; margin-bottom: 10px;">
                <div style="background-color: orange; width: {{ ($earnings / $days * 30) }}px;">&nbsp;</div>
            </div>

            <div>Средний заработок в месяц: {{ round(($lastYearEarnings / $lastYearDays * 30), 2) }}euro</div>
            <br>
        </div>
    </div>

@endsection
