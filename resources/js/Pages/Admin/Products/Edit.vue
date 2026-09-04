<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
defineOptions({
    layout: AdminLayout
})

const props = defineProps({
    product : Object,
    categories : Object,
    filters: Object,
})

const categories = props.categories
const product = props.product.data
const filters = props.filters ?? {}


const form = useForm({
  title: product.title,
  author: product.author,
  category_id: product.category.id,
  price: product.price,
  stock: product.stock,
  description: product.description,
  image: null
})



const coverPreview = ref(`/storage/${product.image_path}`)

const onCoverChange = (e) => {
  const file = e.target.files[0]
  if (!file) return
  form.image = file
  coverPreview.value = URL.createObjectURL(file)
}

const saveBook = () => {
  form.put(route('admin.products.update', {
    product: product.slug,
    page: filters.page,
    search: filters.search,
    category: filters.category,
  }))
}

const deleteBook = () => {
  if (!confirm('Delete this book? This cannot be undone.')) return
  router.delete(route('admin.products.destroy', {
    product: product.slug,
    page: filters.page,
    search: filters.search,
    category: filters.category,
  }), {
    preserveState: false,
    preserveScroll: true,
  })
}
</script>

<template>



    <Link :href="route('admin.products.index', filters)" class="text-sm font-medium text-[#1B1B1F]/60 hover:text-[#B08D57]">
      ← Back to books
    </Link>

    <form @submit.prevent="saveBook" class="mt-4 grid gap-6 lg:grid-cols-3">
      <!-- Left: form fields -->
      <div class="space-y-6 lg:col-span-2">
        <div class="rounded-2xl border border-black/10 bg-white p-6">
          <h2 class="font-serif text-base font-semibold">Details</h2>
          <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <label class="sm:col-span-2">
              <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Title</span>
              <input
                v-model="form.title"
                type="text"
                required
                class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]"
              />
            </label>

            <label>
              <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Author</span>
              <input
                v-model="form.author"
                type="text"
                required
                class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]"
              />
            </label>

            <label>
              <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Category</span>
              <select
                v-model="form.category_id"
                class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]"
              >
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
              </select>
            </label>

            <label>
              <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Price (₱)</span>
              <input
                v-model.number="form.price"
                type="number"
                step="0.01"
                min="0"
                required
                class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]"
              />
            </label>

            <label>
              <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Stock</span>
              <input
                v-model.number="form.stock"
                type="number"
                min="0"
                required
                class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]"
              />
            </label>

            <label class="sm:col-span-2">
              <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Description</span>
              <textarea
                v-model="form.description"
                rows="5"
                class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]"
              />
            </label>
          </div>
        </div>
      </div>

      <!-- Right: cover + actions -->
      <aside class="h-fit space-y-6">
        <div class="rounded-2xl border border-black/10 bg-white p-6">
          <h2 class="font-serif text-base font-semibold">Cover</h2>

          <div class="mt-4 flex aspect-[3/4] w-full items-center justify-center overflow-hidden rounded-xl" :class="!coverPreview ? form.color : ''">
            <img v-if="coverPreview" :src="coverPreview" alt="Cover preview" class="h-full w-full object-cover" />
            <span v-else class="px-4 text-center font-serif text-sm font-semibold leading-snug text-white">
              {{ form.title }}
            </span>
          </div>

          <label class="mt-4 block cursor-pointer rounded-lg border border-black/10 px-4 py-2 text-center text-sm font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]">
            Upload cover image
            <input type="file" accept="image/*" class="hidden" @change="onCoverChange" />
          </label>
        </div>

        <div class="rounded-2xl border border-black/10 bg-white p-6">
          <button
            type="submit"
            class="w-full rounded-full bg-[#1B1B1F] py-2.5 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]"
          >
            Save changes
          </button>
          <button
            type="button"
            @click="deleteBook"
            class="mt-3 w-full rounded-full border border-black/10 py-2.5 text-sm font-medium text-[#8C3B3B] transition hover:border-[#8C3B3B] hover:bg-[#8C3B3B]/10"
          >
            Delete book
          </button>
        </div>
      </aside>
    </form>

</template>
