
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
                                                    <input type="radio"
                                                        value="{{ $customFields['customField']->values }}"
                                                        @foreach ($customFields['evPoints'] as $points)
                                                            @if (
                                                                $customFields['customField']->values == $points->answer &&
                                                                    $customFields['customField']->id == $points->custom_field_id)
                                                                checked
                                                            @endif @endforeach>
                                                    <label class="form-check-label"
                                                        for="">{{ $customFields['customField']->label }}
                                                    </label>
                                                </div>
                                            @endif
                                        </td>
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

