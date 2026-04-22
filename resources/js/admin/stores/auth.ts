import { defineStore } from "pinia"
import { computed, ref } from "vue";
import { User } from "../types/user-interfaces/User";
import { AuthService } from "../services/auth.service";
import { LoginRequest } from "../types/auth-interfaces/LoginRequest";
import router from "../app/router";

// stores/auth.ts
export const useAuthStore = defineStore('auth', () => {
    // --- State ---
    const user = ref<User | null>(null);
    const token = ref<String | null>(null);
    const loading = ref(false);
    const initialized = ref(false);

    // --- Getters ---
    const isAuthenticated = computed(() => !!token.value && !!user.value);
    const userRole = computed(() => user.value?.role || 0);

    // --- Actions ---
    async function login(credentials: LoginRequest) {
        loading.value = true
        try {
            const authService = new AuthService()
            const response = await authService.login(credentials)

            // Response structure: { status, message, data: { user, access_token, token_type } }
            token.value = response.data.access_token
            user.value = response.data.user
        } finally {
            loading.value = false
        }
    }

    /**
     * Clear auth state without calling API (used by interceptor to avoid loops)
     */
    function clearAuth() {
        user.value = null;
        token.value = null;
        localStorage.removeItem('auth');

        router.push({ name: "login" });
    }

    async function logout() {
        try {
            const authService = new AuthService()
            await authService.logout()
        } catch (error) {
            console.error('Logout error:', error)
        } finally {
            // Always clear local state even if API call fails
            clearAuth()
        }
    }

    /**
     * Fetch current authenticated user (used for initialization)
     */
    async function fetchMe() {
        if (!token.value) {
            initialized.value = true
            return
        }

        try {
            const authService = new AuthService()
            const response = await authService.me()

            // Backend returns: { status, message, data: { user: {...} } }
            // After axios interceptor unwrap: response = { status, message, data: { user: {...} } }
            // So we need: response.data.user

            if (response.data && response.data) {
                user.value = response.data
            } else {
                console.warn('Unexpected response structure:', response)
                // Fallback: try to get user from nested structure
                const userData = (response.data as any)?.data?.user || (response.data as any)?.user || (response.data as any)
                user.value = userData as User
            }
        } catch (error) {
            // Token invalid or expired
            console.error('Failed to fetch user:', error)
            // Clear invalid token instead of calling logout (which makes another API call)
            clearAuth()
        } finally {
            initialized.value = true
        }
    }

    return {
        user,
        token,
        loading,
        initialized,
        isAuthenticated,
        userRole,
        login,
        logout,
        clearAuth,
        fetchMe,
    }
}, {
    persist: true
})
