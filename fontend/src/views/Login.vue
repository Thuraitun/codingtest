<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="p-8 bg-white rounded-lg shadow-md w-96">
            <h1 class="mb-4 text-2xl font-semibold text-center">Login</h1>
            <form @submit="getLocation">
                <div class="mb-4">
                    <label for="email" class="block font-semibold text-gray-700">Email</label>
                    <input v-model="email" type="email" id="email" name="email" placeholder="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-red-300">
                </div>
                <div class="mb-4">
                    <label for="password" class="block font-semibold text-gray-700">Password</label>
                    <input v-model="password" type="password" id="password" name="password" placeholder="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-red-300">
                </div>
                <div class="mb-4">
                    <button type="submit"
                        class="w-full px-4 py-2 font-semibold text-white transition duration-300 bg-teal-500 rounded-lg hover:bg-teal-600">Login</button>
                </div>
            </form>
        </div>
    </div>
</template>




<script setup>
import { ref } from 'vue';
import axios from 'axios';
import router from '../router/index'

    const location = ref(null);
    const email = ref('');
    const password = ref('');


    const login = async () => {
        const reqData = {
            email: email.value,
            password: password.value,
            latitude: location.value.latitude,
            longitude: location.value.longitude
        }
        try {
            const { data } = await axios.post("http://127.0.0.1:8000/api/login", reqData);
            localStorage.setItem("accessToken", data.accessToken);
            localStorage.setItem("name", data.name);
            localStorage.setItem("email", data.email);
            router.push({ name: 'welcome' });

        } catch (error) {
            if (error.message === 'Request failed with status code 401') {
                alert("Wrong Password !!")
            }
        }
    }

    const getLocation = (e) => {
        e.preventDefault();
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition((position) => {
                location.value = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                };
                if (location.value) {
                    login();
                }
            });
        } else {
            alert("Geolocation is not supported in your browser");
        }
    };

</script>
