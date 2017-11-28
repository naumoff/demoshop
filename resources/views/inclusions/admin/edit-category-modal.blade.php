{{--BUTTON TO OPEN ADD NEW CATEGORY MODAL--}}
<button class="btn btn-success btn-sm"
        type="button"
        data-toggle="modal"
        data-target="#editCategory-{{$category->id}}">
    Редактор
</button>
{{--END OF BUTTOM TO OPEN ADD NEW CATEGORY MODAL--}}

{{--ADD NEW CATEGORY MODAL--}}
<div id="editCategory-{{$category->id}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Изменить имя категории</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/products/update-category">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <div class="form-group">
                        <label for="new-category">
                            Имя категории:
                        </label>
                        <input type="text" name="id" value="{{$category->id}}" hidden>
                        <input
                                type="text"
                                class="form-control"
                                name="category-name"
                                value="{{$category->category}}"
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