@extends('layouts.app')

@section('content')
    <div class="container">

        <header class="d-flex flex-wrap justify-content-left py-3 mb-4 border-bottom">
            <p style="padding-right: 5px">Выбрать каденцию: </p>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="{{ route('salaries.index') }}">Все</a>
                </li>
                @foreach ($cadences as $cadence)
                    <li class="nav-item">
                        <a style="padding-left: 10px"
                            href="{{ route('salaries.index', ['cadence_id' => $cadence->id]) }}">{{ $cadence->start }}</a>
                    </li>
                @endforeach
            </ul>
        </header>

        <table class="table table-secondary table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Каденция</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Дата перевода</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($salaries as $salary)
                    <tr>
                        @if ($salaries instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                            <th scope="row">
                                {{ $loop->index + $salaries->perPage() * ($salaries->currentPage() - 1) + 1 }}</th>
                        @else
                            <th scope="row">{{ $loop->index + 1 }}</th>
                        @endif
                        <td>с {{ \Carbon\Carbon::parse($salary->cadence->start)->format('Y-m-d') }} по {{ \Carbon\Carbon::parse($salary->cadence->finish)->format('Y-m-d') }}</td>
                        <td>{{ $salary->transfer_amount }}</td>
                        <td>{{ $salary->transfer_date }}</td>
                        <td>
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <form action="{{ route('salary.delete', $salary->id) }}" method="POST"
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
                <a href="{{ route('salary.create') }}" class="btn btn-primary">Создать запись</a>
            </div>
            @if ($salaries instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <div class="pagination justify-content-center">
                    {{ $salaries->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>

    </div>
@endsection
