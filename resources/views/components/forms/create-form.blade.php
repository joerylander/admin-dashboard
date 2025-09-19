 @props(['title', 'route'])

 <div id="createForm" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
     <article class="bg-gray-800 rounded-lg w-full max-w-lg p-8">
         <h3 class="text-xl font-bold text-white mb-4">Create New {{ ucfirst($title) }}</h3>
         <form method="POST" action="{{ route('portfolio.' . $route . '.store') }}">
             @csrf
             <div class="mb-4">
                 <label class="block text-sm font-medium text-gray-300 mb-2">Title</label>
                 <input type="text" name="title" placeholder="Enter title" value="{{ old('title') }}" required
                     class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500">
             </div>
             <div class="mb-6">
                 <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                 <textarea name="description" placeholder="Enter description (minimum 20 characters)" required
                     class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 h-24">{{ old('description') }}</textarea>
             </div>
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
             console.error(modal);
             return
         }
         modal.classList.add('hidden');
         modal.style.display = 'none';
     }
 </script>
