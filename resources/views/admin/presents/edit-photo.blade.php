@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Редактирование подарка</div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-justified">
                            <li>
                                <a href="{{route('presents.edit',['id'=>$present->id])}}">
                                    Редактор Подарка
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    Редактор фотографий
                                </a>
                            </li>
                        </ul>
                        @include('inclusions.error-message')
                        <form method="post"
                              action="{{route('admin-present-add-photo',['id'=>$present->id])}}"
                              enctype="multipart/form-data"
                        >
                            {{csrf_field()}}
                            {{method_field('PATCH')}}
                            <input type="text" name="present-id" value="{{$present->id}}" hidden>
                            <div class="form-group">
                                <label for="present_ru">Название Подарка (рус):</label>
                                <input type="text"
                                       class="form-control"
                                       id="present_ru"
                                       placeholder="Введите имя подарка на русском языке"
                                       required
                                       name="present-ru"
                                       value="{{$present->present_ru}}"
                                       readonly
                                >
                            </div>
                            <div class="form-group">
                                <label for="present_de">Название Подарка (нем):</label>
                                <input type="text"
                                       class="form-control"
                                       id="present_de"
                                       placeholder="Введите имя подарка на немецком языке"
                                       required
                                       name="present-de"
                                       value="{{$present->present_de}}"
                                       readonly
                                >
                            </div>
                            <span class="btn btn-default btn-file">
                            <span>Выберите файл</span>
                            <input type="file" name="urls[]" multiple required /></span>
                            <span class="fileinput-filename"></span>
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </form>
                        <hr>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Фотография</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(unserialize($present->urls) AS $url)
                                <tr>
                                    <td>
                                        <img src="{{$url}}"
                                             class="img-rounded"
                                             alt="picture" width="150" height="100"
                                        >
                                    </td>
                                    <td>
                                        <a href="#"
                                           class="btn btn-danger btn-block delete"
                                           role="button"
                                           present-id="{{$present->id}}"
                                           url="{{$url}}"
                                        >
                                            Удалить
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $('document').ready(function(){
        $(".delete").click(function(){
            var presentId = $(this).attr('present-id');
            var url = $(this).attr('url');
            $.post
            (
                '/admin/presents/'+presentId+'/delete-photo',
                {
                    'present-id':presentId,
                    'url':url,
                    "_token": "{{csrf_token()}}",
                    "_method": "DELETE"
                },
                function(data){
                    if(data == 'SUCCESS'){
                        location.reload();
                    }else{
                        alert(data);
                    }
                }
            )
        });
    });
</script>
@endsection