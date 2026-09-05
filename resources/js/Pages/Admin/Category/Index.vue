<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, computed, watch } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import Pagination from '@/Components/Products/Pagination.vue'
import Search from '@/Components/Admin/Search.vue'


defineOptions({
  layout: AdminLayout
})
const props = defineProps({
  categories: Object,
  filters: Object
})

const categories = computed(() => props.categories.data)

const search = ref(props.filters?.search ?? '')

let searchTimeout
watch(search, () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('admin.categories.index'),
      { search: search.value || undefined }, {
      preserveState: true,
      preserveScroll: true,
      replace: true,
    })
  }, 300)
})

const form = useForm({
  name: ''
})

const editForm = useForm({
  name: ''
})

const showAddForm = ref(false)

const addCategory = () => {
  form.post(route('admin.categories.store'), {
    onSuccess: () => {
      form.reset()
      showAddForm.value = false
    }
  })
}

// Inline rename
const editingId = ref(null)

const startEdit = (cat) => {
  editingId.value = cat.id
  editForm.name = cat.name
}

const saveEdit = (cat) => {
  editForm.put(route('admin.categories.update', cat.id), {
    onSuccess: () => {
      editingId.value = null
      editForm.reset()
    }
  })
}

const deleteCategory = (id) => {
  if (!confirm('Delete this category? This cannot be undone.')) return
  router.delete(route('admin.categories.destroy', id))
}
</script>

<template>

  <!-- Toolbar -->
  <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <Search v-model="search" placeholder="Search categories..." />
    <button @click="showAddForm = !showAddForm"
      class="rounded-full bg-[#1B1B1F] px-5 py-2.5 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
      + Add category
    </button>
  </div>

  <!-- Add form -->
  <div v-if="showAddForm"
    class="mb-5 flex flex-wrap items-center gap-3 rounded-2xl border border-black/10 bg-white p-4">

    <form @submit.prevent="addCategory" class="flex w-full items-center gap-3">
      <input v-model="form.name" type="text" placeholder="Category name"
        class="flex-1 rounded-lg border border-black/10 bg-white px-4 py-2 text-sm outline-none transition focus:border-[#B08D57]" />
      <p v-if="form.errors.name" class="w-full text-sm text-red-600">{{ form.errors.name }}</p>
      <button type="submit"
        class="rounded-full bg-[#1B1B1F] px-5 py-2 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
        Save
      </button>
      <button @click="showAddForm = false"
        class="rounded-full border border-black/10 px-5 py-2 text-sm font-medium transition hover:border-[#8C3B3B] hover:text-[#8C3B3B]">
        Cancel
      </button>
    </form>
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
        <tr v-for="cat in categories" :key="cat.id">
          <td class="px-5 py-3">
            <div class="flex items-center gap-3">
              <span :class="cat.color" class="h-3 w-3 shrink-0 rounded-full" />
              <input v-if="editingId === cat.id" v-model="editForm.name" @keyup.enter="saveEdit(cat)"
                @blur="saveEdit(cat)" type="text"
                class="rounded-lg border border-[#B08D57] bg-white px-2 py-1 text-sm outline-none" autofocus />
              <span v-if="editingId === cat.id && editForm.errors.name" class="text-sm text-red-600">
                {{ editForm.errors.name }}
              </span>
              <span v-else class="font-medium">{{ cat.name }}</span>
            </div>
          </td>
          <td class="px-5 py-3 text-[#1B1B1F]/70">
            {{ cat.products_count }} {{ cat.products_count === 1 ? 'book' : 'books' }}
          </td>
          <td class="px-5 py-3">
            <div class="flex justify-end gap-2">
              <button @click="startEdit(cat)"
                class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]">
                Rename
              </button>
              <button @click="deleteCategory(cat.id)"
                class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-medium text-[#8C3B3B] transition hover:border-[#8C3B3B] hover:bg-[#8C3B3B]/10">
                Delete
              </button>
            </div>
          </td>
        </tr>

        <tr v-if="!categories.length">
          <td colspan="3" class="px-5 py-10 text-center text-sm text-[#1B1B1F]/50">
            No categories match your search.
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <p class="mt-4 text-sm text-[#1B1B1F]/50">
    Showing {{ categories.length }} of {{ props.categories.total }} categories
  </p>
  <Pagination :metaLinks="props.categories.links" class="mt-4" />
</template>
