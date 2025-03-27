{{-- Custom Textarea Component --}}

@props([
    'name',
    'rows' => 3,
    'placeholder' => 'Say Somethng...',
])
<textarea
    name="{{ $name }}"
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"

>{{ $slot }}</textarea>
