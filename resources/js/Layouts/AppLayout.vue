<script setup>
import Footer from '@/Components/Layout/Footer.vue';
import Navbar from '@/Components/Layout/Navbar.vue';
import { Toaster } from 'vue-sonner';
import 'vue-sonner/style.css'



</script>

<template>
    <Toaster position="top-right" />
    <Navbar />

    <main>
        <slot />
    </main>

    <Footer />

</template>
