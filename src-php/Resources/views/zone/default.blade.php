<ul>
    @foreach ($items as $item)
        <li>
            {!! $item->view !!}
            @if($item->navigations->count())
                @novaNavigation($zone, $item->navigations)
            @endif
        </li>
    @endforeach
</ul>
