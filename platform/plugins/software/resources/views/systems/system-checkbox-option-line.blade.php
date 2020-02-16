@php
/**
 * @var string $value
 */
$value = isset($value) ? (array)$value : [];
@endphp
@if($systems)
    <ul>
        @foreach($systems as $system)
            @if($system->id != $currentId)
                <li value="{{ $system->id ?? '' }}"
                        {{ $system->id == $value ? 'selected' : '' }}>
                    {!! Form::customCheckbox([
                        [
                            $name, $system->id, $system->name, in_array($system->id, $value),
                        ]
                    ]) !!}
                </li>
            @endif
        @endforeach
    </ul>
@endif
