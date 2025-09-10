import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/user/two-factor-recovery-codes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
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
const RecoveryCodeController = { index }

export default RecoveryCodeController