<!-- resources/views/components/card.blade.php -->
<div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
    <h3 class="text-xl font-semibold mb-4">{{ $title }}</h3>
    <p class="text-gray-600">{{ $slot }}</p>
</div>
