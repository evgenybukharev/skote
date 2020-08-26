@php($menu=app()->make(\EvgenyBukharev\Skote\Components\Menu\MenuRendererInterface::class)->getMenu())
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

                @foreach($menu as $item)

                    @switch($item['type'])
                        @case('section')
                        <li class="menu-title">{{$item['title']}}</li>
                        @break
                        @case('link-block')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="{{$item['icon']}}"></i>
                                <span>{{$item['title']}}</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @foreach($item['links'] as $subItem)
                                <li><a href="{{$subItem['href']}}">{{$subItem['title']}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @break
                        @case('link')
                        <li>
                            <a href="{{$item['href']}}" class="waves-effect">
                                <i class="{{$item['icon']}}"></i>
                                <span>{{$item['title']}}</span>
                            </a>
                        </li>
                        @break
                    @endswitch
                @endforeach
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
