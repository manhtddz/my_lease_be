import { PaginationLink } from "./PaginationLink"

export interface LaravelPaginate<T> {
    current_page: number
    data: T[]

    first_page_url: string | null
    last_page: number
    last_page_url: string | null

    next_page_url: string | null
    prev_page_url: string | null

    from: number | null
    to: number | null
    total: number
    per_page: number

    path: string
    links: PaginationLink[]
}
