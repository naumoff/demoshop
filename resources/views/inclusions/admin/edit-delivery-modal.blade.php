{{--BUTTON TO OPEN ADD NEW CATEGORY MODAL--}}
<button class="btn btn-success btn-xs"
        type="button"
        data-toggle="modal"
        data-target="#editDelivery-{{$delivery->id}}">
    Редактор
</button>
{{--END OF BUTTOM TO OPEN ADD NEW CATEGORY MODAL--}}

{{--ADD NEW CATEGORY MODAL--}}
<div id="editDelivery-{{$delivery->id}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Изменить условия доставки</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('deliveries.update',['deliveryRate'=>$delivery->id])}}">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <div class="form-group">
                        <input type="text" name="id" value="{{$delivery->id}}" hidden>
                        <label for="new-category">
                            Минимальный вес:
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                name="bank"
                                value="{{$delivery->min_weight}}"
                        >
                        <label for="new-category">
                            Максимальный вес:
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                name="card-number"
                                value="{{$delivery->max_weight}}"
                        >
                        <label for="new-category">
                            Стоимость доставки:
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                name="card-limit-eur"
                                value="{{$delivery->delivery_cost}}"
                        >
                    </div>
                    <button type="submit" class="btn btn-success">Изменить</button>
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