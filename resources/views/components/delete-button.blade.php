<form id="deleteForm{{ $id }}" action="{{ $route }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger delete-btn" data-form-id="deleteForm{{ $id }}"
        data-item-name="{{ $itemName }}">
        <i class="fa fa-trash"></i>
    </button>
</form>
