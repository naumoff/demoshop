{{--BUTTON TO OPEN ADD NEW CATEGORY MODAL--}}
<button class="btn btn-success" type="button" data-toggle="modal" data-target="#addCategory">
    Добавить условие доставки
</button>
{{--END OF BUTTOM TO OPEN ADD NEW CATEGORY MODAL--}}
{{--ADD NEW CATEGORY MODAL--}}
<div id="addCategory" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Создание нового условия доставки</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('deliveries.store')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="new-category">
                            Минимальный вес:
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                id="min-weight"
                                name="min-weight"
                        >
                    </div>
                    <div class="form-group">
                        <label for="new-category">
                            Максимальный вес:
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                id="max-weight"
                                name="max-weight"
                        >
                    </div>
                    <div class="form-group">
                        <label for="new-category">
                            Стоимость доставки обозначенного веса:
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                id="delivery-cost"
                                name="delivery-cost"
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