<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{route('salaries.index')}}">
            <i class="bi bi-cash-stack"></i> Переводы
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('cadences.index')}}">
            <i class="bi bi-calendar-range"></i> Список каденций
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('expenses.index')}}">
            <i class="bi bi-cart"></i> Покупки за свои
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('bonuses.index')}}">
            <i class="bi bi-graph-up"></i> Корректировки
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('budget.index')}}">
            <i class="bi bi-piggy-bank"></i> Планирование бюджета
        </a>
    </li>

    <hr class="my-3">

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase small">
        <span>Статистика</span>
    </h6>
    <ul class="nav flex-column mb-2">
        <li class="nav-item">
            <a class="nav-link" href="{{route('statistics.index')}}">
                <i class="bi bi-bar-chart-line"></i> Годовая
            </a>
        </li>
    </ul>
</ul>



