@extends('layouts.app')

@section('content')

    <div class="container">


        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Период каденции</th>
                <th scope="col">Сумма</th>
                <th scope="col">Дата перевода</th>
            </tr>
            </thead>
            <tbody>

            @foreach($salaries as $salary)
                <tr>
                    <th scope="row">{{ $loop->index + ($salaries->perPage() * ($salaries->currentPage() - 1)) + 1 }}</th>
                    <td>с {{$salary->cadence->start}} по {{$salary->cadence->finish}}</td>
                    <td>{{$salary->transfer_amount}}</td>
                    <td>{{$salary->transfer_date}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row mb-3">
            <div class="col-sm-6">
                <a href="{{ route('salary.create') }}" class="btn btn-primary">Создать запись</a>
            </div>
            <div class="pagination justify-content-center">
                {{ $salaries->links('pagination::bootstrap-4') }}
            </div>
        </div>

    </div>

@endsection
