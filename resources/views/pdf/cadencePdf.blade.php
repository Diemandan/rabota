<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadence PDF report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container mt-5">
    <h6 >Cadence period: {{$cadence->start}} - {{$cadence->finish}}</h6>

    <h64>Otrabotano : {{ $cadence->totalDays }} dnej</h64>

    <h6>Vsego perevedeno:  {{$cadence->totalAmount}} euro

    </h6>

    <h6>Ostatok na na4alo:  {{$cadence->startDebt}} euro

    </h6>

    <h5>Vsego ostatok na dannij moment:
        <span class="badge bg-danger"> {{$cadence->totalBalance}} euro
            </span>
    </h5>


    <h6>Perevody</h6>
    <table class="table table-secondary table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th>Date</th>
            <th>Summ in euro</th>
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

    <h5>Pokupki za nali4nye</h5>
    <table class="table table-secondary table-striped">
        <thead>
        <tr>
            <th scope="row">#</th>
            <th>date</th>
            <th>Summ in euro</th>
            <th>description</th>
        </tr>
        </thead>
        <tbody>

            @foreach($cadence->expenses as $expense)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ $expense->payment_date }}</td>
                    <td>{{ $expense->payment_amount }}</td>
                    <td>Pribor oplaty dorog Slovakiya</td>

                </tr>
            @endforeach
        </tbody>
    </table>

</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
