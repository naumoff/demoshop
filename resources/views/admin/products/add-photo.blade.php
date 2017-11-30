@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Карточка добавления фотографий</div>
                    <div class="panel-body">
                        <form action="{{route('admin-add-photo')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="text" name="product-id" value="{{$product->id}}" hidden>
                            <div class="form-group">
                                <label for="product_name">Название продукта:</label>
                                <input
                                        type="text"
                                        name="product-name"
                                        class="form-control"
                                        id="product_name"
                                        value="{{$product->product_ru}}"
                                        readonly
                                >
                                <hr>
                                @foreach($colors AS $color)
                                    @if($color->color_code === 'xxx')
                                        <a href="#"
                                           class="btn btn-info color"
                                           role="button"
                                           color="{{$color->color_code}}"
                                           id="{{$product->id}}"
                                        >
                                            -
                                        </a>
                                    @else
                                        <a href="#"
                                           class="btn btn-info color"
                                           style="background-color: {{$color->color_code}}"
                                           role="button"
                                           color="{{$color->color_code}}"
                                           id="{{$product->id}}"
                                        >
                                            +
                                        </a>
                                    @endif

                                @endforeach
                                <hr>

                            </div>
                            <div class="form-group">
                                @foreach($colors AS $color)
                                    <div id="div-{{$color->color_code}}"></div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-success">Сохранить</button>
                            <a href="#" class="btn btn-info refresh" role="button">Очистить</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $('document').ready(function(){
        $(".color").click(function(){
            var id = $(this).attr('id');
            var color = $(this).attr('color');
            $("#div-"+color).load('/admin/photo/'+id+'/'+color);
        })
        $(".refresh").click(function(){
            location.reload();
        })
    })
</script>
@endsection