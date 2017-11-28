{{--BUTTON TO OPEN ADD NEW CATEGORY MODAL--}}
<button class="btn btn-success" type="button" data-toggle="modal" data-target="#addCategory">
    Добавить категорию
</button>
{{--END OF BUTTOM TO OPEN ADD NEW CATEGORY MODAL--}}
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