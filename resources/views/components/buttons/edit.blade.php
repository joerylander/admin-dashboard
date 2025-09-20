{{-- Paired together with edit form --}}
@props(['id'])

<button onclick="showEditForm({{ $id }})" class="text-blue-400 hover:text-blue-300">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
        </path>
    </svg>
</button>

<script>
    function showEditForm(id) {
        const modal = document.getElementById(`editForm${id}`);
        if (!modal) {
            console.error(`Element with id "editForm${id}" not found`);
            return;
        }
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
    }
</script>
