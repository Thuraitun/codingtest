<template>
    <div>
        <form @submit="getLocation">
            <input v-model="email" type="email" placeholder="email" required>
            <input v-model="name" type="text" placeholder="name" required>
            <input v-model="password" type="password" placeholder="password" required>
            <input v-model="confrimPassword" type="password" placeholder="confirm password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import router from '../router/index'

    const location = ref(null);
    const email = ref('');
    const name = ref('');
    const password = ref('');
    const confrimPassword = ref('')


    const register = async () => {
        const reqData = {
            email: email.value,
            password: password.value,
            latitude: location.value.latitude,
            longitude: location.value.longitude,
            name: name.value
        }
        try {
            const { data } = await axios.post("http://127.0.0.1:8000/api/register", reqData);
            console.log(data);
            email.value = '';
            name.value = '';
            password.value = '',
            confrimPassword.value = '',
            location.value = null;

            router.push({ name: 'login' });
        } catch (error) {
            console.log(error);
        }
    }

    const getLocation = (e) => {
        e.preventDefault();
        if (password.value !== confrimPassword.value) {
            alert("password and confrim password do not match!");
            return;
        }
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition((position) => {
                location.value = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                };
                if (location.value) {
                    register();
                }
            });
        } else {
            alert("Geolocation is not supported in your browser");
        }
    };

</script>
