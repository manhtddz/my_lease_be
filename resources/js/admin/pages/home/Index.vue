<template>
    <!-- MARK:MAIN -->
    <main class="main">
        <div class="user-info-container">
            <h1>Trang chủ</h1>

            <div v-if="user" class="user-card">
                <h2>Thông tin người dùng</h2>
                <div class="user-details">
                    <div class="detail-item">
                        <span class="label">ID:</span>
                        <span class="value">{{ user.id }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Tên:</span>
                        <span class="value">{{ user.name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Email:</span>
                        <span class="value">{{ user.email }}</span>
                    </div>
                    <div class="detail-item" v-if="user.role !== undefined">
                        <span class="label">Vai trò:</span>
                        <span class="value">{{ user.role }}</span>
                    </div>
                    <div class="detail-item" v-if="user.manager_id">
                        <span class="label">Manager ID:</span>
                        <span class="value">{{ user.manager_id }}</span>
                    </div>
                    <div class="detail-item" v-if="user.department_id">
                        <span class="label">Department ID:</span>
                        <span class="value">{{ user.department_id }}</span>
                    </div>
                </div>
            </div>

            <div v-else class="no-user">
                <p>Chưa đăng nhập hoặc đang tải thông tin người dùng...</p>
            </div>
        </div>
    </main>
    <!-- /MAIN -->

    <!-- Modals -->

</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useAuthStore } from "@/admin/stores/auth";

const authStore = useAuthStore()

const user = computed(() => authStore.user)

</script>
