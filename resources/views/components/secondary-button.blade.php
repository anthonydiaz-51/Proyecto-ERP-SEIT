<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center rounded-lg border border-[#00A8FF]/30 bg-[#111820] px-4 py-2.5 text-xs font-bold uppercase tracking-widest text-white shadow-sm transition duration-150 hover:border-[#00A8FF]/70 hover:bg-[#00A8FF]/10 focus:outline-none focus:ring-2 focus:ring-[#00A8FF] focus:ring-offset-2 focus:ring-offset-[#0D0D0D] disabled:opacity-25']) }}>
    {{ $slot }}
</button>
