@php
/**
 * @var string $value
 */
$value = isset($value) ? (array)$value : [];
@endphp
@if($compatibilities)
    <ul>
        @foreach($compatibilities as $compatibility)
            @if($compatibility->id != $currentId)
                <li value="{{ $compatibility->id ?? '' }}"
                        {{ $compatibility->id == $value ? 'selected' : '' }}>
                    {!! Form::customCheckbox([
                        [
                            $name, $compatibility->id, $compatibility->name, in_array($compatibility->id, $value),
                        ]
                    ]) !!}
                </li>
            @endif
        @endforeach
    </ul>
@endif
