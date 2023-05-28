@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Обновить данные по покупкам для фирмы за свои</h1>

        <form action="{{route('expense.store')}}" method="POST">
            @csrf

            <div class="form-group mt-2">
                <label for="cadence_select">Выбери каденцию</label>
                <select class="form-control @error('cadence_select') is-invalid @enderror" id="cadence_select"
                        name="cadence_id">
                    <option value="">Выберите каденцию</option>

                    @foreach($cadences as $cadence)
                        <option value="{{$cadence->id}}">с {{$cadence->start}} по {{$cadence->finish}}</option>
                    @endforeach

                </select>
                @error('cadence_select')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="payment_amount">Сумма платежа</label>
                <input type="text" class="form-control @error('payment_amount') is-invalid @enderror"
                       id="payment_amount" name="payment_amount"
                       value="{{ old('payment_amount') }}"
                       required>
                @error('payment_amount')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="date">Дата платежа</label>
                <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="date"
                       name="payment_date"
                       value="{{ old('payment_date') }}"
                       required>
                @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание покупки</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                          name="description" placeholder="опиши покупку чтобы потом не ломать голову ))">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-2">Внести изменения</button>
        </form>

        <br>
        <a href="{{route('expenses.index')}}" class="btn btn-primary mb-3">Назад</a>
    </div>

@endsection
