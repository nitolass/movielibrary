<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-6 py-3 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 transition-colors shadow-[0_0_15px_rgba(250,204,21,0.4)] disabled:opacity-50']) }}>
    {{ $slot }}
</button>
