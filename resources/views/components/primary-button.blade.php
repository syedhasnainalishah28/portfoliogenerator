<button {{ $attributes->merge(['type' => 'submit', 'class' => 'ha-btn inline-flex items-center px-4 py-2 text-xs uppercase tracking-widest']) }}>
    {{ $slot }}
</button>
