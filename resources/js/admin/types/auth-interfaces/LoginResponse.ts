import { User } from "../user-interfaces/User"

export interface LoginResponse {
  user: User
  access_token: string
  token_type?: string
}
