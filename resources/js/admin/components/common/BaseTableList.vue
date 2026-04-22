<script setup lang="ts">
interface Column {
    key: string;
    label?: string;
    width?: string;
}

const props = defineProps<{
    columns: Column[];
    data: any[];
    loading?: boolean;

    wrapperClass?: string;
    tableClass?: string;
    theadClass?: string;
    thClass?: string;
    trClass?: string;
    tdClass?: string;
    loadingClass?: string;
    emptyClass?: string;
}>();
</script>

<template>
    <div :class="wrapperClass">
        <table :class="tableClass">
            <thead :class="theadClass">
                <tr>
                    <th
                        v-for="col in columns"
                        :key="col.key"
                        :class="thClass"
                        :style="{ width: col.width }"
                    >
                        {{ col.label || col.key }}
                    </th>
                </tr>
            </thead>

            <tbody>
                <!-- Loading -->
                <tr v-if="loading">
                    <td :colspan="columns.length" :class="loadingClass">
                        <slot name="loading"> Đang tải... </slot>
                    </td>
                </tr>

                <!-- Empty -->
                <tr v-else-if="!data.length">
                    <td :colspan="columns.length" :class="emptyClass">
                        <slot name="empty"> Không có dữ liệu </slot>
                    </td>
                </tr>

                <!-- Data -->
                <tr v-else v-for="row in data" :key="row.id" :class="trClass">
                    <td v-for="col in columns" :key="col.key" :class="tdClass">
                        <slot :name="`cell-${col.key}`" :row="row">
                            {{ row[col.key] }}
                        </slot>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
