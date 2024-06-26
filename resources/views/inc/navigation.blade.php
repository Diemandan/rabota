<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('salaries.index')}}">
                            <span data-feather="file"></span>
                            Переводы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('cadences.index')}}">
                            <span data-feather="shopping-cart"></span>
                            Список каденций
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('expenses.index')}}">
                            <span data-feather="users"></span>
                            Покупки за свои
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('bonuses.index')}}">
                            <span data-feather="bar-chart-2"></span>
                            Корректировки
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('budget.index')}}">
                            <span data-feather="bar-chart-2"></span>
                            Планирование бюджета
                        </a>
                    </li>

                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Статистика</span>
                    <a class="link-secondary" href="#" aria-label="Add a new report">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href={{route('statistics.index')}}>
                            <span data-feather="file-text"></span>
                            Годовая
                        </a>
                    </li>

                </ul>
            </div>
        </nav>


    </div>
</div>



