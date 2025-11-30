@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-piggy-bank"></i> Планирование бюджета</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBudgetModal">
                <i class="bi bi-plus-circle"></i> Создать запись
            </button>
        </div>

        <!-- Фильтр по месяцам -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="fw-bold">Выбрать период:</span>
                    <a href="{{ route('budget.index') }}?all"
                       class="btn btn-sm {{ !request()->has('month') && !request()->has('all') ? 'btn-primary' : 'btn-outline-primary' }}">
                        Текущий месяц
                    </a>
                    <a href="{{ route('budget.index') }}?all"
                       class="btn btn-sm {{ request()->has('all') ? 'btn-primary' : 'btn-outline-primary' }}">
                        Все
                    </a>
                    @foreach ($months as $month)
                        <a href="{{ route('budget.index', ['month' => $month]) }}"
                           class="btn btn-sm {{ request('month') == $month ? 'btn-primary' : 'btn-outline-primary' }}">
                            {{ \Carbon\Carbon::parse($month . '-01')->format('M Y') }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Общая сумма -->
        <div class="alert alert-info d-flex align-items-center mb-4">
            <i class="bi bi-calculator me-2" style="font-size: 1.5rem;"></i>
            <div>
                <strong>Общая сумма планируемых расходов:</strong>
                <span class="badge bg-danger ms-2" style="font-size: 1rem;">
                    {{ number_format($totalCashSum, 2, ',', ' ') }} €
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><i class="bi bi-file-text"></i> Назначение</th>
                    <th scope="col"><i class="bi bi-currency-euro"></i> Сумма</th>
                    <th scope="col"><i class="bi bi-calendar-month"></i> Месяц траты</th>
                    <th scope="col" class="text-end"><i class="bi bi-gear"></i> Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($budgets as $budget)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $budget->title }}</td>
                        <td><strong>{{ number_format($budget->cash, 2, ',', ' ') }} €</strong></td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ \Carbon\Carbon::parse($budget->month . '-01')->format('M Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editBudgetModal{{ $budget->id }}"
                                        title="Редактировать">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('budget.delete', $budget->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Вы уверены, что хотите удалить эту запись бюджета?')"
                                            title="Удалить">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal для редактирования бюджета -->
                    <div class="modal fade" id="editBudgetModal{{ $budget->id }}" tabindex="-1" aria-labelledby="editBudgetModalLabel{{ $budget->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBudgetModalLabel{{ $budget->id }}">
                                        <i class="bi bi-pencil"></i> Редактировать запись бюджета
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('budget.store') }}" method="POST" class="needs-validation" novalidate>
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $budget->id }}">
                                    <div class="modal-body">
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                   class="form-control @error('title') is-invalid @enderror"
                                                   id="title{{ $budget->id }}"
                                                   name="title"
                                                   value="{{ old('title', $budget->title) }}"
                                                   required
                                                   minlength="3"
                                                   maxlength="500"
                                                   placeholder="Назначение">
                                            <label for="title{{ $budget->id }}">
                                                <i class="bi bi-file-text"></i> Назначение
                                            </label>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="invalid-feedback">Пожалуйста, введите назначение (минимум 3 символа)</div>
                                            @enderror
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="number"
                                                   class="form-control @error('cash') is-invalid @enderror"
                                                   id="cash{{ $budget->id }}"
                                                   name="cash"
                                                   value="{{ old('cash', $budget->cash) }}"
                                                   min="0.01"
                                                   step="0.01"
                                                   required
                                                   placeholder="Сумма">
                                            <label for="cash{{ $budget->id }}">
                                                <i class="bi bi-currency-euro"></i> Планируемая трата (€)
                                            </label>
                                            @error('cash')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="invalid-feedback">Пожалуйста, введите корректную сумму</div>
                                            @enderror
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="month"
                                                   class="form-control @error('month') is-invalid @enderror"
                                                   id="month{{ $budget->id }}"
                                                   name="month"
                                                   value="{{ old('month', $budget->month) }}"
                                                   required
                                                   placeholder="Месяц">
                                            <label for="month{{ $budget->id }}">
                                                <i class="bi bi-calendar-month"></i> Месяц планируемой траты
                                            </label>
                                            @error('month')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="invalid-feedback">Пожалуйста, выберите месяц</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle"></i> Отмена
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-lg"></i> Сохранить изменения
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Нет записей бюджета для отображения</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal для добавления бюджета -->
    <div class="modal fade" id="addBudgetModal" tabindex="-1" aria-labelledby="addBudgetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBudgetModalLabel">
                        <i class="bi bi-plus-circle"></i> Создать запись бюджета
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('budget.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   required
                                   minlength="3"
                                   maxlength="500"
                                   placeholder="Назначение">
                            <label for="title">
                                <i class="bi bi-file-text"></i> Назначение
                            </label>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Пожалуйста, введите назначение (минимум 3 символа)</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number"
                                   class="form-control @error('cash') is-invalid @enderror"
                                   id="cash"
                                   name="cash"
                                   value="{{ old('cash') }}"
                                   min="0.01"
                                   step="0.01"
                                   required
                                   placeholder="Сумма">
                            <label for="cash">
                                <i class="bi bi-currency-euro"></i> Планируемая трата (€)
                            </label>
                            @error('cash')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Пожалуйста, введите корректную сумму</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="month"
                                   class="form-control @error('month') is-invalid @enderror"
                                   id="month"
                                   name="month"
                                   value="{{ old('month', date('Y-m')) }}"
                                   required
                                   placeholder="Месяц">
                            <label for="month">
                                <i class="bi bi-calendar-month"></i> Месяц планируемой траты
                            </label>
                            @error('month')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Пожалуйста, выберите месяц</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Отмена
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Сохранить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Клиентская валидация Bootstrap для модальных форм
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
    </script>
@endsection
