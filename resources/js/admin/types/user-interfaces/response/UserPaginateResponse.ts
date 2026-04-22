import { ApiResponse } from "../../api/ApiResponse";
import { LaravelPaginate } from "../../paginate-response/LaravelPaginateResponse";
import { User } from "../User";


export type UserPaginateResponse = ApiResponse<LaravelPaginate<User>>
