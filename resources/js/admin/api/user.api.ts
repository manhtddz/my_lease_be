import api from "../app/http"
import { ActionResponse } from "../types/api/ActionResponse"
import { UserCreateRequest } from "../types/user-interfaces/request/UserCreateRequest"
import { UserUpdateRequest } from "../types/user-interfaces/request/UserUpdateRequest"
import { UserDetailResponse } from "../types/user-interfaces/response/UserDetailResponse"
import { UserPaginateResponse } from "../types/user-interfaces/response/UserPaginateResponse"
import { BaseApi } from "./base.api"


export class UserApi extends BaseApi<
    UserPaginateResponse,
    UserDetailResponse,
    UserCreateRequest,
    UserUpdateRequest,
    ActionResponse
> {
    protected resource = "/users"

    private static instance: UserApi

    /**
     * Get singleton instance of UserApi
     * @returns The singleton instance
     */
    static getInstance(): UserApi {
        if (!UserApi.instance) {
            UserApi.instance = new UserApi()
        }
        return UserApi.instance
    }

    /**
     * Private constructor to prevent direct instantiation
     */
    private constructor() {
        super()
    }

    /**
     * Get a single resource by ID
     * @param id - Resource identifier
     */
    upToAdmin(id: number | string): Promise<ActionResponse> {
        return api.put(`${this.resource}/up-admin/${id}`)
    }

}
