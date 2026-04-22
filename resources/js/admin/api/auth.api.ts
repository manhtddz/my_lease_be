import api from "../app/http"
import { LoginRequest } from "../types/auth-interfaces/LoginRequest"
import { LoginResponse } from "../types/auth-interfaces/LoginResponse"
import { ActionResponse } from "../types/api/ActionResponse"
import { UserDetailResponse } from "../types/user-interfaces/response/UserDetailResponse"
import { ApiResponse } from "../types/api/ApiResponse"

export class AuthApi {
    private static instance: AuthApi

    /**
     * Get singleton instance of AuthApi
     * @returns The singleton instance
     */
    static getInstance(): AuthApi {
        if (!AuthApi.instance) {
            AuthApi.instance = new AuthApi()
        }
        return AuthApi.instance
    }

    /**
     * Private constructor to prevent direct instantiation
     */
    private constructor() {}

    /**
     * Login with credentials
     * @param credentials - Login credentials (email and password)
     * @returns Login response with user and token
     */
    login(credentials: LoginRequest): Promise<ApiResponse<LoginResponse>> {
        return api.post("/login", credentials)
    }

    /**
     * Logout current user
     * @returns Action response
     */
    logout(): Promise<ApiResponse<ActionResponse>> {
        return api.post("/logout")
    }

    /**
     * Get current authenticated user
     * @returns User detail response
     */
    me(): Promise<UserDetailResponse> {
        return api.get("/me")
    }
}
