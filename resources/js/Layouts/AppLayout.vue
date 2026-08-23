<script setup>
import Flashtoast from '@/Components/Layout/Flashtoast.vue';
import Footer from '@/Components/Layout/Footer.vue';
import Navbar from '@/Components/Layout/Navbar.vue';





</script>

<template>
    <Flashtoast />
    <Navbar />

    <main>
        <slot />
    </main>

    <Footer />

</template>
