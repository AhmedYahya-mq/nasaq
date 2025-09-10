import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::create
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:43
 * @route '/admin/two-factor-challenge'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/two-factor-challenge',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::create
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:43
 * @route '/admin/two-factor-challenge'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::create
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:43
 * @route '/admin/two-factor-challenge'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::create
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:43
 * @route '/admin/two-factor-challenge'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::create
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:43
 * @route '/admin/two-factor-challenge'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::create
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:43
 * @route '/admin/two-factor-challenge'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::create
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:43
 * @route '/admin/two-factor-challenge'
 */
        createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    create.form = createForm
/**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::store
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:59
 * @route '/admin/two-factor-challenge'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/two-factor-challenge',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::store
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:59
 * @route '/admin/two-factor-challenge'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::store
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:59
 * @route '/admin/two-factor-challenge'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::store
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:59
 * @route '/admin/two-factor-challenge'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Actions\Fortify\TwoFactorAuthenticatedSessionController::store
 * @see app/Actions/Fortify/TwoFactorAuthenticatedSessionController.php:59
 * @route '/admin/two-factor-challenge'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
const TwoFactorAuthenticatedSessionController = { create, store }

export default TwoFactorAuthenticatedSessionController