@props(['title'])

<header class="mb-8 flex justify-between items-center">
    <h1 class="text-4xl font-bold text-white">{{ ucfirst($title) }}s</h1>
    <button onclick="showCreateForm()"
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
        Add New {{ ucfirst($title) }}
    </button>

</header>

<script>
    function showCreateForm() {
        const modal = document.getElementById('createForm');
        if (!modal) {
            console.error('Element with id "createForm" not found');
            return;
        }
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
    }
</script>
