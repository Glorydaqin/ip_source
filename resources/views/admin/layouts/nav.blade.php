@foreach(Config::get("nav") as $key=>$value)
    <li>
        <a href="{{ $value['link'] }}"><i class="fa {{$value['icon']}}"></i> <span class="nav-label">{{ $key }}</span>
            @if(isset($value['level']))
                <span class="fa arrow"></span>
            @endif
            {{--<span class="label label-warning pull-right">16</span>--}}
        </a>
        @if(isset($value['level']))
            <ul class="nav nav-second-level">
                @foreach($value['level'] as $k=>$item)
                    @if (!is_array($item))
                        <li><a class="J_menuItem" href="@if(substr($item,0,1)=='/'){{ $item }}@else{{ action($item) }}@endif">{{ $k }}</a></li>
                    @else
                        <li>
                            <a href="#">{{ $k }} <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level" aria-expanded="true">
                                @foreach($item as $kk=>$vv)
                                    <li><a class="J_menuItem" href="{{ action($vv) }}" data-index="60">{{$kk}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </li>
@endforeach