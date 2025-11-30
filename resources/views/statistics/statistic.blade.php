@extends('layouts.app')

@section('content')
    @php
        if (isset($totalStatistic)) {
            $days = (int)$totalStatistic['totalDays'];
            $earnings = (float)$totalStatistic['totalSalary'];
            $lastYearDays = (int)$totalStatistic['totalLastYearDays'];
            $lastYearEarnings = (float)$totalStatistic['lastYearSalary'];

            // Расчеты для текущего года
            $avgMonthlyCurrent = $days > 0 ? ($earnings / $days * 30) : 0;
            $avgDailyCurrent = $days > 0 ? ($earnings / $days) : 0;

            // Расчеты для прошлого года
            $avgMonthlyLast = $lastYearDays > 0 ? ($lastYearEarnings / $lastYearDays * 30) : 0;
            $avgDailyLast = $lastYearDays > 0 ? ($lastYearEarnings / $lastYearDays) : 0;

            // Процент изменения
            $changePercent = $lastYearEarnings > 0 ? (($earnings - $lastYearEarnings) / $lastYearEarnings * 100) : 0;
        }
    @endphp

    <div class="container">
        <h2 class="mb-4"><i class="bi bi-bar-chart-line"></i> Годовая статистика</h2>

        <!-- Текущий год -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-calendar-check"></i> Текущий год ({{ date('Y') }})</h4>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Дней с начала года -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-calendar3" style="font-size: 3rem; color: #0d6efd;"></i>
                                </div>
                                <h3 class="text-primary mb-2">{{ number_format($days, 0, ',', ' ') }}</h3>
                                <p class="text-muted mb-0">Дней с начала года</p>
                                <div class="progress mt-3" style="height: 10px;">
                                    <div class="progress-bar bg-primary"
                                         role="progressbar"
                                         style="width: {{ min(($days / 365) * 100, 100) }}%"
                                         aria-valuenow="{{ $days }}"
                                         aria-valuemin="0"
                                         aria-valuemax="365">
                                    </div>
                                </div>
                                <small class="text-muted">{{ round(($days / 365) * 100, 1) }}% от года</small>
                            </div>
                        </div>
                    </div>

                    <!-- Заработано -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-cash-stack" style="font-size: 3rem; color: #198754;"></i>
                                </div>
                                <h3 class="text-success mb-2">{{ number_format($earnings, 2, ',', ' ') }} €</h3>
                                <p class="text-muted mb-0">Заработано с начала года</p>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-arrow-up-circle text-success"></i>
                                        Среднедневной: <strong>{{ number_format($avgDailyCurrent, 2, ',', ' ') }} €</strong>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Средний заработок в месяц -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-graph-up-arrow" style="font-size: 3rem; color: #fd7e14;"></i>
                                </div>
                                <h3 class="text-warning mb-2">{{ number_format($avgMonthlyCurrent, 2, ',', ' ') }} €</h3>
                                <p class="text-muted mb-0">Средний заработок в месяц</p>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle"></i>
                                        Прогноз на год: <strong>{{ number_format($avgMonthlyCurrent * 12, 2, ',', ' ') }} €</strong>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Прошлый год -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0"><i class="bi bi-calendar-x"></i> Прошлый год ({{ date('Y') - 1 }})</h4>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Дней в прошлом году -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-calendar3" style="font-size: 3rem; color: #6c757d;"></i>
                                </div>
                                <h3 class="text-secondary mb-2">{{ number_format($lastYearDays, 0, ',', ' ') }}</h3>
                                <p class="text-muted mb-0">Дней в году</p>
                                <div class="progress mt-3" style="height: 10px;">
                                    <div class="progress-bar bg-secondary"
                                         role="progressbar"
                                         style="width: 100%"
                                         aria-valuenow="{{ $lastYearDays }}"
                                         aria-valuemin="0"
                                         aria-valuemax="365">
                                    </div>
                                </div>
                                <small class="text-muted">Полный год</small>
                            </div>
                        </div>
                    </div>

                    <!-- Заработано в прошлом году -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-cash-stack" style="font-size: 3rem; color: #6c757d;"></i>
                                </div>
                                <h3 class="text-secondary mb-2">{{ number_format($lastYearEarnings, 2, ',', ' ') }} €</h3>
                                <p class="text-muted mb-0">Заработано за год</p>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-arrow-down-circle text-secondary"></i>
                                        Среднедневной: <strong>{{ number_format($avgDailyLast, 2, ',', ' ') }} €</strong>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Средний заработок в месяц (прошлый год) -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-graph-up-arrow" style="font-size: 3rem; color: #6c757d;"></i>
                                </div>
                                <h3 class="text-secondary mb-2">{{ number_format($avgMonthlyLast, 2, ',', ' ') }} €</h3>
                                <p class="text-muted mb-0">Средний заработок в месяц</p>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle"></i>
                                        Итого за год: <strong>{{ number_format($lastYearEarnings, 2, ',', ' ') }} €</strong>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Сравнение -->
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="bi bi-arrow-left-right"></i> Сравнение с прошлым годом</h4>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-cash-coin text-success"></i> Заработок
                                </h5>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Текущий год:</span>
                                    <strong class="text-success">{{ number_format($earnings, 2, ',', ' ') }} €</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Прошлый год:</span>
                                    <strong class="text-secondary">{{ number_format($lastYearEarnings, 2, ',', ' ') }} €</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><strong>Изменение:</strong></span>
                                    <span class="badge bg-{{ $changePercent >= 0 ? 'success' : 'danger' }} fs-6">
                                        {{ $changePercent >= 0 ? '+' : '' }}{{ number_format($changePercent, 2, ',', ' ') }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-graph-up text-warning"></i> Средний заработок в месяц
                                </h5>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Текущий год:</span>
                                    <strong class="text-warning">{{ number_format($avgMonthlyCurrent, 2, ',', ' ') }} €</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Прошлый год:</span>
                                    <strong class="text-secondary">{{ number_format($avgMonthlyLast, 2, ',', ' ') }} €</strong>
                                </div>
                                <hr>
                                @php
                                    $monthlyChange = $avgMonthlyLast > 0 ? (($avgMonthlyCurrent - $avgMonthlyLast) / $avgMonthlyLast * 100) : 0;
                                @endphp
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><strong>Изменение:</strong></span>
                                    <span class="badge bg-{{ $monthlyChange >= 0 ? 'success' : 'danger' }} fs-6">
                                        {{ $monthlyChange >= 0 ? '+' : '' }}{{ number_format($monthlyChange, 2, ',', ' ') }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
