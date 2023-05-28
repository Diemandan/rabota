@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Обновить данные по каденции</h1>

        <form action="{{route('cadence.store')}}" method="POST">
            @csrf
            @isset($cadence)
                <div class="form-group mt-2">
                    <input type="hidden" name="id" value="{{$cadence->id}}">
                </div>
            @endisset

            <div class="form-group">
                <label for="daily_rate">Оплата в сутки</label>
                <input type="number" class="form-control @error('daily_rate') is-invalid @enderror" id="daily_rate"
                       name="daily_rate"
                       value={{ old('daily_rate', isset($cadence) ? $cadence->daily_rate : 75) }}>
                @error('daily_rate')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="status_finish" id="flexRadioDefault1" value="0"
                    {{ (old('status_finish') == 0 || (isset($cadence) && $cadence->status_finish == 0)) ? 'checked' : (!old('status_finish') && !isset($cadence) ? 'checked' : '') }}>
                <label class="form-check-label" for="flexRadioDefault1">
                    Каденция еще не закончилась
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status_finish" id="flexRadioDefault2" value="1"
                    {{ (old('status_finish') == 1 || (isset($cadence) && $cadence->status_finish == 1)) ? 'checked' : '' }}>
                <label class="form-check-label" for="flexRadioDefault2">
                    Каденция завершена
                </label>
            </div>


            <div class="form-group">
                <label for="start">Начало каденции</label>
                <input type="date" class="form-control @error('start') is-invalid @enderror" id="start" name="start"
                       value="{{ old('start', isset($cadence) ? $cadence->start : '') }}"
                       @if(!isset($cadence)) required @endif>
                @error('start')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="finish">Конец каденции</label>
                <input type="date" class="form-control @error('finish') is-invalid @enderror" id="finish" name="finish"
                       value="{{ old('finish', isset($cadence) ? $cadence->finish : '') }}"
                       @if(isset($cadence) && $cadence->status_finish == 1) required @endif>
                @error('finish')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-2">Внести изменения</button>
        </form>

        <br>
        <a href="{{route('home')}}" class="btn btn-primary mb-3">Назад</a>
    </div>

@endsection
