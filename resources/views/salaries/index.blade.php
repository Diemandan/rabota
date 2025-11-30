@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-cash-stack"></i> Переводы</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSalaryModal">
                <i class="bi bi-plus-circle"></i> Создать запись
            </button>
        </div>

        <!-- Фильтр по каденциям -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="fw-bold">Выбрать каденцию:</span>
                    <a href="{{ route('salaries.index') }}"
                       class="btn btn-sm {{ !request()->has('cadence_id') ? 'btn-primary' : 'btn-outline-primary' }}">
                        Все
                    </a>
                    @foreach ($cadences as $cadence)
                        <a href="{{ route('salaries.index', ['cadence_id' => $cadence->id]) }}"
                           class="btn btn-sm {{ request('cadence_id') == $cadence->id ? 'btn-primary' : 'btn-outline-primary' }}">
                            {{ \Carbon\Carbon::parse($cadence->start)->format('d.m.Y') }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Статистика -->
        @if($salaries->isNotEmpty())
            @php
                $totalAmount = $salaries->sum('transfer_amount');
                $count = $salaries->count();
            @endphp
            <div class="alert alert-info d-flex align-items-center mb-4">
                <i class="bi bi-info-circle me-2" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Всего переводов:</strong> <span class="badge bg-primary ms-2">{{ $count }}</span>
                    <strong class="ms-3">Общая сумма:</strong>
                    <span class="badge bg-success ms-2" style="font-size: 1rem;">
                        {{ number_format($totalAmount, 2, ',', ' ') }} €
                    </span>
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><i class="bi bi-calendar-range"></i> Каденция</th>
                    <th scope="col"><i class="bi bi-currency-euro"></i> Сумма</th>
                    <th scope="col"><i class="bi bi-calendar"></i> Дата перевода</th>
                    <th scope="col" class="text-end"><i class="bi bi-gear"></i> Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($salaries as $salary)
                    <tr>
                        @if ($salaries instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                            <th scope="row">
                                {{ $loop->index + $salaries->perPage() * ($salaries->currentPage() - 1) + 1 }}
                            </th>
                        @else
                            <th scope="row">{{ $loop->index + 1 }}</th>
                        @endif
                        <td>
                            с {{ \Carbon\Carbon::parse($salary->cadence->start)->format('d.m.Y') }}
                            @if($salary->cadence->finish)
                                по {{ \Carbon\Carbon::parse($salary->cadence->finish)->format('d.m.Y') }}
                            @else
                                <span class="badge bg-secondary">Не завершена</span>
                            @endif
                        </td>
                        <td><strong>{{ number_format($salary->transfer_amount, 2, ',', ' ') }} €</strong></td>
                        <td>{{ \Carbon\Carbon::parse($salary->transfer_date)->format('d.m.Y') }}</td>
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
                                    <div class="modal-body">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('cadence_id') is-invalid @enderror"
                                                    id="cadence_id{{ $salary->id }}"
                                                    name="cadence_id"
                                                    required>
                                                <option value="">Выберите каденцию</option>
                                                @foreach($cadencesForForm ?? $cadences as $cadence)
                                                    <option value="{{ $cadence->id }}"
                                                            {{ old('cadence_id', $salary->cadence_id) == $cadence->id ? 'selected' : '' }}>
                                                        с {{ \Carbon\Carbon::parse($cadence->start)->format('d.m.Y') }}
                                                        @if($cadence->finish)
                                                            по {{ \Carbon\Carbon::parse($cadence->finish)->format('d.m.Y') }}
                                                        @else
                                                            (не завершена)
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="cadence_id{{ $salary->id }}">
                                                <i class="bi bi-calendar-range"></i> Каденция
                                            </label>
                                            @error('cadence_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @else
                                                <div class="invalid-feedback">Пожалуйста, выберите каденцию</div>
                                            @enderror
                                        </div>

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
                        <td colspan="5" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Нет переводов для отображения</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($salaries instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $salaries->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $salaries->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Modal для добавления перевода -->
    <div class="modal fade" id="addSalaryModal" tabindex="-1" aria-labelledby="addSalaryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSalaryModalLabel">
                        <i class="bi bi-plus-circle"></i> Создать перевод
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('salary.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <select class="form-select @error('cadence_id') is-invalid @enderror"
                                    id="cadence_id"
                                    name="cadence_id"
                                    required>
                                <option value="">Выберите каденцию</option>
                                @foreach($cadencesForForm ?? $cadences as $cadence)
                                    <option value="{{ $cadence->id }}"
                                            {{ old('cadence_id') == $cadence->id ? 'selected' : '' }}>
                                        с {{ \Carbon\Carbon::parse($cadence->start)->format('d.m.Y') }}
                                        @if($cadence->finish)
                                            по {{ \Carbon\Carbon::parse($cadence->finish)->format('d.m.Y') }}
                                        @else
                                            (не завершена)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <label for="cadence_id">
                                <i class="bi bi-calendar-range"></i> Каденция
                            </label>
                            @error('cadence_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Пожалуйста, выберите каденцию</div>
                            @enderror
                        </div>

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
