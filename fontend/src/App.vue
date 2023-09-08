<template>
    <header class="px-10 py-4 bg-teal-500">
        <div class="container flex items-center justify-between mx-auto">
            <div class="text-2xl font-bold text-white logo">Coding Test</div>
            <nav class="text-center sm:text-left">
                <router-link to="/" class="px-4 py-2 text-white hover:bg-teal-700">Login</router-link>
                <router-link to="/register" class="px-4 py-2 text-white hover:bg-teal-700">Register</router-link>
            </nav>
        </div>
    </header>

    <router-view />
</template>


<script setup>

</script>

<style scoped>

</style>
