/**
 * Standardized API Error class
 */
export class ApiError extends Error {
    public status: number
    public errors?: Record<string, string[]>
    public originalError?: any

    constructor(
        message: string,
        status: number = 500,
        errors?: Record<string, string[]>,
        originalError?: any
    ) {
        super(message)
        this.name = 'ApiError'
        this.status = status
        this.errors = errors
        this.originalError = originalError
    }

    /**
     * Check if error is a validation error (422)
     */
    isValidationError(): boolean {
        return this.status === 422
    }

    /**
     * Check if error is an authentication error (401)
     */
    isAuthError(): boolean {
        return this.status === 401
    }

    /**
     * Check if error is a not found error (404)
     */
    isNotFoundError(): boolean {
        return this.status === 404
    }
}
