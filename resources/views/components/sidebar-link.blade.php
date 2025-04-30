<!-- resources/views/components/sidebar-link.blade.php -->
@props(['href', 'icon', 'label', 'expanded'])

<a href="{{ $href }}" class="flex items-center p-3 rounded-md hover:bg-gray-100 transition-all">
    <x-lucide-icon :name="$icon" class="w-5 h-5 text-gray-700" />
    <span x-show="{{ $expanded ?? 'true' }}" class="ml-3 whitespace-nowrap">{{ $label }}</span>
</a>
