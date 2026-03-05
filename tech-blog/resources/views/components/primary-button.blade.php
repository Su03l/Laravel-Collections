<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-brutal']) }}>
    {{ $slot }}
</button>