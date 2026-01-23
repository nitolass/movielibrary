@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder-gray-600 resize-none']) !!}>{{ $slot }}</textarea>
