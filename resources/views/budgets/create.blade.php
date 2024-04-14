@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Обновить данные по покупкам для фирмы за свои</h1>

    <form action="{{route('budget.store')}}" method="POST">
        @csrf

        <div class="form-group w-50">
            <label for="payment_amount">Планируемая трата euro</label>
            <input type="number" class="form-control @error('payment_amount') is-invalid @enderror"
                   id="payment_amount" name="cash"
                   value="{{ old('cash') }}"
                   required>
            @error('payment_amount')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group w-50">
            <label for="date">Месяц планируемой траты</label>
            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date"
                   name="month"
                   value="{{ old('month') }}"
                   required>
            @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group w-50">
            <label for="description">Описание траты</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                      name="title" placeholder="опиши покупку чтобы потом не ломать голову ))">{{ old('title') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-2">Внести изменения</button>
    </form>

    <br>
    <a href="javascript:history.back()" class="btn btn-primary mb-3">Назад</a>
</div>

@endsection
