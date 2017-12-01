@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Редактор товара</div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="/admin/products/{{$product->id}}/edit-product">Редактор Товара</a></li>
                            <li class="active"><a href="#">Редактор фотографий</a></li>
                        </ul>
                        @include('inclusions.error-message')
                        <form>
                            {{csrf_field()}}
                            {{method_field('PATCH')}}
                            <input type="text" name="id" value="{{$product->id}}" hidden>
                            <input type="text" name="group-id" value="{{$product->group_id}}" hidden>
                            <div class="form-group">
                                <label for="product_ru">Название товара (рус):</label>
                                <input type="text"
                                       class="form-control"
                                       id="product_ru"
                                       placeholder="Введите имя товара на русском языке"
                                       required
                                       name="product-ru"
                                       value="{{$product->product_ru}}"
                                       readonly
                                >
                            </div>
                            <div class="form-group">
                                <label for="product_de">Название товара (нем):</label>
                                <input type="text"
                                       class="form-control"
                                       id="product_de"
                                       placeholder="Введите имя товара на немецком языке"
                                       required
                                       name="product-de"
                                       value="{{$product->product_de}}"
                                       readonly
                                >
                            </div>
                            <a href="/admin/products/{{$product->id}}/create-photo"
                               class="btn btn-success"
                               role="button"
                            >
                                Добавить фото
                            </a>
                        </form>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Фотография</th>
                                <th>Цвет</th>
                                <th>Удаление</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($photos AS $photo)
                                <tr>
                                    <td>
                                        <img src="{{$photo->url}}"
                                             class="img-rounded"
                                             alt="picture" width="100" height="90">

                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info" role="button" style="background-color: {{$photo->color->color_code}}"></a>
                                    </td>
                                    <td>
                                        <a href="#"
                                           class="btn btn-danger btn-block delete"
                                           role="button"
                                           id="{{$photo->id}}"
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
    $(function(){
        $(".delete").click(function(){
            var photoId = $(this).attr('id');
            $.post
            (
                '/admin/photo/delete',
                {
                    "_token": "{{ csrf_token() }}",
                    'photo-id':photoId
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