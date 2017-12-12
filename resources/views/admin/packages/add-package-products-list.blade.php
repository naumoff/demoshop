@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Создание пакета</div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-justified">
                            <li class="">
                                <a href="{{route('packages.edit',['id'=>$package->id])}}">
                                    Редактор Пакета
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    Добавление Товара
                                </a>
                            </li>
                        </ul>
                        @include('inclusions.error-message')
                        <form method="post" action="{{route('packages.store')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="package-name">Name:</label>
                                <input type="text"
                                       class="form-control"
                                       id="package-name"
                                       name="package-name"
                                       value="{{$package->package_ru}}"
                                       readonly
                                >
                            </div>
                            <div class="form-group">
                                <label for="package_weight">Вес пакета (гр.):</label>
                                <input type="text"
                                       class="form-control"
                                       id="package_weigh"
                                       placeholder="Суммарный вес пакета"
                                       required
                                       name="package-weight"
                                       readonly
                                       value="{{$package->weight_gr}}"
                                >
                            </div>

                        </form>
                        <a href="{{route('admin-create-package-products',['pack_id'=>$package->id])}}"
                           class="btn btn-success"
                           role="button">
                            Просмотр товаров в пакете
                        </a>
                        <hr>
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
                                            <a href="{{route('admin-add-product-to-package',[
                                                'pack_id'=>$package->id,
                                                'cat_id'=>$categoryItem->id,
                                                'group_id'=>$group
                                            ])}}">
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
                                            <a href="{{route('admin-add-product-to-package',[
                                                'pack_id'=>$package->id,
                                                'cat_id'=>$category->id,
                                                'group_id'=>$groupItem->id
                                            ])}}">
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
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Продукт</th>
                                <th>Цена (EUR)</th>
                                <th>Активность</th>
                                <th>Добавить в пакет</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products AS $product)
                                <tr>
                                    <td>{{$product->product_ru}}</td>
                                    <td>{{$product->price_eur}}</td>
                                    <td>{{$product->active}}</td>
                                    <td>
                                        <a href="#"
                                           class="btn btn-info btn-xs add-product"
                                           role="button"
                                           id="{{$product->id}}"

                                        >
                                            Добавить товар в пакет
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function(){
        $(".add-product").click(function(){
            var productId = $(this).attr('id');
            var packageId = "{{$package->id}}";
            $.post
            (
                '/admin/packages/'+packageId+'/products',
                {
                    "_token": "{{ csrf_token() }}",
                    'package-id':packageId,
                    'product-id':productId
                },
                function(data)
                {
                    if(data == 'SUCCESS'){
                        location.reload();
                    }else{
                        alert(data);
                    }
                }
            );
        })
    })
</script>
@endsection