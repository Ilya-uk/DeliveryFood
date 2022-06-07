@component('mail::message')
{{-- Greeting --}}
<h1>Здраствуйте!</h1>

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset
{{-- Subcopy --}}
{{--@isset($actionText)--}}
{{--@slot('subcopy')--}}

{{--@endslot--}}
{{--@endisset--}}
{{-- Outro Lines --}}
@foreach ($outroLines as $line)
    {{ $line }}
@endforeach
<br>
<div class="text-center">
    <p style="text-align: center;">Доставка еды «Доставка»</p>
    <p style="text-align: center;">450077, г. Уфа, ул. Ленина, д.5</p>
    <p style="text-align: center;">Наш телефон +7 (999) 999 9999</p>
</div>
{{-- Salutation --}}
{{--@if (! empty($salutation))--}}
{{--{{ $salutation }}--}}
{{--@else--}}
{{--@lang('Regards'),<br>--}}
{{--{{ config('app.name') }}--}}
{{--@endif--}}

{{-- Subcopy --}}
{{--@isset($actionText)--}}
{{--@slot('subcopy')--}}

{{--@endslot--}}
{{--@endisset--}}
@endcomponent

