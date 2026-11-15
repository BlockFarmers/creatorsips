<form action="{{ route('creatorsips.admin.ips.destroy', $creatorIp) }}" method="POST" class="d-inline"
      data-message="{{ trans('creatorsips::admin.ips.delete_confirm', ['hostname' => $creatorIp->hostname]) }}"
      onsubmit="return confirm(this.dataset.message)">
    @csrf
    @method('DELETE')

    <button type="submit" class="{{ $class ?? 'btn btn-link text-danger p-0 mx-1' }}" title="{{ trans('creatorsips::admin.actions.delete') }}">
        <i class="bi bi-trash"></i>
        @isset($label)
            {{ $label }}
        @endisset
    </button>
</form>
