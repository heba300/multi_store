@props(['name', 'options', 'label' => '', 'value' => ''])

@if ($label)
    <label for="" class="form-label">{{ $label }}</label>
@endif

<select name="{{ $name }}" id=""
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>
    <option value=""></option>
    @foreach ($options as $v => $text)
        <option value="{{ $v }}" @selected($v == old($name, $value))>{{ $text }}</option>
    @endforeach
</select>
