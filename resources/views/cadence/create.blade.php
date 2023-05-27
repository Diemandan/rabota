@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Обновить данные по каденции</h1>

        <form action="{{route('cadence.store')}}" method="POST">
            @csrf

            <div class="form-group mt-2">
                <label for="cadencion_select">Выбери каденцию</label>
                <select class="form-control @error('cadencion_select') is-invalid @enderror" id="cadencion_select"
                        name="id" required>
                    <option value="">Выберите каденцию</option>
                    <option value="0">Создать новую запись</option>
                    @foreach($cadences as $cadence)
                        <option value="{{$cadence->id}}">с {{$cadence->start}} по {{$cadence->finish}}</option>
                    @endforeach
                </select>
                @error('cadencion_select')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="start">Начало каденции</label>
                <input type="date" class="form-control @error('title') is-invalid @enderror" id="start" name="start"
                       value="{{ old('start') }}">
                @error('start')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="finish">Конец каденции</label>
                <input type="date" class="form-control @error('title') is-invalid @enderror" id="finish" name="finish"
                       value="{{ old('finish') }}">
                @error('finish')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>

        <br>
        <a href="#" class="btn btn-primary mb-3">Back</a>
    </div>

@endsection
