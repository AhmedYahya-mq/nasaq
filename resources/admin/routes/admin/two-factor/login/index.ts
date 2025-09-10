import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
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
const login = {
    store,
}

export default login