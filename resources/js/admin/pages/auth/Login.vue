<template>
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">Đăng nhập</h1>

            <form @submit.prevent="handleLogin" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="text"
                        placeholder="Nhập email"
                        class="form-input"
                        :class="{
                            'form-input-error':
                                errors.email && errors.email.length > 0,
                        }"
                        @input="clearErrors('email')"
                    />
                    <div
                        v-if="errors.email && errors.email.length > 0"
                        class="field-error"
                    >
                        <p v-for="(error, index) in errors.email" :key="index">
                            {{ error }}
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        placeholder="Nhập mật khẩu"
                        class="form-input"
                        :class="{
                            'form-input-error':
                                errors.password && errors.password.length > 0,
                        }"
                        @input="clearErrors('password')"
                    />
                    <div
                        v-if="errors.password && errors.password.length > 0"
                        class="field-error"
                    >
                        <p
                            v-for="(error, index) in errors.password"
                            :key="index"
                        >
                            {{ error }}
                        </p>
                    </div>
                </div>

                <button type="submit" class="login-button">
                    <span v-if="loading">Đang đăng nhập...</span>
                    <span v-else>Đăng nhập</span>
                </button>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref, onMounted, nextTick } from "vue";
import { useRouter } from "vue-router";
import { useValidator } from "@/admin/composable/useValidator";
import { email, required } from "@/admin/validation/rules";
import { ApiError } from "@/admin/types/api/ApiError";
import { useAuthStore } from "@/admin/stores/auth";
import { LoginRequest } from "@/admin/types/auth-interfaces/LoginRequest";

const router = useRouter();
const authStore = useAuthStore();
const form = reactive<LoginRequest>({
    email: "",
    password: "",
});
const { errors, validate, setErrorsFromBackend, clearErrors } = useValidator(
    form,
    {
        email: [required, email],
        password: [required],
    },
    {
        email: "Email",
        password: "Mật khẩu"
    }
);

const loading = ref(false);

// Focus on email input when component is mounted
onMounted(async () => {
    // Reset loading state in case it was stuck
    loading.value = false;

    // Clear auth store loading state if stuck (check if it exists)
    // Note: loading is returned from store but may not be directly writable

    // Remove any loading overlays that might be blocking
    await nextTick();

    // Remove any vue-loading-overlay elements
    const loadingOverlays = document.querySelectorAll('.vld-overlay, .vld-backdrop, [data-vld-overlay]');
    loadingOverlays.forEach(el => el.remove());

    // Remove any elements with pointer-events: none that might block
    const blockingElements = document.querySelectorAll('[style*="pointer-events: none"]');
    blockingElements.forEach(el => {
        const htmlEl = el as HTMLElement;
        if (htmlEl.style.pointerEvents === 'none') {
            htmlEl.style.pointerEvents = '';
        }
    });

    // Focus on email input after a short delay to ensure DOM is ready
    setTimeout(() => {
        const emailInput = document.getElementById('email') as HTMLInputElement;
        if (emailInput) {
            emailInput.focus();
        }
    }, 100);
});

const handleLogin = async () => {
    clearErrors();

    // Validate form before submission
    if (!validate()) {
        return;
    }

    loading.value = true;

    try {
        await authStore.login(form);
        // Redirect to home after successful login
        router.push({ name: "home" });
    } catch (error: unknown) {
        // Error is now handled by interceptor and returned as ApiError
        if (error instanceof ApiError) {
            // Handle validation errors (422)
            if (error.isValidationError() && error.errors) {
                setErrorsFromBackend(error.errors);
            }
        }
    } finally {
        loading.value = false;
    }
};
</script>
