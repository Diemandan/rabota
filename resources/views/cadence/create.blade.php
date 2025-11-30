@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Обновить данные по каденции</h1>

        <form action="{{route('cadence.store')}}" method="POST" class="needs-validation" novalidate>
            @csrf
            @isset($cadence)
                <input type="hidden" name="id" value="{{$cadence->id}}">
            @endisset

            <div class="form-floating mb-3">
                <input type="number" 
                       class="form-control @error('daily_rate') is-invalid @enderror" 
                       id="daily_rate"
                       name="daily_rate"
                       value="{{ old('daily_rate', isset($cadence) ? $cadence->daily_rate : \App\Models\Cadence::DEFAULT_DAILY_RATE) }}"
                       min="0"
                       step="1"
                       required
                       placeholder="Оплата в сутки">
                <label for="daily_rate">
                    <i class="bi bi-currency-euro"></i> Оплата в сутки
                </label>
                @error('daily_rate')
                    <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <div class="invalid-feedback">Пожалуйста, введите корректную ставку</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-info-circle"></i> Статус каденции
                </label>
                <div class="form-check">
                    <input class="form-check-input" 
                           type="radio" 
                           name="status_finish" 
                           id="status_finish_0" 
                           value="0"
                           {{ (old('status_finish') == 0 || (isset($cadence) && $cadence->status_finish == 0)) ? 'checked' : (!old('status_finish') && !isset($cadence) ? 'checked' : '') }}
                           onchange="toggleFinishDate()">
                    <label class="form-check-label" for="status_finish_0">
                        <i class="bi bi-clock-history"></i> Каденция еще не закончилась
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" 
                           type="radio" 
                           name="status_finish" 
                           id="status_finish_1" 
                           value="1"
                           {{ (old('status_finish') == 1 || (isset($cadence) && $cadence->status_finish == 1)) ? 'checked' : '' }}
                           onchange="toggleFinishDate()">
                    <label class="form-check-label" for="status_finish_1">
                        <i class="bi bi-check-circle"></i> Каденция завершена
                    </label>
                </div>
            </div>

            <div class="form-floating mb-3">
                <input type="datetime-local" 
                       class="form-control @error('start') is-invalid @enderror" 
                       id="start" 
                       name="start"
                       value="{{ old('start', isset($cadence) ? \Carbon\Carbon::parse($cadence->start)->format('Y-m-d\TH:i') : '') }}"
                       @if(!isset($cadence)) required @endif
                       placeholder="Начало каденции">
                <label for="start">
                    <i class="bi bi-calendar-event"></i> Начало каденции
                </label>
                @error('start')
                    <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <div class="invalid-feedback">Пожалуйста, выберите дату начала</div>
                @enderror
            </div>

            <div class="form-floating mb-3" id="finish_date_group">
                <input type="datetime-local" 
                       class="form-control @error('finish') is-invalid @enderror" 
                       id="finish" 
                       name="finish"
                       value="{{ old('finish', isset($cadence) && $cadence->finish ? \Carbon\Carbon::parse($cadence->finish)->format('Y-m-d\TH:i') : '') }}"
                       @if(isset($cadence) && $cadence->status_finish == 1) required @endif
                       placeholder="Конец каденции">
                <label for="finish">
                    <i class="bi bi-calendar-check"></i> Конец каденции
                </label>
                @error('finish')
                    <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <div class="invalid-feedback">Пожалуйста, выберите дату окончания</div>
                @enderror
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Внести изменения
                </button>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Назад
                </a>
            </div>
        </form>

        <script>
            // Клиентская валидация Bootstrap
            (function() {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();

            // Переключение обязательности поля "Конец каденции"
            function toggleFinishDate() {
                const finishGroup = document.getElementById('finish_date_group');
                const finishInput = document.getElementById('finish');
                const statusFinished = document.getElementById('status_finish_1').checked;
                
                if (statusFinished) {
                    finishInput.setAttribute('required', 'required');
                    finishGroup.style.display = 'block';
                } else {
                    finishInput.removeAttribute('required');
                    finishGroup.style.display = 'block'; // Оставляем видимым, но не обязательным
                }
            }

            // Инициализация при загрузке страницы
            document.addEventListener('DOMContentLoaded', function() {
                toggleFinishDate();
            });
        </script>

        <br>
        <a href="javascript:history.back()" class="btn btn-primary mb-3">Назад</a>
    </div>

@endsection
