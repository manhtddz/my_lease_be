import { AuthApi } from "../api/auth.api"
import { LoginRequest } from "../types/auth-interfaces/LoginRequest"
import { LoginResponse } from "../types/auth-interfaces/LoginResponse"
import { ActionResponse } from "../types/api/ActionResponse"
import { UserDetailResponse } from "../types/user-interfaces/response/UserDetailResponse"
import { ApiResponse } from "../types/api/ApiResponse"

export class AuthService {
    private api = AuthApi.getInstance()

    /**
     * Login with credentials
     * @param credentials - Login credentials (email and password)
     * @returns ApiResponse containing login response with user and token
     */
    async login(credentials: LoginRequest): Promise<ApiResponse<LoginResponse>> {
        return await this.api.login(credentials)
    }

    /**
     * Logout current user
     * @returns ApiResponse containing action response
     */
    async logout(): Promise<ApiResponse<ActionResponse>> {
        return await this.api.logout()
    }

    /**
     * Get current authenticated user
     * @returns ApiResponse containing user detail response
     */
    async me(): Promise<UserDetailResponse> {
        return await this.api.me()
    }
}
