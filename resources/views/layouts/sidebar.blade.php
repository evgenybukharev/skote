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
                                <i class="{{$item['icon']??''}}"></i>
                                <span>{{$item['title']}}</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @foreach($item['links'] as $subItem)
                                <li><a href="{{$subItem['href']}}" data-active-regex="{{$subItem['active-regex']??''}}">{{$subItem['title']}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @break
                        @case('link')
                        <li>
                            <a href="{{$item['href']}}" class="waves-effect" data-active-regex="{{$item['active-regex']??''}}">
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

@push('script')
    <script>
        $("#sidebar-menu a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            var activeRegex=$(this).data('active-regex');

            if (this.href == pageUrl || (activeRegex!==undefined && activeRegex!=='' && new RegExp(activeRegex).test(pageUrl)) ) {
                $(this).addClass("active");
                $(this).parent().addClass("mm-active"); // add active to li of the current link
                $(this).parent().parent().addClass("mm-show");
                $(this).parent().parent().prev().addClass("mm-active"); // add active class to an anchor
                $(this).parent().parent().parent().addClass("mm-active");
                $(this).parent().parent().parent().parent().addClass("mm-show"); // add active to li of the current link
                $(this).parent().parent().parent().parent().parent().addClass("mm-active");
            }
        });
    </script>
@endpush
