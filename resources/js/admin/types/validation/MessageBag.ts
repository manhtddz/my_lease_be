export class MessageBag {
    private errors: Record<string, string[]> = {}

    add(field: string, message: string) {
        if (!this.errors[field]) {
            this.errors[field] = []
        }
        this.errors[field].push(message)
    }

    get(field: string) {
        return this.errors[field] || []
    }

    first(field: string) {
        return this.errors[field]?.[0]
    }

    has(field: string) {
        return field in this.errors
    }

    all() {
        return this.errors
    }

    clear(field?: string) {
        if (!field) {
            this.errors = {}
        } else {
            delete this.errors[field]
        }
    }

    set(errors: Record<string, string[]>) {
        this.errors = errors
    }
}
