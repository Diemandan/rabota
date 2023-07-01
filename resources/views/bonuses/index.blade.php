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
                <th scope="col">Описание</th>
            </tr>
            </thead>
            <tbody>

            @foreach($bonuses as $bonus)
                <tr>
                    <th scope="row">{{ $loop->index + ($bonuses->perPage() * ($bonuses->currentPage() - 1)) + 1 }}</th>
                    <td>с {{$bonus->cadence->start}} по {{$bonus->cadence->finish}}</td>
                    <td>{{$bonus->transfer_amount}}</td>
                    <td>{{$bonus->transfer_date}}</td>
                    <td>{{$bonus->description}}</td>
                    <td>
                        <div class="d-flex flex-row bd-highlight mb-3">
                            <form action="{{ route('bonus.delete', $bonus->id) }}" method="POST"
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
@if($bonuses->isEmpty())
<h3> Что-нибудь да купим ещё. Не переживай </h3>
@endif
        <div class="row mb-3">
            <div class="col-sm-6">
                <a href="{{ route('bonus.create') }}" class="btn btn-primary">Создать запись</a>
            </div>
            <div class="pagination justify-content-center">
                {{ $bonuses->links('pagination::bootstrap-4') }}
            </div>
        </div>

    </div>

@endsection
