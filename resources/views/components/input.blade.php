@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-800 file:text-yellow-400 hover:file:bg-gray-700']) !!}>
