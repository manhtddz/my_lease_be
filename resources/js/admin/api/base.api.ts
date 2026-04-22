import api from "../app/http"

export abstract class BaseApi<
    TList,
    TDetail,
    TCreate,
    TUpdate,
    TAction
> {
    protected abstract resource: string

    /**
     * List resources with optional query parameters
     * @param params - Query parameters (e.g., pagination, filters)
     */
    list(params?: Record<string, any>): Promise<TList> {
        return api.get(this.resource, { params })
    }

    /**
     * Get a single resource by ID
     * @param id - Resource identifier
     */
    show(id: number | string): Promise<TDetail> {
        return api.get(`${this.resource}/${id}`)
    }

    /**
     * Create a new resource
     * @param payload - Data for creating the resource
     */
    create(payload: TCreate): Promise<TAction> {
        return api.post(this.resource, payload)
    }

    /**
     * Update an existing resource
     * @param id - Resource identifier
     * @param payload - Data for updating the resource
     */
    update(id: number | string, payload: TUpdate): Promise<TAction> {
        return api.put(`${this.resource}/${id}`, payload)
    }

    /**
     * Delete a resource by ID
     * @param id - Resource identifier
     */
    delete(id: number | string): Promise<TAction> {
        return api.delete(`${this.resource}/${id}`)
    }
}
