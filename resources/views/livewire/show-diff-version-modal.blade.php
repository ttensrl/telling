<div class="modal-dialog modal-lg">
    @if($show)
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ __('bricks-telling::telling.show.diff.modal.title', ['version_date' => $version->created_at->formatLocalized('%A %d %B %Y %H:%M')]) }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="toggleModal()"></button>
        </div>
        <div class="modal-body">
            <table class="table">
                <tr>
                    <th></th>
                    <th>
                        {{ __('bricks-telling::telling.show.diff.modal.label.current_version') }} - {{$current->created_at->formatLocalized('%A %d %B %Y %H:%M')}}<br>
                    </th>
                    <th>
                        <select class="form-select" wire:model.lazy="version_id" >
                            @foreach($all_versions as $version)
                                <option value="{{ $version->version_id }}"
                                        @if($version->version_id == $version_id) selected @endif
                                >{{ $version->created_at->formatLocalized('%A %d %B %Y %H:%M') }} - {{$version->getResponsibleUserAttribute()->name}}</option>
                            @endforeach
                        </select>
                    </th>
                </tr>

            @foreach($listOfField as $label=>$field)
                @if(is_array($field) && array_key_exists('foreign_key', $field) && isset($field_version[$field['foreign_key']]))
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ $current->{$field['relation']}->{$field['field_name']} }}</td>
                        <td>{{ $field['class']::find($field_version[$field['foreign_key']])->{$field['field_name']} }}</td>
                    </tr>
                @elseif(is_array($field) && isset($field['helper']))
                    <tr>
                        <td>{{ $label }}:{{Str::upper($lan)}}</td>
                        <td>{{ $field_version[$field['helper']]($current) }}</td>
                        <td>{{ $field_version[$field['helper']]($field_version) ?? '' }}</td>
                    </tr>
                @elseif(is_string($field) && isset($field_version[$field]))
                    @if(in_array($field, $current->translatable))
                        @foreach($current->getTranslations($field) as $lan=>$value)
                        <tr>
                            <td>{{ $label }}:{{Str::upper($lan)}}</td>
                            <td>{{ $value }}</td>
                            <td>{{ $field_version[$field][$lan] ?? '' }}</td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ $current->{$field} }}</td>
                        <td>{{ $field_version[$field] }}</td>
                    </tr>
                    @endif
                @endif
            @endforeach
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="toggleModal()">{{ __('bricks-telling::telling.show.diff.modal.button.label.close') }}</button>
            @if(config('bricks-telling.enable_revert_function'))
                <button type="button" class="btn btn-primary" >{{ __('bricks-telling::telling.show.diff.modal.button.label.revert') }}</button>
            @endif
        </div>
    </div>
    @endif
</div>
