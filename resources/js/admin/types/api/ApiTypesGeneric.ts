import { BaseApi } from "@/admin/api/base.api"

export type ApiTypes<T> =
    T extends BaseApi<
        infer TList,
        infer TDetail,
        infer TCreate,
        infer TUpdate,
        infer TAction
    >
        ? {
              list: TList
              detail: TDetail
              create: TCreate
              update: TUpdate
              action: TAction
          }
        : never
