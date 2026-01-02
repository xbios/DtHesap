@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 border-2 border-neutral-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 rounded-xl shadow-sm bg-white text-neutral-900 placeholder-neutral-400 disabled:bg-neutral-50 disabled:text-neutral-500 transition-all duration-200']) }}>