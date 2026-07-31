<script setup>
import Footer from '@/Components/Layout/Footer.vue';
import Navbar from '@/Components/Layout/Navbar.vue';



</script>

<template>
    <Navbar />

    <main>
        <slot />
    </main>

    <Footer />

</template>
