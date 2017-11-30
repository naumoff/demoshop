@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="btn-group">
                            Категории
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown">
                                    {{$category->category}}
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($categories AS $categoryItem)
                                        <li>
                                            <a href="/admin/products/{{$categoryItem->id}}/{{$group->id}}/products">
                                                @if($categoryItem->active == 1)
                                                    <b>{{$categoryItem->category}}</b>
                                                @else
                                                    {{$categoryItem->category}}
                                                @endif

                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @if($categoryActive == 1)
                                Категория активна
                            @else
                                <b style="color: red">Категория не активна</b>
                            @endif
                        </div>
                        <div class="btn-group">
                            Группы
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown">
                                    {{$group->group}}
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($groups AS $groupItem)
                                        <li>
                                            <a href="/admin/products/{{$category->id}}/{{$groupItem->id}}/products">
                                                @if($groupItem->active == 1)
                                                    <b>{{$groupItem->group}}</b>
                                                @else
                                                    {{$groupItem->group}}
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @if($groupActive == 1)
                                Группа активна
                            @else
                                <b style="color: red">Группа не активна</b>
                            @endif
                        </div>
                    </div>

                    <div class="panel-heading">
                        Товары <br>
                        <a href="/admin/products/{{$category->id}}/create-product?group={{$group->id}}"
                           class="btn btn-success"
                           role="button"
                        >
                            Добавить товар
                        </a>
                        @include('inclusions.error-message')
                    </div>
                    <div class="panel-body">
                        @if(count($products)>0)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Активность</th>
                                    <th>Описание</th>
                                    <th>Акция</th>
                                    <th>Редактор</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($products AS $product)
                                        <tr>
                                            <td>
                                                {{$product->product_ru}}<br>
                                                {{$product->product_de}}
                                            </td>
                                            <td>
                                                <button
                                                        type="button"
                                                        class="btn btn-sm status"
                                                        id="{{$product->id}}"
                                                        value="{{$product->active}}"
                                                >
                                                    <b>{{ $status=($product->active)?'+':'-' }}</b>
                                                </button>
                                            </td>
                                            <td>
                                                вес: {{$product->weight_gr}} гр. <br>
                                                цена в Евро: {{$product->price_eur}}<br>
                                                цена в Rub: {{$product->price_rub_auto}}<br>
                                                цена в ручном режиме: {{$product->price_rub_manual}}<br>
                                            </td>
                                            <td>
                                                @if($product->discount_start != null)
                                                Начало акции: {{$product->discount_start}}<br>
                                                Конец акции: {{$product->discount_end}}<br>
                                                Цена с дисконтом: {{$product->price_with_discount}}<br>
                                                Активность акции:
                                                <button
                                                        type="button"
                                                        class="btn btn-sm status-action"
                                                        id="{{$product->id}}"
                                                        value="{{$product->discount_active}}"
                                                >
                                                    <b>{{ $status=($product->discount_active)?'+':'-' }}</b>
                                                </button>
                                                @else
                                                @endif
                                            </td>
                                            <td>
                                                <a href="/admin/products/{{$product->id}}/edit-product" class="btn btn-success btn-sm" role="button">
                                                    Редактор
                                                </a>
                                            </td>
                                            <td>
                                                <button
                                                        type="button"
                                                        class="btn btn-danger btn-sm delete"
                                                        id="{{$product->id}}"
                                                >
                                                    Удалить
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $products->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".status").click(function(){
            var productId = $(this).attr('id');
            var oldValue = $(this).attr('value');
            $.post
            (
                '/admin/product/status',
                {
                    "_token": "{{ csrf_token() }}",
                    'product-id':productId,
                    'old-value':oldValue
                },
                function(data){
                    if(data === 'SUCCESS'){
                        location.reload();
                    }
                }
            );
        });

        $(".status-action").click(function(){
            var productId = $(this).attr('id');
            var oldValue = $(this).attr('value');
            $.post
            (
                '/admin/product-action/status',
                {
                    "_token": "{{ csrf_token() }}",
                    'product-id':productId,
                    'old-value':oldValue
                },
                function(data){
                    if(data === 'SUCCESS'){
                        location.reload();
                    }
                }
            );
        });

        $(".delete").click(function(){
            var productId = $(this).attr('id');
            $.post
            (
                '/admin/product/delete',
                {
                    "_token": "{{ csrf_token() }}",
                    'product-id':productId
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