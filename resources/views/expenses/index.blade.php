@extends('layouts.app')

@section('content')

    <div class="container">


        <table class="table table-secondary table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Период каденции</th>
                <th scope="col">Сумма</th>
                <th scope="col">Дата перевода</th>
                <th scope="col">Описание</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($expenses as $expense)
                <tr>
                    <th scope="row">{{ $loop->index + ($expenses->perPage() * ($expenses->currentPage() - 1)) + 1 }}</th>
                    <td>с {{$expense->cadence->start}} по {{$expense->cadence->finish}}</td>
                    <td>{{$expense->payment_amount}}</td>
                    <td>{{$expense->payment_date}}</td>
                    <td>{{$expense->description}}</td>
                    <td>
                        <div class="d-flex flex-row bd-highlight mb-3">
                            <form action="{{ route('expense.delete', $expense->id) }}" method="POST"
                                  style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
@if($expenses->isEmpty())
<h3> Что-нибудь да купим ещё. Не переживай </h3>
@endif
        <div class="row mb-3">
            <div class="col-sm-6">
                <a href="{{ route('expense.create') }}" class="btn btn-primary">Создать запись</a>
            </div>
            <div class="pagination justify-content-center">
                {{ $expenses->links('pagination::bootstrap-4') }}
            </div>
        </div>

    </div>

@endsection
