import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Settings\SecurityController::index
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/settings/security',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Settings\SecurityController::index
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Settings\SecurityController::index
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Settings\SecurityController::index
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Settings\SecurityController::index
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Settings\SecurityController::index
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Settings\SecurityController::index
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
/**
* @see \App\Http\Controllers\Settings\SecurityController::store
 * @see app/Http/Controllers/Settings/SecurityController.php:39
 * @route '/admin/user/two-factor-recovery-codes'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/user/two-factor-recovery-codes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Settings\SecurityController::store
 * @see app/Http/Controllers/Settings/SecurityController.php:39
 * @route '/admin/user/two-factor-recovery-codes'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Settings\SecurityController::store
 * @see app/Http/Controllers/Settings/SecurityController.php:39
 * @route '/admin/user/two-factor-recovery-codes'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Settings\SecurityController::store
 * @see app/Http/Controllers/Settings/SecurityController.php:39
 * @route '/admin/user/two-factor-recovery-codes'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Settings\SecurityController::store
 * @see app/Http/Controllers/Settings/SecurityController.php:39
 * @route '/admin/user/two-factor-recovery-codes'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
const SecurityController = { index, store }

export default SecurityController