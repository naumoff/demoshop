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
                                       name="package-weight"
                                       readonly
                                       value="{{$package->weight_gr}}"
                                >
                            </div>

                            <div class="form-group">
                                <label for="price_eur">Суммарная стоимость пакета (eur):</label>
                                <input type="text"
                                       class="form-control"
                                       id="price_eur"
                                       placeholder="Суммарная стоимость пакета (eur)"
                                       name="price-eur"
                                       readonly
                                       value="{{$package->price_eur}}"
                                >
                            </div>

                            <div class="form-group">
                                <label for="price_rub_auto">Автоматическая стоимость пакета (rub):</label>
                                <input type="text"
                                       class="form-control"
                                       id="price_rub_auto"
                                       placeholder="Суммарная стоимость пакета (rub)"
                                       name="price-rub-auto"
                                       readonly
                                       value="{{$package->price_rub_auto}}"
                                >
                            </div>

                        <div class="form-group">
                                <label for="price_rub_auto">Ручная стоимость пакета (rub):</label>
                                <input type="text"
                                       class="form-control"
                                       id="price_rub_auto"
                                       placeholder="Суммарная стоимость пакета (rub)"
                                       name="price-rub-auto"
                                       readonly
                                       value="{{$package->price_rub_manual}}"
                                >
                            </div>
                        <form class="form-inline"
                              method="post"
                              action="{{route('admin-update-package-ruble-price',['pack_id'=>$package->id])}}">
                            {{csrf_field()}}
                            {{method_field('PATCH')}}
                            <input type="text" name="package-id" value="{{$package->id}}" hidden>
                            <div class="form-group">
                                <label for="price_rub_manual">Ручная стоимость пакета (rub):</label>
                                <input type="text"
                                       class="form-control"
                                       id="price_rub_manual"
                                       placeholder="Ручной ввод стоимости в рублях, если есть необходимость"
                                       name="price-rub-manual"
                                       value="{{$package->price_rub_manual}}"
                                >
                            </div>
                            <button type="submit" class="btn btn-default">
                                Ввод ручной стоимости пакета
                            </button>
                        </form>
                        <hr>
                        <a href="{{route('admin-add-product-to-package',[
                                'pack_id'=>$package->id,
                                'cat_id'=>$category->id,
                                'group_id'=>$group->id
                            ])}}"
                           class="btn btn-success"
                           role="button">
                            Добавить товар в пакет
                        </a>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Продукт</th>
                                <th>Описание</th>
                                <th>Цена</th>
                                <th>Посмотреть</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products AS $product)
                                <tr>
                                    <td>{{$product->product_ru}}</td>
                                    <td>{{$product->description}}</td>
                                    <td>{{$product->price_rub_auto}}</td>
                                    <td>
                                        <a href="{{route('admin-edit-product',['prod_id'=>$product->id])}}"
                                           class="btn btn-default btn-xs"
                                           role="button"
                                           target="_blank"
                                        >
                                            Посмотреть товар
                                        </a>
                                    </td>                                    <td>
                                        <a href="#"
                                           class="btn btn-danger btn-xs delete"
                                           role="button"
                                           pack-id="{{$package->id}}"
                                           prod-id="{{$product->id}}"
                                        >
                                            Удалить из пакета
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
    $(function(){
        $(".delete").click(function(){
            var packageId = $(this).attr('pack-id');
            var productId = $(this).attr('prod-id');
            $.post
            (
                '{{route('admin-delete-product-from-package')}}',
                {
                    "_token": "{{ csrf_token() }}",
                    "_method": "DELETE",
                    "package-id":packageId,
                    "product-id":productId
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