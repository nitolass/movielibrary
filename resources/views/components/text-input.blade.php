@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-700 bg-gray-900 text-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm']) !!}>
