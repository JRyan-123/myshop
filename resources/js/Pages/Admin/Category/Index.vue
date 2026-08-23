<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, computed } from 'vue'


defineOptions({
    layout: AdminLayout
})
// In your real app this comes from an Inertia prop, e.g.
// defineProps({ categories: Array })
const categories = ref([
  { id: 1, name: 'Fiction', bookCount: 482, color: 'bg-[#5B7B6E]' },
  { id: 2, name: 'Mystery', bookCount: 216, color: 'bg-[#8C3B3B]' },
  { id: 3, name: 'Romance', bookCount: 349, color: 'bg-[#B08D57]' },
  { id: 4, name: 'Sci-Fi', bookCount: 190, color: 'bg-[#3B4C63]' },
  { id: 5, name: 'Biography', bookCount: 127, color: 'bg-[#6B5B95]' },
  { id: 6, name: 'Poetry', bookCount: 88, color: 'bg-[#2F4538]' },
])

const search = ref('')
const filteredCategories = computed(() =>
  categories.value.filter((c) => c.name.toLowerCase().includes(search.value.toLowerCase()))
)

// Add category
const newName = ref('')
const showAddForm = ref(false)

function addCategory() {
  if (!newName.value.trim()) return
  // Replace with router.post('/admin/categories', { name: newName.value })
  categories.value.push({
    id: Date.now(),
    name: newName.value.trim(),
    bookCount: 0,
    color: 'bg-[#B08D57]',
  })
  newName.value = ''
  showAddForm.value = false
}

// Inline rename
const editingId = ref(null)
const editValue = ref('')

function startEdit(cat) {
  editingId.value = cat.id
  editValue.value = cat.name
}

function saveEdit(cat) {
  if (editValue.value.trim()) {
    // Replace with router.patch(`/admin/categories/${cat.id}`, { name: editValue.value })
    cat.name = editValue.value.trim()
  }
  editingId.value = null
}

function deleteCategory(id) {
  // Replace with a confirm dialog + router.delete(`/admin/categories/${id}`)
  categories.value = categories.value.filter((c) => c.id !== id)
}
</script>

<template>

    <template >
      <h1 class="font-serif text-lg font-semibold">Categories</h1>
    </template>

    <!-- Toolbar -->
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
      <input
        v-model="search"
        type="text"
        placeholder="Search categories..."
        class="w-56 rounded-lg border border-black/10 bg-white px-4 py-2 text-sm outline-none transition focus:border-[#B08D57]"
      />

      <button
        @click="showAddForm = !showAddForm"
        class="rounded-full bg-[#1B1B1F] px-5 py-2.5 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]"
      >
        + Add category
      </button>
    </div>

    <!-- Add form -->
    <div
      v-if="showAddForm"
      class="mb-5 flex flex-wrap items-center gap-3 rounded-2xl border border-black/10 bg-white p-4"
    >
      <input
        v-model="newName"
        @keyup.enter="addCategory"
        type="text"
        placeholder="Category name"
        class="flex-1 rounded-lg border border-black/10 bg-white px-4 py-2 text-sm outline-none transition focus:border-[#B08D57]"
      />
      <button
        @click="addCategory"
        class="rounded-full bg-[#1B1B1F] px-5 py-2 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]"
      >
        Save
      </button>
      <button
        @click="showAddForm = false"
        class="rounded-full border border-black/10 px-5 py-2 text-sm font-medium transition hover:border-[#8C3B3B] hover:text-[#8C3B3B]"
      >
        Cancel
      </button>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-2xl border border-black/10 bg-white">
      <table class="w-full text-left text-sm">
        <thead class="border-b border-black/10 bg-black/[0.02]">
          <tr class="text-xs uppercase tracking-wide text-[#1B1B1F]/50">
            <th class="px-5 py-3 font-medium">Category</th>
            <th class="px-5 py-3 font-medium">Books</th>
            <th class="px-5 py-3 font-medium text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
          <tr v-for="cat in filteredCategories" :key="cat.id">
            <td class="px-5 py-3">
              <div class="flex items-center gap-3">
                <span :class="cat.color" class="h-3 w-3 shrink-0 rounded-full" />
                <input
                  v-if="editingId === cat.id"
                  v-model="editValue"
                  @keyup.enter="saveEdit(cat)"
                  @blur="saveEdit(cat)"
                  type="text"
                  class="rounded-lg border border-[#B08D57] bg-white px-2 py-1 text-sm outline-none"
                  autofocus
                />
                <span v-else class="font-medium">{{ cat.name }}</span>
              </div>
            </td>
            <td class="px-5 py-3 text-[#1B1B1F]/70">{{ cat.bookCount }}</td>
            <td class="px-5 py-3">
              <div class="flex justify-end gap-2">
                <button
                  @click="startEdit(cat)"
                  class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]"
                >
                  Rename
                </button>
                <button
                  @click="deleteCategory(cat.id)"
                  class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-medium text-[#8C3B3B] transition hover:border-[#8C3B3B] hover:bg-[#8C3B3B]/10"
                >
                  Delete
                </button>
              </div>
            </td>
          </tr>

          <tr v-if="!filteredCategories.length">
            <td colspan="3" class="px-5 py-10 text-center text-sm text-[#1B1B1F]/50">
              No categories match your search.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <p class="mt-4 text-sm text-[#1B1B1F]/50">
      Showing {{ filteredCategories.length }} of {{ categories.length }} categories
    </p>

</template>
