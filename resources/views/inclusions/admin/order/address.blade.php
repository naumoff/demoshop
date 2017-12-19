<form method="post" action="{{route('admin-load-order-receptor-update',['order'=>$order->id])}}">
    {{method_field('PATCH')}}
    {{csrf_field()}}
    <input type="text" name="order_id" value="{{$order->id}}" hidden>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="user-first-name">Имя получателя:</label>
                <input
                        type="text"
                        class="form-control"
                        id="user-first-name"
                        name="user_first_name"
                        value="{{$order->user_first_name}}"
                >
            </div>
            <div class="form-group">
                <label for="user-last-name">Фамилия получателя:</label>
                <input
                        type="text"
                        class="form-control"
                        id="user-last-name"
                        name="user_last_name"
                        value="{{$order->user_last_name}}"
                >
            </div>
            <div class="form-group">
                <label for="user-phone">Телефон:</label>
                <input
                        type="text"
                        class="form-control"
                        id="user-phone"
                        name="user_phone"
                        value="{{$order->user_phone}}"
                >
            </div>
            <div class="form-group">
                <label for="user-country">Страна:</label>
                <input
                        type="text"
                        class="form-control"
                        id="user-country"
                        name="user_country"
                        value="{{$order->user_country}}"
                >
            </div>
            <div class="form-group">
                <label for="user-post-index">Почтовый индекс:</label>
                <input
                        type="text"
                        class="form-control"
                        id="user-post-index"
                        name="user_post_index"
                        value="{{$order->user_post_index}}"
                >
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="user-city">Населенный пункт:</label>
                <input
                        type="text"
                        class="form-control"
                        id="user-city"
                        name="user_city"
                        value="{{$order->user_city}}"
                >
            </div>
            <div class="form-group">
                <label for="user-street">Улица:</label>
                <input
                        type="text"
                        class="form-control"
                        id="user-street"
                        name="user_street"
                        value="{{$order->user_street}}"
                >
            </div>
            <div class="form-group">
                <label for="user-building-number">Дом:</label>
                <input
                        type="text"
                        class="form-control"
                        id="user-building-number"
                        name="user_building_number"
                        value="{{$order->user_building_number}}"
                >
            </div>
            <div class="form-group">
                <label for="user-apartment-number">Квартира:</label>
                <input
                        type="text"
                        class="form-control"
                        id="user-apartment-number"
                        name="user_apartment_number"
                        value="{{$order->user_apartment_number}}"
                >
            </div>
            <label>Изменить адрес доставки / получателя:</label>
            <button type="submit" class="btn btn-success btn-block">Обновить</button>
        </div>
    </div>
</form>