<template>
    <div>
        <h1>Welcome {{ name }} ({{ email }})</h1>
        <button @click="logout">Logout</button>
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


