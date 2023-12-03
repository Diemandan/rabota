<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadence PDF report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mt-5">
    <h6 class="table table-secondary table-striped">Каденция период: с {{$cadence->start}} по {{$cadence->finish}}</h6>

    <h6 class="table-success" style="color: green;">Отработано : {{ $cadence->totalDays }} дней</h6>

    <h6 class="table-info" style="color: darkblue;">Всего переведено: {{$cadence->totalAmount}} euro

    </h6>

    <h6 class="table-warning" style="color: darkred;">Остаток на начало каденции: {{$cadence->startDebt}} euro

    </h6>

    <h5 class="table-danger" style="color: darkred;">Всего остаток на данный момент: {{$cadence->totalBalance}} euro
    </h5>


    <h6>Переводы</h6>
    <table class="table table-sm  table-secondary table-striped text-center"
           style="font-family: DejaVu Sans, sans-serif;">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th>Дата</th>
            <th>Сумма в euro</th>
        </tr>
        </thead>
        <tbody>

        @foreach($cadence->salaries as $salary)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td>{{ $salary->transfer_date }}</td>
                <td>{{ $salary->transfer_amount }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>

    <h5>Покупки за наличные</h5>
    <table class="table table-sm table-secondary table-striped text-center"
           style="font-family: DejaVu Sans, sans-serif;">
        <thead>
        <tr>
            <th scope="row">#</th>
            <th>Дата</th>
            <th>Сумма в euro</th>
            <th>Описание</th>
        </tr>
        </thead>
        <tbody>

        @if ($cadence->expenses->isEmpty())
            <td></td>
            <td>Покупок не было</td>
        @else
            @foreach($cadence->expenses as $expense)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ $expense->payment_date }}</td>
                    <td>{{ $expense->payment_amount }}</td>
                    <td>{{ $expense->description }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
