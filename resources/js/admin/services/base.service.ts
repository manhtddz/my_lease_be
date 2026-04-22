import { BaseApi } from "../api/base.api"

export abstract class BaseService<
    TList,
    TDetail,
    TCreate,
    TUpdate,
    TAction,
    TApi extends BaseApi<TList, TDetail, TCreate, TUpdate, TAction>
> {
    protected abstract api: TApi

    /**
     * List resources with optional query parameters
     * @param params - Query parameters (e.g., pagination, filters)
     */
    async list(params?: Record<string, any>): Promise<TList> {
        return await this.api.list(params)
    }

    /**
     * Get a single resource by ID
     * @param id - Resource identifier
     */
    async show(id: number | string): Promise<TDetail> {
        return await this.api.show(id)
    }

    /**
     * Create a new resource
     * @param payload - Data for creating the resource
     */
    async create(payload: TCreate): Promise<TAction> {
        return await this.api.create(payload)
    }

    /**
     * Update an existing resource
     * @param id - Resource identifier
     * @param payload - Data for updating the resource
     */
    async update(id: number | string, payload: TUpdate): Promise<TAction> {
        return await this.api.update(id, payload)
    }

    /**
     * Delete a resource by ID
     * @param id - Resource identifier
     */
    async delete(id: number | string): Promise<TAction> {
        return await this.api.delete(id)
    }
}
