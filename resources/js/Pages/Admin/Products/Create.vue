<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue'
import { router, useForm } from "@inertiajs/vue3";

defineOptions({
    layout: AdminLayout
})

const props = defineProps({
    categories: Object
})

// In your real app this comes from an Inertia prop, e.g.
// defineProps({ categories: Array })
const categories = props.categories

const form = useForm({
    title: '',
    author: '',
    description: '',
    price: null,
    stock: null,
    category_id: '',
    image: null
})


const coverPreview = ref(null)

const onCoverChange = (e) => {
    const file = e.target.files[0]
    if (!file) return
    form.image = file
    coverPreview.value = URL.createObjectURL(file)
}

const createBook = () => {
    if (form.image === null) {
        form.setError('image', 'Please select a image.')
        return
    }
    form.post(route('admin.products.store'))
}
</script>

<template>



    <a href="/admin/products" class="text-sm font-medium text-[#1B1B1F]/60 hover:text-[#B08D57]">
        ← Back to books
    </a>

    <form @submit.prevent="createBook" class="mt-4 grid gap-6 lg:grid-cols-3">
        <!-- Left: form fields -->
        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-2xl border border-black/10 bg-white p-6">
                <h2 class="font-serif text-base font-semibold">Details</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="sm:col-span-2">
                        <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Title</span>
                        <input v-model="form.title" type="text" required placeholder="e.g. The Long Tide"
                            class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]" />
                    </label>

                    <label>
                        <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Author</span>
                        <input v-model="form.author" type="text" required placeholder="e.g. Marta Ilves"
                            class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]" />
                    </label>

                    <label>
                        <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Category</span>
                        <select v-model="form.category_id" required
                            class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]">
                            <option value="" disabled>Select a category</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                        </select>
                    </label>

                    <label>
                        <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Price (₱)</span>
                        <input v-model.number="form.price" type="number" step="0.01" min="0" required placeholder="0.00"
                            class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]" />
                    </label>

                    <label>
                        <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Stock</span>
                        <input v-model.number="form.stock" type="number" min="0" required placeholder="0"
                            class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]" />
                    </label>

                    <label class="sm:col-span-2">
                        <span class="text-xs font-medium uppercase tracking-wide text-[#1B1B1F]/50">Description</span>
                        <textarea v-model="form.description" required rows="5"
                            placeholder="A short summary of the book..."
                            class="mt-1.5 w-full rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-[#B08D57]" />
                    </label>
                </div>
            </div>
        </div>

        <!-- Right: cover + actions -->
        <aside class="h-fit space-y-6">
            <div class="rounded-2xl border border-black/10 bg-white p-6">
                <h2 class="font-serif text-base font-semibold">Cover</h2>

                <div
                    class="mt-4 flex aspect-[3/4] w-full items-center justify-center overflow-hidden rounded-xl bg-slate-800">
                    <img v-if="coverPreview" :src="coverPreview" alt="Cover preview"
                        class="h-full w-full object-cover" />
                    <span v-else class="px-4 text-center font-serif text-sm font-semibold leading-snug text-white">
                        {{ form.title || 'Book title' }}
                    </span>

                </div>
                <p v-if="form.errors.image" class="mt-1 text-sm text-red-500">
                    {{ form.errors.image }}
                </p>
                <label
                    class="mt-4 block cursor-pointer rounded-lg border border-black/10 px-4 py-2 text-center text-sm font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]">
                    Upload cover image
                    <input type="file" accept="image/*" class="hidden" @change="onCoverChange" />
                </label>
            </div>

            <div class="rounded-2xl border border-black/10 bg-white p-6">
                <button type="submit"
                    class="w-full rounded-full bg-[#1B1B1F] py-2.5 text-sm font-medium text-[#F7F2E7] transition hover:bg-[#B08D57]">
                    Add book
                </button>
                <a href="/admin/books"
                    class="mt-3 block w-full rounded-full border border-black/10 py-2.5 text-center text-sm font-medium transition hover:border-[#B08D57] hover:text-[#B08D57]">
                    Cancel
                </a>
            </div>
        </aside>
    </form>

</template>
