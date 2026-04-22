import axios, { AxiosError } from 'axios'
import { useAuthStore } from '../stores/auth'
import { ENV } from '../env'
import { ApiError } from '../types/api/ApiError'
import { toast } from 'vue3-toastify'
import { useMainStore } from '../stores/main'

const api = axios.create({
    baseURL: ENV.API_BASE_URL,
    withCredentials: false,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
})

api.interceptors.request.use(
    (config) => {
        const auth = useAuthStore()
        const main = useMainStore()
        if (auth.token) {
            config.headers.Authorization = `Bearer ${auth.token}`
        }

        // Language
        const locale =
            main.locale ||
            localStorage.getItem('locale') ||
            'ja'

        config.headers['Accept-Language'] = locale

        return config
    },
    (error) => Promise.reject(error)
)

api.interceptors.response.use(
    res => res.data, // unwrap response: { status: 0, message: "...", data: {...} }
    (err: AxiosError<any>) => {
        const response = err.response
        const status = response?.status || 500
        const data = response?.data || {}
        const requestUrl = err.config?.url || ''
        const isLoginRequest = requestUrl.includes('/login')
        const isLogoutRequest = requestUrl.includes('/logout')

        // Extract error message from backend response
        // Backend error formats:
        // - 404: { status: 1, message: "データがありません。", data: [] }
        // - 401: { message: "Unauthenticated." } or { status: false, message: "...", data: [] }
        // - 422: { status: 1, message: "...", data: { field: ["error1", "error2"] } }
        // - Other: { status: 1, message: "...", data: [] }
        let message = ''

        if (data.message) {
            message = data.message
        } else if (err.message) {
            message = err.message
        }

        // Don't show toast for 422 (validation errors) or for login request errors (handled in component)
        if (status !== 422) {
            toast.error(message)
        }

        // Handle 401 Unauthorized
        if (status === 401) {
            // Don't logout if:
            // 1. It's a login request (invalid credentials) - let component handle it
            // 2. It's a logout request (already logging out)
            if (!isLoginRequest && !isLogoutRequest) {
                const auth = useAuthStore()
                // Clear auth state without calling API (to avoid loop)
                auth.clearAuth()
            }

            // 401 format: { message: "Unauthenticated." } or { status: false, message: "...", data: [] }
            const apiError = new ApiError(
                message,
                status,
                undefined,
                err
            )
            return Promise.reject(apiError)
        }

        // Handle 422 Validation Error
        // Backend format: { status: 1, message: "...", data: { field: ["error1", "error2"] } }
        // Validation errors are in data.data because BaseApiController.error() puts errors in data parameter
        if (status === 422) {
            // Check both data.data (from BaseApiController) and data.errors (Laravel default)
            const validationErrors = data.data || data.errors || {}

            const apiError = new ApiError(
                message,
                status,
                validationErrors,
                err
            )
            return Promise.reject(apiError)
        }

        // Handle 404 and other errors
        // Backend format: { status: 1, message: "...", data: [] }
        const apiError = new ApiError(
            message,
            status,
            undefined,
            err
        )
        return Promise.reject(apiError)
    }
)


export default api
