import { BaseService } from "./base.service"
import { UserApi } from "../api/user.api"
import { ActionResponse } from "../types/api/ActionResponse"
import { UserPaginateResponse } from "../types/user-interfaces/response/UserPaginateResponse"
import { UserDetailResponse } from "../types/user-interfaces/response/UserDetailResponse"
import { UserCreateRequest } from "../types/user-interfaces/request/UserCreateRequest"
import { UserUpdateRequest } from "../types/user-interfaces/request/UserUpdateRequest"

export class UserService extends BaseService<
    UserPaginateResponse,
    UserDetailResponse,
    UserCreateRequest,
    UserUpdateRequest,
    ActionResponse,
    UserApi
> {
    protected api = UserApi.getInstance()

    async upAdmin(id: number | string): Promise<ActionResponse> {
        return await this.api.upToAdmin(id)
    }
}
