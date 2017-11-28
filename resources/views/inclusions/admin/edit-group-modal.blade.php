{{--BUTTON TO OPEN ADD NEW CATEGORY MODAL--}}
<button class="btn btn-success btn-sm"
        type="button"
        data-toggle="modal"
        data-target="#editGroup-{{$group->id}}">
    Редактор
</button>
{{--END OF BUTTOM TO OPEN ADD NEW CATEGORY MODAL--}}

{{--ADD NEW CATEGORY MODAL--}}
<div id="editGroup-{{$group->id}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Изменить имя группы</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/products/update-group">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <div class="form-group">
                        <label for="category">
                            Категория:
                        </label>
                        <select class="form-control" id="category" name="category-id">
                            @foreach($categories AS $categoryItem)
                                @if($categoryItem->id === $category->id)
                                    <option value="{{$categoryItem->id}}" selected>{{$categoryItem->category}}</option>
                                @else
                                    <option value="{{$categoryItem->id}}">{{$categoryItem->category}}</option>
                                @endif
                            @endforeach
                         </select>
                        <label for="new-category">
                            Имя группы:
                        </label>
                        <input type="text" name="group-id" value="{{$group->id}}" hidden>
                        <input
                                type="text"
                                class="form-control"
                                name="group-name"
                                value="{{$group->group}}"
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