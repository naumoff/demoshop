@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Категории</div>
                    <div class="panel-body">
                        @if(count($categories)>0)
                            {{--BUTTON TO OPEN ADD NEW CATEGORY MODAL--}}
                            <button class="btn btn-success btn-lg" type="button" data-toggle="modal" data-target="#addCategory">
                                Добавить категорию
                            </button>
                            {{--END OF BUTTOM TO OPEN ADD NEW CATEGORY MODAL--}}
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Категория</th>
                                    <th>Активность</th>
                                    <th>Группы</th>
                                    <th>Товары</th>
                                    <th>Переименовать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories AS $category)
                                    <tr>
                                        <td>{{$category['category']}}</td>
                                        <td>
                                            <button
                                                    type="button"
                                                    class="btn status"
                                                    id="{{$category->id}}"
                                                    value="{{$category->active}}"
                                            >
                                                {{ $status=($category->active)?'Активен':'Отключен' }}
                                            </button>
                                        </td>
                                        <td>
                                            <a href="/admin/products/{{$category['id']}}/groups"
                                               class="btn btn-info">
                                                Группы
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/admin/products/{{$category['id']}}/products"
                                               class="btn btn-info">
                                                Товары
                                            </a>
                                        </td>
                                        <td><button>Переименовать</button></td>
                                        <td>
                                            <button
                                                    type="button"
                                                    class="btn btn-danger delete"
                                                    id="{{$category->id}}"
                                            >
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $categories->links() }}

                            {{--ADD NEW CATEGORY MODAL--}}
                            <div id="addCategory" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button class="close" type="button" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">Создание новой категории</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="/admin/products/add-category">
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <label for="new-category">
                                                        Имя новой категории:
                                                    </label>
                                                    <input
                                                            type="text"
                                                            class="form-control"
                                                            id="new-category"
                                                            name="new-category"
                                                    >
                                                </div>
                                                <button type="submit" class="btn btn-success">Создать</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-default" type="button" data-dismiss="modal">
                                                Закрыть
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--END OF ADD NEW CATEGORY MODAL--}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".status").click(function(){
            var categoryId = $(this).attr('id');
            var oldValue = $(this).attr('value');
            $.post
            (
                '/admin/category/status',
                {
                    "_token": "{{ csrf_token() }}",
                    'categoryId':categoryId,
                    'oldValue':oldValue
                },
                function(data){
                    if(data === 'SUCCESS'){
                        location.reload();
                    }
                }
            );
        });
        $(".delete").click(function(){
            var categoryId = $(this).attr('id');
            $.post
            (
                '/admin/category/delete',
                {
                    "_token": "{{ csrf_token() }}",
                    'categoryId':categoryId
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