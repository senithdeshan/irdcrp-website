<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 rounded-2xl bg-emerald-600 border border-transparent text-sm font-semibold text-white uppercase tracking-[0.16em] shadow-sm shadow-emerald-600/20 transition duration-150 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:bg-emerald-800']) }}>
    {{ $slot }}
</button>
