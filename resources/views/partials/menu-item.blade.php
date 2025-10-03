@if ($item['submenu'] == [])
    <li>
        <a href="#" onclick="loadContent('{{ $item['type'] }}', '{{ $item['data_id'] }}', '{{ addslashes($item['name']) }}')">
            {{ $item['name'] }}
        </a>
    </li>
@else
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            {{ $item['name'] }} <span class="caret"></span>
        </a>
        <ul class="dropdown-menu sub-menu">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    <li>
                        <a href="#" onclick="loadContent('{{ $submenu['type'] }}', '{{ $submenu['data_id'] }}', '{{ addslashes($submenu['name']) }}')">
                            {{ $submenu['name'] }}
                        </a>
                    </li>
                @else
                    @include('partials.menu-item', [ 'item' => $submenu ])
                @endif
            @endforeach
        </ul>
    </li>
@endif