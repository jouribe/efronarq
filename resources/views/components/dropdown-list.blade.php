@props(["items" => null, "selectedId" => ""])

<select class="form-select block w-full" {{ $attributes }}>
    <option selected value="">{{ __('Select') }}</option>
    @foreach($items as $key => $value)
        <option value="{{ $key }}" {{ ($key === $selectedId) ? "selected" : "" }} >{{ $value }}</option>
    @endforeach
</select>
