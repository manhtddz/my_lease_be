function required(key: string, value?: string): string {
    if (!value) {
        throw new Error(`Missing env: ${key}`)
    }
    return value
}

export const ENV = {
    APP_NAME: required('VITE_APP_NAME', import.meta.env.VITE_APP_NAME),

    API_BASE_URL: required(
        'VITE_API_BASE_URL',
        import.meta.env.VITE_API_BASE_URL,
    ),

    AUTH_GUARD: import.meta.env.VITE_AUTH_GUARD ?? 'sanctum',
} as const
