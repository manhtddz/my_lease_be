export type ResourceResponse<K extends string, T> = {
    [P in K]: T
}
