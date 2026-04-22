<script setup lang="ts">
import { DEFAULT_PER_PAGE } from "@/admin/config/constant";
import { UserService } from "@/admin/services/user.service";
import { User } from "@/admin/types/user-interfaces/User";
import { computed, onMounted, reactive, ref } from "vue";
import { useRouter } from "vue-router";
import Input from "@/admin/components/base-components/form/Input.vue";
import Button from "@/admin/components/base-components/button/Button.vue";
import BaseTableList from "@/admin/components/common/BaseTableList.vue";
import FormField from "@/admin/components/base-components/form/FormField.vue";
import BasePaginator from "@/admin/components/common/BasePaginator.vue";
import BaseSearch from "@/admin/components/common/BaseSearch.vue";
import RadioGroup from "@/admin/components/base-components/form/RadioGroup.vue";
import { getText, userRoleOptions } from "@/admin/enums/UserRole";
import ConfirmModal from "@/admin/components/base-components/modals/ConfirmModal.vue";
import { useConfirm } from "@/admin/composable/userConfirm";
import { toast } from "vue3-toastify";

const { confirm } = useConfirm()
const router = useRouter();

// Table columns definition
const columns = [
    { key: "id", label: "ID", width: "80px" },
    { key: "name", label: "Tên" },
    { key: "email", label: "Email" },
    { key: "role", label: "Vai trò", width: "120px" },
    { key: "actions", label: "Thao tác", width: "150px" },
];

const roleOptions = computed(() => userRoleOptions());

// Data
const items = ref<User[]>([]);
const loading = ref(false);

// Filters
const filters = reactive({
    name: "",
    role: "",
});

// Pagination
const pagination = reactive({
    page: 1,
    per_page: DEFAULT_PER_PAGE,
    total: 0,
});

// Fetch user list
async function fetchList() {
    loading.value = true;
    try {
        const userService = new UserService();
        const response = await userService.list({
            name: filters.name || undefined,
            role: filters.role || undefined,
            page: pagination.page,
        });

        // Response structure: { status, message, data: LaravelPaginate<User> }
        // After axios interceptor unwrap: response = { status, message, data: LaravelPaginate<User> }
        if (response.data && response.data.data) {
            items.value = response.data.data;
            pagination.total = response.data.total;
        } else {
            console.error("Unexpected response structure:", response);
            items.value = [];
            pagination.total = 0;
        }
    } catch (error) {
        console.error("Failed to fetch users:", error);
        items.value = [];
        pagination.total = 0;
    } finally {
        loading.value = false;
    }
}

async function deleteUser(id: string | number) {
    loading.value = true;
    try {
        const userService = new UserService();
        const response = await userService.delete(id);

        toast.success(response.message)
    } catch (error) {
        console.error("Failed to fetch users:", error);
    } finally {
        loading.value = false;
    }
}

async function upAdmin(id: string | number) {
    loading.value = true;
    try {
        const userService = new UserService();
        const response = await userService.upAdmin(id);

        toast.success(response.message)
    } catch (error) {
        console.error("Failed to fetch users:", error);
    } finally {
        loading.value = false;
    }
}

// Search handler
function onSearch() {
    pagination.page = 1;
    fetchList();
}

// Pagination handler
function onPageChange(page: number) {
    pagination.page = page;
    fetchList();
}

// View user detail
function viewUser(id: number) {
    console.log("View user:", id);
}

// Edit user
function editUser(id: number) {
    router.push({
        name: "user.edit",
        params: { id },
    });
}

async function handleDelete(id: string | number) {
    const ok = await confirm({
        title: "Xóa user",
        message: "Bạn chắc chắn?",
    });

    if (!ok) return;

    await deleteUser(id);
    pagination.page = 1;
    fetchList();
}

async function upToAdmin(id: string | number) {
    const ok = await confirm({
        title: "Up admin",
        message: "Bạn chắc chắn?",
    });

    if (!ok) return;

    await upAdmin(id);
    pagination.page = 1;
    fetchList();
}

// Initialize on mount
onMounted(() => {
    fetchList();
});
</script>

<template>
    <div class="user-index-page">
        <div class="page-header">
            <h1>Quản lý người dùng</h1>
        </div>

        <!-- Search Section -->
        <BaseSearch
            v-model="filters"
            form-class="flex flex-col gap-4"
            actions-class="flex justify-end gap-2"
            search-button-class="px-5 py-2 me-2 bg-indigo-500 text-white rounded"
            reset-button-class="px-5 py-2 bg-gray-100 text-gray-600 rounded bg-dark"
            @search="onSearch"
        >
            <div class="search-filters">
                <FormField label="Name Search" fieldClass="filter-group">
                    <Input
                        id="name"
                        v-model="filters.name"
                        type="text"
                        placeholder="Tên hoặc email..."
                        class="search-input"
                    />
                    <RadioGroup
                        name="role"
                        v-model="filters.role"
                        :options="roleOptions.value"
                        include-any
                        any-label="All roles"
                    />
                </FormField>
            </div>
        </BaseSearch>

        <!-- Table Section -->
        <div class="table-container">
            <BaseTableList
                :columns="columns"
                :data="items"
                :loading="loading"
                wrapper-class="overflow-x-auto"
                table-class="w-full border-collapse bg-white"
                thead-class="bg-gray-100"
                th-class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b"
                tr-class="hover:bg-gray-50"
                td-class="px-4 py-3 text-sm text-gray-600 border-b"
                loading-class="text-center py-10 text-gray-400"
                empty-class="text-center py-10 text-gray-400"
            >
                <template #cell-role="{ row }">
                    <span class="role-badge">{{ getText(row.role) }}</span>
                </template>

                <template #cell-actions="{ row }">
                    <div class="action-buttons">
                        <Button
                            type="submit"
                            label="Xem"
                            variant="primary"
                            :disabled="true"
                            @click="viewUser(row.id)"
                        />
                        <Button
                            type="submit"
                            label="Sửa"
                            variant="secondary"
                            :disabled="false"
                            @click="editUser(row.id)"
                        />
                        <Button
                            type="submit"
                            label="Delete"
                            variant="danger"
                            :disabled="false"
                            @click="handleDelete(row.id)"
                        />
                        <Button
                            type="submit"
                            label="Up To Admin"
                            variant="secondary"
                            :disabled="false"
                            @click="upToAdmin(row.id)"
                        />
                    </div>
                </template>

                <template #empty> Không tìm thấy dữ liệu </template>
            </BaseTableList>
        </div>

        <!-- Pagination Section -->
        <div class="pagination-container">
            <BasePaginator
                :page="pagination.page"
                :per-page="pagination.per_page"
                :total="pagination.total"
                root-class="flex items-center justify-between p-4 bg-white rounded"
                controls-class="flex items-center gap-1"
                button-class="px-3 py-1 border rounded text-sm"
                active-button-class="bg-indigo-500 text-white bg-dark"
                ellipsis-class="px-2 text-gray-400"
                @change="onPageChange"
            >
                <template #info="{ startItem, endItem, total }">
                    <div class="text-sm text-gray-500 text-center">
                        Hiển thị {{ startItem }} – {{ endItem }} / {{ total }}
                    </div>
                </template>
            </BasePaginator>
        </div>
    </div>
</template>
