@props(['icon', 'route', 'label'])

<a href="{{ route($route) }}"
    class="flex items-center gap-3 text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg transition-all group-hover:justify-start">
    <i data-feather="{{ $icon }}" class="w-5 h-5"></i>
    <span class="hidden sm:inline text-sm">{{ $label }}</span>
</a>
