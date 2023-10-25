<div>
    <div class="card" >
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>{{ __('bricks-telling::telling.show.table.card.title') }}</h3>
        </div>
        <div class="container-fluid">
            <div class="row mb-2 mt-2"></div>

            <table class="card-table table table-sm table-bordered table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">{{ __('bricks-telling::telling.show.table.caption.edit_by') }}</th>
                    <th scope="col">{{ __('bricks-telling::telling.show.table.caption.on_date') }}</th>
                    <th scope="col">{{ __('bricks-telling::telling.show.table.caption.reasons') }}</th>
                    @if(config('bricks-telling.enable_revert_function'))<th scope="col">{{ __('bricks-telling::telling.show.table.caption.actions') }}</th>@endif
                </tr>
                </thead>
                <tbody>
                @foreach($histories_table as $history)
                    @if($loop->first)
                    <tr class="bg-black text-white">
                    @else
                    <tr wire:click.prevent="$emitTo('diff-version', 'open', {{ $history->version_id }})">
                    @endif
                        <td>{{ $history->getResponsibleUserAttribute()->name }}</td>
                        <td>{{ $history->created_at->formatLocalized('%A %d %B %Y %H:%M') }}</td>
                        <td>{{ $history->reason }}</td>
                        @if(config('bricks-telling.enable_revert_function'))
                        <td>
                            @if(count($current->diff($history)) != 0)
                                {{ __('bricks-telling::telling.show.table.button.label.revert') }}
                            @endif
                        </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $histories_table->links() }}
        </div>
    </div>
    <div wire:ignore>
        <div class="modal fade" id="version-diff-modal" tabindex="-1" role="dialog"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <livewire:diff-version :list-of-field="$listOfField"/>
        </div>
    </div>
</div>



