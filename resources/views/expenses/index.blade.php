@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-cart"></i> Покупки за свои</h2>
            <a href="{{ route('expense.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Создать запись
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><i class="bi bi-calendar-range"></i> Период каденции</th>
                    <th scope="col"><i class="bi bi-currency-euro"></i> Сумма</th>
                    <th scope="col"><i class="bi bi-calendar"></i> Дата покупки</th>
                    <th scope="col"><i class="bi bi-file-text"></i> Описание</th>
                    <th scope="col" class="text-end"><i class="bi bi-gear"></i> Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <th scope="row">{{ $loop->index + ($expenses->perPage() * ($expenses->currentPage() - 1)) + 1 }}</th>
                        <td>
                            с {{ \Carbon\Carbon::parse($expense->cadence->start)->format('d.m.Y') }}
                            @if($expense->cadence->finish)
                                по {{ \Carbon\Carbon::parse($expense->cadence->finish)->format('d.m.Y') }}
                            @else
                                <span class="badge bg-secondary">Не завершена</span>
                            @endif
                        </td>
                        <td><strong>{{ number_format($expense->payment_amount, 2, ',', ' ') }} €</strong></td>
                        <td>{{ \Carbon\Carbon::parse($expense->payment_date)->format('d.m.Y') }}</td>
                        <td>{{ $expense->description ?? '-' }}</td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editExpenseModal{{ $expense->id }}"
                                        title="Редактировать">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('expense.delete', $expense->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Вы уверены, что хотите удалить эту покупку?')"
                                            title="Удалить">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal для редактирования покупки -->
                    <div class="modal fade" id="editExpenseModal{{ $expense->id }}" tabindex="-1" aria-labelledby="editExpenseModalLabel{{ $expense->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editExpenseModalLabel{{ $expense->id }}">
                                        <i class="bi bi-pencil"></i> Редактировать покупку
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('expense.update', $expense->id) }}" method="POST" class="needs-validation" novalidate>
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $expense->id }}">
                                    <input type="hidden" name="cadence_id" value="{{ $expense->cadence_id }}">
                                    <div class="modal-body">
                                        <div class="form-floating mb-3">
                                            <input type="date"
                                                   class="form-control @error('payment_date') is-invalid @enderror"
                                                   id="payment_date{{ $expense->id }}"
                                                   name="payment_date"
                                                   value="{{ old('payment_date', $expense->payment_date) }}"
                                                   required
                                                   placeholder="Дата покупки">
                                            <label for="payment_date{{ $expense->id }}">
                                                <i class="bi bi-calendar"></i> Дата покупки
                                            </label>
                                            @error('payment_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="invalid-feedback">Пожалуйста, выберите дату</div>
                                            @enderror
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="number"
                                                   class="form-control @error('payment_amount') is-invalid @enderror"
                                                   id="payment_amount{{ $expense->id }}"
                                                   name="payment_amount"
                                                   value="{{ old('payment_amount', $expense->payment_amount) }}"
                                                   min="0.01"
                                                   step="0.01"
                                                   required
                                                   placeholder="Сумма">
                                            <label for="payment_amount{{ $expense->id }}">
                                                <i class="bi bi-currency-euro"></i> Сумма (€)
                                            </label>
                                            @error('payment_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="invalid-feedback">Пожалуйста, введите корректную сумму</div>
                                            @enderror
                                        </div>

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      id="description{{ $expense->id }}"
                                                      name="description"
                                                      placeholder="Описание"
                                                      style="height: 100px">{{ old('description', $expense->description) }}</textarea>
                                            <label for="description{{ $expense->id }}">
                                                <i class="bi bi-file-text"></i> Описание
                                            </label>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
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
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Что-нибудь да купим ещё. Не переживай</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($expenses->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $expenses->links('pagination::bootstrap-5') }}
            </div>
        @endif
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
