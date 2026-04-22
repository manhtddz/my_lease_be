<template>
    <div class="user-edit-page">
        <div class="page-header">
            <h1>Sửa thông tin người dùng</h1>
        </div>

        <div v-if="loading && !form.id" class="loading-container">
            <p>Đang tải...</p>
        </div>

        <form v-else @submit.prevent="handleSubmit" class="user-edit-form">
            <div class="form-section">
                <FormField
                    :label=labels.name
                    :required="true"
                    :error="errors.name"
                    idlabel="name"
                >
                    <Input
                        id="name"
                        v-model="form.name"
                        type="text"
                        placeholder="Nhập tên"
                        :class="{
                            'form-input-error':
                                errors.name && errors.name.length > 0,
                        }"
                        @input="clearErrors('name')"
                    />
                </FormField>

                <FormField
                    :label=labels.email
                    :required="true"
                    :error="errors.email"
                    idlabel="email"
                >
                    <Input
                        id="email"
                        v-model="form.email"
                        type="text"
                        placeholder="Nhập email"
                        :class="{
                            'form-input-error':
                                errors.email && errors.email.length > 0,
                        }"
                        @input="clearErrors('email')"
                    />
                </FormField>

                <FormField
                    idlabel="role"
                    :label=labels.role
                    :required="true"
                    :error="errors.role"
                >
                    <Radio
                        id="role"
                        v-model="form.role"
                        :options="roleOptions.value"
                        name="role"
                    />
                </FormField>

                <FormField
                    idlabel="role"
                    :label=labels.role
                    :required="true"
                    :error="errors.role"
                >
                    <Select
                        id="role"
                        rootClass="role-select"
                        triggerClass="role-select__trigger"
                        dropdownClass="role-select__dropdown"
                        listClass="role-select__list"
                        itemClass="role-select__item"
                        clearable
                        v-model="form.role"
                        :options="roleOptions.value"
                        :has-error="errors.role && errors.role.length > 0"
                        placeholder="Chọn vai trò"
                        v-model:open="roleSelectOpen"
                        @update:modelValue="handleRoleChange"
                    />
                </FormField>

                <FormField
                    idlabel="roleCheckBox"
                    :label=labels.role
                    :required="true"
                    :error="errors.rolesCheckbox"
                >
                    <Checkbox
                        id="roleCheckBox"
                        v-model="form.rolesCheckbox"
                        :options="roleOptions.value"
                    />
                </FormField>

                <FormField
                    idlabel="description"
                    :label=labels.description
                    :required="true"
                    :error="errors.description"
                >
                    <Textarea
                        id="description"
                        v-model="form.description"
                        placeholder="description"
                        rootClass="description-field"
                        textareaClass="description-textarea"
                        errorClass="description-error"
                    />
                </FormField>
            </div>

            <div class="form-actions">
                <Button
                    type="button"
                    label="Hủy"
                    variant="secondary"
                    @click="handleCancel"
                />
                <Button
                    type="submit"
                    label="Lưu"
                    variant="primary"
                    :disabled="loading"
                />
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, reactive, ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useValidator } from "@/admin/composable/useValidator";
import { email, inEnum, inEnumArray, required } from "@/admin/validation/rules";
import { ApiError } from "@/admin/types/api/ApiError";
import { UserService } from "@/admin/services/user.service";
import { UserUpdateRequest } from "@/admin/types/user-interfaces/request/UserUpdateRequest";
import FormField from "@/admin/components/base-components/form/FormField.vue";
import Input from "@/admin/components/base-components/form/Input.vue";
import Select from "@/admin/components/base-components/form/Select.vue";
import Button from "@/admin/components/base-components/button/Button.vue";
import Textarea from "@/admin/components/base-components/form/Textarea.vue";
import Checkbox from "@/admin/components/base-components/form/Checkbox.vue";
import Radio from "@/admin/components/base-components/form/Radio.vue";
import { common } from "@/admin/composable/common";
import { USER_ROLE, userRoleOptions } from "@/admin/enums/UserRole";
import { toast } from "vue3-toastify";

const route = useRoute();
const router = useRouter();
// Get user ID from route params
const userId = ref<number>(Number(route.params.id));

// Role options for select (value must be string for Select component)
const roleOptions = computed(() => userRoleOptions())

// Role select state
const roleSelectOpen = ref(false);
const form = reactive<UserUpdateRequest>({
    id: 0,
    name: "",
    email: "",
    role: "",
    manager_id: undefined,
    department_id: undefined,
    description: "",
    rolesCheckbox: [],
});
const rules = {
    name: [required],
    email: [required, email],
    role: [required, inEnum(USER_ROLE)],
    description: [],
    rolesCheckbox: [inEnumArray(USER_ROLE)],
};
const labels = computed(() =>
    common().resolveObject("models.users.attributes")
)

// Form validation
const { errors, validate, setErrorsFromBackend, clearErrors } =
    useValidator<UserUpdateRequest>(form, rules, labels.value);

const loading = ref(false);

// Fetch user data
async function fetchUser() {
    if (!userId.value) {
        router.push({ name: "user" });
        return;
    }

    loading.value = true;

    try {
        const userService = new UserService();
        const response = await userService.show(userId.value);

        // Response structure: { status, message, data: { user: {...} } }
        if (response.data) {
            const user = response.data;
            form.id = user.id;
            form.name = user.name || "";
            form.email = user.email || "";
            form.role = String(user.role);
        } else {
            console.error("Unexpected response structure:", response);
            router.push({ name: "user" });
        }
    } catch (error) {
        console.error("Failed to fetch user:", error);
        router.push({ name: "user" });
    } finally {
        loading.value = false;
    }
}

// Handle form submission
async function handleSubmit() {
    clearErrors();

    // Validate form before submission
    if (!validate()) {
        console.log(form);

        return;
    }
    console.log(form);
    loading.value = true;
    // return
    try {
        const userService = new UserService();
        let res = await userService.update(userId.value, form as UserUpdateRequest);
        // Redirect to user list after successful update
        toast.success(res.message)
        router.push({ name: "user" });
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
}

// Handle role change
function handleRoleChange(value: string) {
    if (value === "") {
        form.role = null as any; // hoặc null, tùy backend
    } else {
        form.role = value;
    }

    clearErrors("role");
}

// Handle cancel
function handleCancel() {
    router.push({ name: "user" });
}

// Initialize on mount
onMounted(() => {
    fetchUser();
});
</script>


