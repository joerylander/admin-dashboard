 @props(['title', 'route'])

 <div id="createForm" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
     <article class="bg-gray-800 rounded-lg w-full max-w-lg p-8">
         <h3 class="text-xl font-bold text-white mb-4">Create New {{ ucfirst($title) }}</h3>
         <form method="POST" action="{{ route('portfolio.' . $route . '.store') }}">
             @csrf
             {{-- Fields required --}}
             {{ $slot }}

             <div class="flex space-x-3">
                 <button type="submit"
                     class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                     Create
                 </button>
                 <button type="button" onclick="hideCreateForm()"
                     class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                     Cancel
                 </button>
             </div>
         </form>
     </article>
 </div>

 <script>
     function hideCreateForm() {
         const modal = document.getElementById('createForm');
         if (!modal) {
             console.error('Element with id "createForm" not found');
             return;
         }
         modal.classList.add('hidden');
         modal.style.display = 'none';
     }
 </script>
