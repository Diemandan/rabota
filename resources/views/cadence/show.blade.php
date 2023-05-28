@extends('layouts.app')

@section('content')

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
        <h2>Оплата в сутки: <span class="badge bg-primary">{{ $cadence->daily_rate }} евро</span></h2>

        <h4>Всего переведено за эту каденцию:
            <span class="badge bg-info"> {{$cadence->totalAmount}} евро
            </span>
        </h4>
        <hr>

        <h3>Начисления</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Дата</th>
                <th>Сумма в евро</th>
            </tr>
            </thead>
            <tbody>
            @if(!$cadence->salaries->isEmpty())

                @foreach($cadence->salaries as $salary)
                    <tr>

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


        <a href="{{ route('cadences.index') }}" class="btn btn-primary mb-3 mt-3">Back</a>

    </div>
@endsection
