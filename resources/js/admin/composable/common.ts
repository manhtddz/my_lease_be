import { i18n } from './../i18n/index';

export function common() {
    const t = i18n.global.t
    const tm = i18n.global.tm

    const resolveMessage = (
        key: string,
        params: Record<string, any> = {}
    ): string => {
        let message = t(key)

        Object.entries(params).forEach(([param, value]) => {
            message = message.replaceAll(
                `:${param}`,
                String(value)
            )
        })

        return message
    }

    function resolveObject<T = Record<string, any>>(key: string): T {
        return tm(key) as T
    }

    return {
        resolveMessage,
        resolveObject,
    };
}
