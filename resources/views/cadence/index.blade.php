@extends('layouts.app')

@section('content')
    <div class="container">

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Начало</th>
                <th>Конец</th>
                <th>Оплата в сутки</th>
                <th>СТатус каденции</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($cadences as $cadence)
                <tr>
                    <td>{{ $loop->index + ($cadences->perPage() * ($cadences->currentPage() - 1)) + 1 }}</td>
                    <td>{{ $cadence->start }}</td>
                    <td>{{ $cadence->finish }}</td>
                    <td>{{ $cadence->daily_rate }}</td>
                    <td>{{ $cadence->status_finish }}</td>
                    <td>
                        <div class="d-flex flex-row bd-highlight mb-3">
                            <a href="{{ route('cadence.create', $cadence->id) }}"
                               class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('cadence.delete', $cadence->id) }}" method="POST"
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
                <a href="{{ route('cadence.create') }}" class="btn btn-primary">Создать запись</a>
            </div>
            <div class="pagination justify-content-center">
                {{ $cadences->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
@endsection
