<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-lg border border-transparent bg-[#FF2B2B] px-4 py-2.5 text-xs font-bold uppercase tracking-widest text-[#0D0D0D] shadow-lg shadow-[#FF2B2B]/10 transition duration-150 hover:bg-[#e51f25] focus:outline-none focus:ring-2 focus:ring-[#00A8FF] focus:ring-offset-2 focus:ring-offset-[#0D0D0D] active:scale-[0.98]']) }}>
    {{ $slot }}
</button>
