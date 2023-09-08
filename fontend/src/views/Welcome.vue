<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="p-8 text-center bg-white rounded-lg shadow-md w-96">
            <h1 class="mb-4 text-2xl font-semibold">Welcome {{ name }} ({{ email }})</h1>
            <button @click="logout"
                class="px-4 py-2 font-semibold text-white transition duration-300 bg-red-500 rounded-lg hover:bg-red-600">Logout</button>
        </div>
    </div>
</template>

<script setup>
import router from '../router/index'

const name = localStorage.getItem("name");
const email = localStorage.getItem("email");

const logout = () => {
    localStorage.removeItem("accessToken");
    localStorage.removeItem("name");
    localStorage.removeItem("email");
    router.push({ name: 'login' });
}
</script>


