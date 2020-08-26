<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route(config('skote.url.dashboard', 'dashboard')) }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Панель управления</span>
                    </a>
                <li>

                <li class="menu-title">Сайт</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-file"></i>
                        <span>Категории</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="">Список</a></li>
                        <li><a href="">Добавить категорию</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{config('app_settings.url')}}" class="waves-effect">
                        <i class="bx bx-file"></i>
                        <span>Настройки</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
