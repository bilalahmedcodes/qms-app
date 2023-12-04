<div class="row">
    @if (count($categories) > 0)
        @foreach ($categories as $key => $category)
            <div class="title">
                <h4>{{ $key }}</h4>
            </div>
            <table class="table table-striped table-hover">
                @if (count($category) > 0)
                    @foreach ($category as $key => $item)
                        <tr>
                            <td class="w-25">{{ $item['datapoint']->name }}</td>
                            <td class="w-50">
                                {{ $item['datapoint']->question ?? '' }}
                                <small>{!! $item['datapoint']->description ?? '' !!}</small>
                            </td>
                            @foreach ($item['customFields'] as $customFields)
                                <td class="radios">
                                    @if ($customFields['customField']->type == 'radio')
                                        <div class="form-check-right form-check-inline qrating">
                                            <input type="radio" id="datapoint_id-{{ $customFields['customField']->id }}"
                                                value="{{ $customFields['customField']->values }}"
                                                data-id="{{ $item['datapoint']->customFields[0]->values }}"
                                                name="datapoint_id-{{ $customFields['customField']->datapoint_id }}"
                                                onclick="setCustomFieldId({{ $customFields['customField']->id }},{{ $customFields['customField']->datapoint_id }})"
                                                @foreach ($customFields['evPoints'] as $points) @if (
                                                    $customFields['customField']->values == $points->answer &&
                                                        $customFields['customField']->id == $points->custom_field_id) checked @endif @endforeach>
                                            <label class="form-check-label"
                                                for="">{{ $customFields['customField']->label }}
                                                <small>{{ $customFields['customField']->values }}</small>
                                            </label>
                                        </div>
                                    @endif
                                </td>
                                @foreach ($customFields['evPoints'] as $points)
                                    <input id="custom_field_id-{{ $points->datapoint_id }}" class="hid"
                                        type="hidden" name="custom_field_id-{{ $points->datapoint_id }}"
                                        value="{{ $points->custom_field_id }}">
                                @endforeach
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <td>No data points found!</td>
                @endif
            </table>
        @endforeach
    @else
        <td class="text-center">No records found</td>
    @endif
</div>
