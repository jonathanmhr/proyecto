@props(['icon', 'route', 'label'])
<a href="{{ route($route) }}"
   class="flex items-center gap-3 text-gray-300 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg transition-all"
   :class="open ? 'justify-start w-full' : 'justify-center w-full'">
    <i data-feather="{{ $icon }}" class="w-5 h-5"></i>
    <span x-show="open" x-cloak class="text-sm ml-2 transition-opacity duration-200">{{ $label }}</span>
</a>
