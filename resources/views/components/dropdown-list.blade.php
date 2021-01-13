@props(["items" => null, "selectedId" => ""])

<select {{ $attributes->merge(['class' => 'form-select block w-full']) }}>
    <option selected value="">{{ __('Select') }}</option>
    @foreach($items as $key => $value)
        <option value="{{ $key }}" {{ ($key === $selectedId) ? "selected" : "" }} >{{ $value }}</option>
    @endforeach
</select>
