<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">Боковая Панель</div>
        <div class="panel-body">
            <div class="list-group">
                @foreach($links AS $link)
                    <a href="{{$link['link']}}" class="list-group-item">
                        {{$link['ru']}}
                        @if(isset($link['qty']))
                            <span class="badge">{{$link['qty']}}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>