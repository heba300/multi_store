@props(['name', 'option', 'checked' => false])

@foreach ($option as $value => $text)
    <div class="form-check">
        <input type="radio" value="{{ $value }}" name="{{ $name }}" @checked(old($name, $checked) == $value)
            {{ $attributes->class(['form-check-input', 'is-invalid' => $errors->has($name)]) }}>
        <label class="form-check-label">
            {{ $text }}
        </label>
    </div>
@endforeach
