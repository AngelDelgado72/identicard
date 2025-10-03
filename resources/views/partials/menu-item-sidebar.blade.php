<li>
    <a href="#" onclick="loadContent('{{ $item['type'] ?? 'organizational' }}', '{{ $item['slug'] }}', '{{ $item['name'] }}')">
        <span class="menu-icon">
            @if(strpos($item['slug'], 'empresa-') !== false)
                🏢
            @elseif(strpos($item['slug'], 'sucursal-') !== false)
                🏪
            @elseif(strpos($item['slug'], 'empleado-') !== false)
                👤
            @else
                📄
            @endif
        </span>
        {{ $item['name'] }}
    </a>
    
    @if(count($item['submenu']) > 0)
        <ul class="submenu">
            @foreach($item['submenu'] as $subitem)
                @include('partials.menu-item-sidebar', ['item' => $subitem])
            @endforeach
        </ul>
    @endif
</li>