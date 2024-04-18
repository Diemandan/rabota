@extends('layouts.app')

@section('content')
    <div class="container">

        <header class="d-flex flex-wrap justify-content-left py-3 mb-4 border-bottom">
            <p style="padding-right: 5px">Filter by status: </p>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="{{ route('budget.index') }}?all">Все</a>
                </li>
                @foreach ($months as $month)
                    <li class="nav-item">
                        <a style="padding-left: 10px"
                           href="{{ route('budget.index', ['month' => $month]) }}">{{ $month }}</a>
                    </li>
                @endforeach
            </ul>
        </header>

        <h4>Общая сумма планируемых расходов:
            <span class="badge bg-danger"> {{ $totalCashSum }} евро
            </span>
        </h4>
        <hr>

        <table class="table table-secondary table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Назначение</th>
                <th scope="col">Сумма</th>
                <th scope="col">Месяц траты</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($budgets as $budget)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td> {{ $budget->title }} </td>
                    <td>{{ $budget->cash }}</td>
                    <td>{{ $budget->month }}</td>
                    <td>
                        <div class="d-flex flex-row bd-highlight mb-3">
                            <a href="{{ route('budget.edit', $budget->id) }}"
                               class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('budget.delete', $budget->id) }}" method="POST"
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

        <div class="row mb-3">
            <div class="col-sm-6">
                <a href="{{ route('budget.create') }}" class="btn btn-primary">Создать запись</a>
            </div>

        </div>

    </div>
@endsection
