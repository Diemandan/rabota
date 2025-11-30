@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-calendar-range"></i> Список каденций</h2>
            <a href="{{ route('cadence.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Создать запись
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><i class="bi bi-calendar-event"></i> Начало</th>
                    <th scope="col"><i class="bi bi-calendar-check"></i> Конец</th>
                    <th scope="col"><i class="bi bi-wallet2"></i> Остаток на конец каденции</th>
                    <th scope="col"><i class="bi bi-cash-coin"></i> Всего переведено</th>
                    <th scope="col"><i class="bi bi-info-circle"></i> Статус</th>
                    <th scope="col" class="text-end"><i class="bi bi-gear"></i> Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($cadences as $cadence)
                    <tr>
                        <td>{{ $loop->index + ($cadences->perPage() * ($cadences->currentPage() - 1)) + 1 }}</td>
                        <td>{{ $cadence->start }}</td>
                        <td>{{ $cadence->finish ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $cadence->totalBalance >= 0 ? 'success' : 'danger' }}">
                                {{ number_format($cadence->totalBalance, 2) }} €
                            </span>
                        </td>
                        <td>{{ number_format($cadence->totalSalariesPayments, 2) }} €</td>
                        <td>
                            @if($cadence->status_finish == 0)
                                <span class="badge bg-success">
                                    <i class="bi bi-clock-history"></i> Ещё работаем
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-check-circle"></i> Каденция окончена
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('cadence.edit', $cadence->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Редактировать">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('cadence.show', $cadence->id) }}" 
                                   class="btn btn-sm btn-outline-info"
                                   title="Просмотр">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $cadence->id }}"
                                        title="Удалить">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal для подтверждения удаления -->
                    <div class="modal fade" id="deleteModal{{ $cadence->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $cadence->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $cadence->id }}">
                                        <i class="bi bi-exclamation-triangle text-warning"></i> Подтверждение удаления
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Вы уверены, что хотите удалить каденцию?</p>
                                    <p class="text-muted small">
                                        <strong>Начало:</strong> {{ $cadence->start }}<br>
                                        @if($cadence->finish)
                                            <strong>Конец:</strong> {{ $cadence->finish }}
                                        @endif
                                    </p>
                                    <p class="text-danger"><strong>Это действие нельзя отменить!</strong></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle"></i> Отмена
                                    </button>
                                    <form action="{{ route('cadence.delete', $cadence->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i> Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Нет данных для отображения</p>
                            <a href="{{ route('cadence.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle"></i> Создать первую каденцию
                            </a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($cadences->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $cadences->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
