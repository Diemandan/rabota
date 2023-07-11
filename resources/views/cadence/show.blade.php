@extends('layouts.app')

@section('content')
    <a class="btn btn-primary" href="{{ route('cadence.exportPdf', $cadence->id) }}">Export to PDF</a>
    @if($cadence->status_finish)
        <div class="alert alert-danger" role="alert">
            <h4>Каденция завершена</h4>
        </div>
    @else
        <div class="alert alert-success" role="alert">
            <h4>Ещё пока на работе</h4>
        </div>
    @endif

    <div class="container">
        <h2>Начало: <span class="badge bg-primary">{{ $cadence->start }}</span></h2>
        <h2>Конец: <span class="badge bg-primary">{{ $cadence->finish }}</span></h2>
        <h2>Отработано за каденцию: <span class="badge bg-primary">{{ $cadence->totalDays }} дней</span></h2>

        <h4>Всего переведено за эту каденцию:
            <span class="badge bg-info"> {{$cadence->totalAmount}} евро
            </span>
        </h4>

        <h3>Остаток на начало каденции:
            <span class="badge bg-success"> {{$cadence->startDebt}} евро
            </span>
        </h3>

        <h4>Всего остаток:
            <span class="badge bg-danger"> {{$cadence->totalBalance}} евро
            </span>
        </h4>
        <hr>

        <h3>Начисления</h3>
        <table class="table table-secondary table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th>Дата</th>
                <th>Сумма в евро</th>
            </tr>
            </thead>
            <tbody>
            @if(!$cadence->salaries->isEmpty())

                @foreach($cadence->salaries as $salary)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $salary->transfer_date }}</td>
                        <td>{{ $salary->transfer_amount }}</td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Зарплата еще не начислялась за эту каденцию</td>
                </tr>
            @endif
            </tbody>
        </table>

        <h3>Покупки за свои</h3>
        <table class="table table-secondary table-striped">
            <thead>
            <tr>
                <th scope="row">#</th>
                <th>Дата</th>
                <th>Сумма в евро</th>
                <th>Описание</th>
            </tr>
            </thead>
            <tbody>
            @if(!$cadence->expenses->isEmpty())

                @foreach($cadence->expenses as $expense)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $expense->payment_date }}</td>
                        <td>{{ $expense->payment_amount }}</td>
                        <td>{{ $expense->description }}</td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Зарплата еще не начислялась за эту каденцию</td>
                </tr>
            @endif
            </tbody>
        </table>


        <a href="{{ route('cadences.index') }}" class="btn btn-primary mb-3 mt-3">Back</a>

    </div>
@endsection
