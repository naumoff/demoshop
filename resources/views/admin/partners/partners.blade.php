@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Платежные партнеры</div>
                    <div class="panel-body">
                        <a href="{{route('partners.create')}}" class="btn btn-success" role="button">
                            Добавить партнера
                        </a>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Порядок</th>
                                <th>Фамилия</th>
                                <th>Имя</th>
                                <th>Лим. партн.</th>
                                <th>Лим. карт.</th>
                                <th>Инвойсы</th>
                                <th>Статус</th>
                                <th>Активность</th>
                                <th>Карточки</th>
                                <th>Редактор</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($partners AS $partner)
                                <tr>
                                    <td>{{$partner->sequence}}</td>
                                    <td>{{$partner->first_name}}</td>
                                    <td>{{$partner->last_name}}</td>
                                    <td>{{$partner->total_limit_eur}}</td>
                                    <td>{{$partner->total_cards_limit_eur}}</td>
                                    <td>{{$partner->total_invoiced_eur}}</td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-sm btn-block current"
                                                id="{{$partner->id}}"
                                                value="{{$partner->current}}"
                                        >
                                            @if($partner->current == 1)
                                                <div style=color:red>Текущий</div>
                                            @else
                                                <div>Ожидает</div>
                                            @endif
                                        </button>
                                    </td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-sm btn-block active"
                                                id="{{$partner->id}}"
                                                value="{{$partner->active}}"
                                        >
                                            <b>{{ ($partner->active)?'работает':'заблокирован' }}</b>
                                        </button>
                                    </td>

                                    <td>
                                        <a class="btn btn-info btn-xs"
                                           href="{{route('admin-partner-add-card',['part_id'=>$partner->id])}}"
                                           id="{{$partner->id}}"
                                           role="button"
                                        >
                                            Карточки
                                            <span class="badge">{{count($partner->paymentCards()->get())}}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs"
                                           href="{{route('partners.edit',['part_id'=>$partner->id])}}"
                                           id="{{$partner->id}}"
                                           role="button"
                                        >
                                            Редактор
                                        </a>
                                    </td>
                                    <td>
                                        @if($partner->orders->count() === 0 )
                                            <a href="#"
                                               id="{{$partner->id}}"
                                               class="btn btn-danger btn-xs delete"
                                               role="button"
                                            >
                                                Удалить
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $partners->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".active").click(function(){
            var partnerId = $(this).attr('id');
            var oldValue = $(this).attr('value');
            $.post
            (
                '/admin/partner/active',
                {
                    "_token": "{{csrf_token()}}",
                    "_method": "PATCH",
                    'partner-id':partnerId,
                    'old-value':oldValue
                },
                function(data){
                    if(data === 'SUCCESS'){
                        location.reload();
                    }else{
                        alert(data);
                    }
                }
            );
        });

        $(".current").click(function(){
            var partnerId = $(this).attr('id');
            var oldValue = $(this).attr('value');
            $.post
            (
                '/admin/partner/current',
                {
                    "_token": "{{csrf_token()}}",
                    "_method": "PATCH",
                    'partner_id':partnerId,
                    'old_value':oldValue
                },
                function(data){
                    if(data === 'SUCCESS'){
                        location.reload();
                    }else{
                        alert(data);
                    }
                }
            );
        });
        $(".delete").click(function(){
            var presentId = $(this).attr('id');
            $.post
            (
                '/admin/partners/'+ presentId,
                {
                    "_token": "{{ csrf_token() }}",
                    "_method": "DELETE",
                },
                function(data){
                    if(data === 'SUCCESS'){
                        location.reload();
                    }else{
                        alert(data);
                    }
                }
            );
        })
    });
</script>
@endsection