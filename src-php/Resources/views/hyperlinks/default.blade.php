<ul class="hyperlinks hyperlinks--{{ $style }}">
    @foreach($repeater->repeaters as $link)
        <li>{!! $link->view !!}</li>
    @endforeach
</ul>
