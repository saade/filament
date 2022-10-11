<button
    type="button"
    {{ $attributes->class([
        'filament-tables-reorder-handle text-gray-500 cursor-move transition group-hover:text-primary-500',
        'dark:text-gray-400 dark:group-hover:text-primary-400' => config('tables.dark_mode'),
    ]) }}
>
    <x-heroicon-o-bars-3 class="block h-4 w-4" />
</button>
