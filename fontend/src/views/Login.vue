<template>
    <div>
        <form @submit="getLocation">
            <input v-model="email" type="text" placeholder="email" required>
            <input v-model="password" type="password" placeholder="password" required>
            <button type="submit">Login</button>
        </form>
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
