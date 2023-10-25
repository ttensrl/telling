<div>
    <div class="row">
        <div class="col-4">
            <select class="form-select" wire:model="selected_version_id" >
                @foreach($histories_table as $version)
                    <option value="{{ $version->version_id }}">{{ $version->created_at->formatLocalized('%A %d %B %Y %H:%M') }} - {{$version->getResponsibleUserAttribute()->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2">
            <button wire:click.prevent="$emitTo('diff-version', 'open', {{ $selected_version_id }})" class="btn btn-info">{{ __('bricks-telling::telling.show.select.button.label.show_version') }}</button>
        </div>
    </div>
    <div wire:ignore>
        <div class="modal fade" id="version-diff-modal" tabindex="-1" role="dialog"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <livewire:diff-version :list-of-field="$listOfField"/>
        </div>
    </div>
</div>



