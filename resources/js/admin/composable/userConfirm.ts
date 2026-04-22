import { ref } from 'vue'

type ConfirmOptions = {
    title?: string
    message?: string
}

const visible = ref(false)
const options = ref<ConfirmOptions>({})
let resolver: ((v: boolean) => void) | null = null

export function useConfirm() {
    function confirm(opts: ConfirmOptions) {
        options.value = opts
        visible.value = true

        return new Promise<boolean>((resolve) => {
            resolver = resolve
        })
    }

    function onConfirm() {
        visible.value = false
        resolver?.(true)
    }

    function onCancel() {
        visible.value = false
        resolver?.(false)
    }

    return {
        visible,
        options,
        confirm,
        onConfirm,
        onCancel,
    }
}
