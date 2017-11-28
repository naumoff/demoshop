{{--BUTTON TO OPEN ADD NEW CATEGORY MODAL--}}
<button class="btn btn-success" type="button" data-toggle="modal" data-target="#addProduct">
    Добавить товар
</button>
{{--END OF BUTTOM TO OPEN ADD NEW CATEGORY MODAL--}}

{{--ADD NEW CATEGORY MODAL--}}
<div id="addProduct" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Создание нового товара</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/products/add-product">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="category">
                            Категория:
                        </label>
                        <select class="form-control" id="category" name="category-id">
                            @foreach($categories AS $categoryItem)
                                @if($categoryItem->id == $category->id)
                                    <option value="{{$categoryItem->id}}" selected>
                                        {{$categoryItem->category}}
                                    </option>
                                @else
                                    <option value="{{$categoryItem->id}}">
                                        {{$categoryItem->category}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <select class="form-control" id="group" name="group-id">
                            @foreach($groups AS $groupItem)
                                @if($groupItem->id == $group->id)
                                    <option value="{{$groupItem->id}}" selected>
                                        {{$groupItem->group}}
                                    </option>
                                @else
                                    <option value="{{$groupItem->id}}">
                                        {{$groupItem->group}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <label for="new-product">
                            Имя нового товара:
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                name="new-group"
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