import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Welcome from '../views/Welcome.vue'



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: Login
    },
    {
      path: '/register',
      name: 'register',
      component: Register
      },
        {
      path: '/welcome',
      name: 'welcome',
      component: Welcome,
      meta: { requiresAuth: true },
    }
  ]
})

router.beforeEach((to, from, next) => {
  const accessToken = localStorage.getItem("accessToken");
  if (to.meta.requiresAuth) {
    // Check if the route requires authentication
    if (accessToken) {
      // User is authenticated, allow navigation
      next();
    } else {
      // User is not authenticated, redirect to the login page
      next({ name: 'login' }); // Replace 'Login' with your login route
    }
  } else {
    // Route does not require authentication, allow navigation
    next();
  }
});

export default router
