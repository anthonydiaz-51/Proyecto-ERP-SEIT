@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-lg border-gray-300 bg-[#0B1015] text-white shadow-sm focus:border-[#00A8FF] focus:ring-[#00A8FF]/30 disabled:cursor-not-allowed disabled:opacity-60']) }}>
