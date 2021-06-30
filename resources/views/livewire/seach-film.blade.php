<div>

    <div class="form-outline">
        <input type="text" id="form1" wire:model="search" class="form-control" />
        <label class="form-label" for="form1">Search</label>
    </div>
    @if($films)
        {{ $films->first()->name }}
    @endif

</div>
