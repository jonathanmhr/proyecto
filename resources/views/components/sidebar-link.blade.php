@props(['icon', 'route', 'label'])
<a href="{{ route($route) }}"
   class="flex items-center gap-3 text-gray-300 hover:bg-cyan-800 hover:text-white px-3 py-2 rounded-lg transition-all" {{-- CAMBIADO: text-gray-300, hover:bg-orange-700, hover:text-red-500 --}}
   :class="open ? 'justify-start w-full' : 'justify-center w-full'">
    <i data-feather="{{ $icon }}" class="w-5 h-5"></i> {{-- ICONO TAL CUAL LO TIENES --}}
    <span x-show="open" x-cloak class="text-sm ml-2 transition-opacity duration-200">{{ $label }}</span>
</a>