@php
/**
 * @var string $value
 */
$value = isset($value) ? (array)$value : [];
@endphp
@if($languages)
    <ul>
        @foreach($languages as $language)
            @if($language->id != $currentId)
                <li value="{{ $language->id ?? '' }}"
                        {{ $language->id == $value ? 'selected' : '' }}>
                    {!! Form::customCheckbox([
                        [
                            $name, $language->id, $language->name, in_array($language->id, $value),
                        ]
                    ]) !!}
                </li>
            @endif
        @endforeach
    </ul>
@endif
