@if (session('success'))
    <div id="flash" class="p-4 text-center bg-green-50 text-green-500 font-bold">
        {{ session('success') }}
    </div>
@endif


<script>
    // Auto-hide flash messages after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flash');
        if (flashMessage) {
            setTimeout(function() {
                flashMessage.style.transition = 'opacity 0.5s ease-out';
                flashMessage.style.opacity = '0';
                setTimeout(function() {
                    flashMessage.remove();
                }, 500); // Remove after fade out completes
            }, 3000); // Hide after 3 seconds
        }
    });
</script>
