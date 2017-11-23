<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">Боковая Панель</div>
        <div class="panel-body">
            @foreach($links AS $link)
                <li>
                    <a href="{{$link['link']}}">{{$link['ru']}}</a>
                </li>
            @endforeach
        </div>
    </div>
</div>