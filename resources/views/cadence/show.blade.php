@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
            <h2 class="mb-0"><i class="bi bi-calendar-range"></i> Детали каденции</h2>
            <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                <a class="btn btn-outline-primary" href="{{ route('cadence.exportPdf', $cadence->id) }}">
                    <i class="bi bi-file-pdf"></i> Export to PDF
                </a>
                <a href="{{ route('cadence.edit', $cadence->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-pencil"></i> Редактировать каденцию
                </a>
            </div>
        </div>

        @if($cadence->status_finish)
            <div class="alert alert-secondary" role="alert">
                <i class="bi bi-check-circle"></i> <strong>Каденция завершена</strong>
            </div>
        @else
            <div class="alert alert-success" role="alert">
                <i class="bi bi-clock-history"></i> <strong>Ещё пока на работе</strong>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-calendar-event"></i> Период</h5>
                        <p class="mb-1"><strong>Начало:</strong> <span class="badge bg-primary">{{ \Carbon\Carbon::parse($cadence->start)->format('d.m.Y H:i') }}</span></p>
                        <p class="mb-1"><strong>Конец:</strong>
                            @if($cadence->finish)
                                <span class="badge bg-primary">{{ \Carbon\Carbon::parse($cadence->finish)->format('d.m.Y H:i') }}</span>
                            @else
                                <span class="badge bg-secondary">Не завершена</span>
                            @endif
                        </p>
                        <p class="mb-0"><strong>Отработано:</strong> <span class="badge bg-info">{{ $cadence->totalDays }} дней</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-wallet2"></i> Финансы</h5>
                        <p class="mb-1"><strong>Всего переведено:</strong> <span class="badge bg-info">{{ number_format($cadence->totalAmount, 2, ',', ' ') }} €</span></p>
                        <p class="mb-1"><strong>Остаток на начало:</strong> <span class="badge bg-success">{{ number_format($cadence->startDebt, 2, ',', ' ') }} €</span></p>
                        <p class="mb-0"><strong>Всего остаток:</strong>
                            <span class="badge bg-{{ $cadence->totalBalance >= 0 ? 'success' : 'danger' }}">
                                {{ number_format($cadence->totalBalance, 2, ',', ' ') }} €
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
            <h3 class="mb-0"><i class="bi bi-cash-stack"></i> Начисления</h3>
            <button type="button" class="btn btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#addSalaryModal">
                <i class="bi bi-plus-circle"></i> Внести зачисление
            </button>
        </div>

        <!-- Modal для добавления перевода -->
        <div class="modal fade" id="addSalaryModal" tabindex="-1" aria-labelledby="addSalaryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSalaryModalLabel">
                            <i class="bi bi-plus-circle"></i> Внести зачисление
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('salary.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="cadence_id" value="{{ $cadence->id }}">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="date"
                                       class="form-control @error('transfer_date') is-invalid @enderror"
                                       id="transfer_date"
                                       name="transfer_date"
                                       value="{{ old('transfer_date', date('Y-m-d')) }}"
                                       required
                                       placeholder="Дата перевода">
                                <label for="transfer_date">
                                    <i class="bi bi-calendar"></i> Дата перевода
                                </label>
                                @error('transfer_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Пожалуйста, выберите дату</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number"
                                       class="form-control @error('transfer_amount') is-invalid @enderror"
                                       id="transfer_amount"
                                       name="transfer_amount"
                                       value="{{ old('transfer_amount') }}"
                                       min="0.01"
                                       step="0.01"
                                       required
                                       placeholder="Сумма перевода">
                                <label for="transfer_amount">
                                    <i class="bi bi-currency-euro"></i> Сумма перевода (€)
                                </label>
                                @error('transfer_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Пожалуйста, введите корректную сумму</div>
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

        <!-- Десктопная версия таблицы зарплат -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><i class="bi bi-calendar"></i> Дата</th>
                    <th scope="col"><i class="bi bi-currency-euro"></i> Сумма в евро</th>
                    <th scope="col" class="text-end"><i class="bi bi-gear"></i> Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($cadence->salaries as $salary)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ \Carbon\Carbon::parse($salary->transfer_date)->format('d.m.Y') }}</td>
                        <td><strong>{{ number_format($salary->transfer_amount, 2, ',', ' ') }} €</strong></td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editSalaryModal{{ $salary->id }}"
                                        title="Редактировать">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('salary.delete', $salary->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Вы уверены, что хотите удалить этот перевод?')"
                                            title="Удалить">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal для редактирования перевода -->
                    <div class="modal fade" id="editSalaryModal{{ $salary->id }}" tabindex="-1" aria-labelledby="editSalaryModalLabel{{ $salary->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSalaryModalLabel{{ $salary->id }}">
                                        <i class="bi bi-pencil"></i> Редактировать перевод
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('salary.update', $salary->id) }}" method="POST" class="needs-validation" novalidate>
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $salary->id }}">
                                    <input type="hidden" name="cadence_id" value="{{ $cadence->id }}">
                                    <div class="modal-body">
                                        <div class="form-floating mb-3">
                                            <input type="date"
                                                   class="form-control @error('transfer_date') is-invalid @enderror"
                                                   id="transfer_date{{ $salary->id }}"
                                                   name="transfer_date"
                                                   value="{{ old('transfer_date', $salary->transfer_date) }}"
                                                   required
                                                   placeholder="Дата перевода">
                                            <label for="transfer_date{{ $salary->id }}">
                                                <i class="bi bi-calendar"></i> Дата перевода
                                            </label>
                                            @error('transfer_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="invalid-feedback">Пожалуйста, выберите дату</div>
                                            @enderror
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="number"
                                                   class="form-control @error('transfer_amount') is-invalid @enderror"
                                                   id="transfer_amount{{ $salary->id }}"
                                                   name="transfer_amount"
                                                   value="{{ old('transfer_amount', $salary->transfer_amount) }}"
                                                   min="0.01"
                                                   step="0.01"
                                                   required
                                                   placeholder="Сумма перевода">
                                            <label for="transfer_amount{{ $salary->id }}">
                                                <i class="bi bi-currency-euro"></i> Сумма перевода (€)
                                            </label>
                                            @error('transfer_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="invalid-feedback">Пожалуйста, введите корректную сумму</div>
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
                        <td colspan="4" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Зарплата еще не начислялась за эту каденцию</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Мобильная версия - карточки зарплат -->
        <div class="d-md-none">
            @forelse($cadence->salaries as $salary)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h5 class="card-title mb-1">
                                    <i class="bi bi-wallet2"></i> Перевод #{{ $loop->index + 1 }}
                                </h5>
                            </div>
                        </div>

                        <hr class="my-2">

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <small class="text-muted d-block"><i class="bi bi-calendar"></i> Дата</small>
                                <strong>{{ \Carbon\Carbon::parse($salary->transfer_date)->format('d.m.Y') }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block"><i class="bi bi-currency-euro"></i> Сумма</small>
                                <strong class="text-success">{{ number_format($salary->transfer_amount, 2, ',', ' ') }} €</strong>
                            </div>
                        </div>

                        <hr class="my-2">

                        <div class="d-grid gap-2">
                            <div class="btn-group" role="group">
                                <button type="button"
                                        class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editSalaryModal{{ $salary->id }}">
                                    <i class="bi bi-pencil"></i> Редактировать
                                </button>
                                <form action="{{ route('salary.delete', $salary->id) }}" method="POST" style="display: inline; flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger w-100"
                                            onclick="return confirm('Вы уверены, что хотите удалить этот перевод?')">
                                        <i class="bi bi-trash"></i> Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                        <p class="text-muted mt-2">Зарплата еще не начислялась за эту каденцию</p>
                    </div>
                </div>
            @endforelse
        </div>

        <h3 class="mt-4"><i class="bi bi-cart"></i> Покупки за свои</h3>
        <!-- Десктопная версия таблицы покупок -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><i class="bi bi-calendar"></i> Дата</th>
                    <th scope="col"><i class="bi bi-currency-euro"></i> Сумма в евро</th>
                    <th scope="col"><i class="bi bi-file-text"></i> Описание</th>
                </tr>
                </thead>
                <tbody>
                @forelse($cadence->expenses as $expense)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ \Carbon\Carbon::parse($expense->payment_date)->format('d.m.Y') }}</td>
                        <td><strong>{{ number_format($expense->payment_amount, 2, ',', ' ') }} €</strong></td>
                        <td>{{ $expense->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Покупок за свои не было за эту каденцию</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Мобильная версия - карточки покупок -->
        <div class="d-md-none">
            @forelse($cadence->expenses as $expense)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h5 class="card-title mb-1">
                                    <i class="bi bi-cart"></i> Покупка #{{ $loop->index + 1 }}
                                </h5>
                            </div>
                        </div>

                        <hr class="my-2">

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <small class="text-muted d-block"><i class="bi bi-calendar"></i> Дата</small>
                                <strong>{{ \Carbon\Carbon::parse($expense->payment_date)->format('d.m.Y') }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block"><i class="bi bi-currency-euro"></i> Сумма</small>
                                <strong class="text-danger">{{ number_format($expense->payment_amount, 2, ',', ' ') }} €</strong>
                            </div>
                        </div>

                        @if($expense->description)
                        <div class="mb-2">
                            <small class="text-muted d-block"><i class="bi bi-file-text"></i> Описание</small>
                            <p class="mb-0">{{ $expense->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                        <p class="text-muted mt-2">Покупок за свои не было за эту каденцию</p>
                    </div>
                </div>
            @endforelse
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

        <a href="javascript:history.back()" class="btn btn-secondary mb-3 mt-3">
            <i class="bi bi-arrow-left"></i> Назад
        </a>

    </div>
@endsection
