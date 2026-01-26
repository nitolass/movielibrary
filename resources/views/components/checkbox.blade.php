@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded border-gray-700 bg-[#16181c] text-yellow-400 shadow-sm focus:ring-yellow-400 focus:ring-offset-gray-900']) !!} type="checkbox">
