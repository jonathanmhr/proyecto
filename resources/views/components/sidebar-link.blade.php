@props(['icon', 'route', 'label'])

<a href="{{ route($route) }}"
   class="group flex items-center gap-3 text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg transition-all">
    <i data-feather="{{ $icon }}" class="w-5 h-5"></i>
    <span class="hidden group-hover:inline text-sm">{{ $label }}</span>
</a>
