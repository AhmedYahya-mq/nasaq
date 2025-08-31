import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:21
 * @route '/user/two-factor-authentication'
 */
const storea8b3ee4b2a14cda802d531b78132d05f = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storea8b3ee4b2a14cda802d531b78132d05f.url(options),
    method: 'post',
})

storea8b3ee4b2a14cda802d531b78132d05f.definition = {
    methods: ["post"],
    url: '/user/two-factor-authentication',
} satisfies RouteDefinition<["post"]>

/**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:21
 * @route '/user/two-factor-authentication'
 */
storea8b3ee4b2a14cda802d531b78132d05f.url = (options?: RouteQueryOptions) => {
    return storea8b3ee4b2a14cda802d531b78132d05f.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:21
 * @route '/user/two-factor-authentication'
 */
storea8b3ee4b2a14cda802d531b78132d05f.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storea8b3ee4b2a14cda802d531b78132d05f.url(options),
    method: 'post',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:21
 * @route '/user/two-factor-authentication'
 */
    const storea8b3ee4b2a14cda802d531b78132d05fForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: storea8b3ee4b2a14cda802d531b78132d05f.url(options),
        method: 'post',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:21
 * @route '/user/two-factor-authentication'
 */
        storea8b3ee4b2a14cda802d531b78132d05fForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: storea8b3ee4b2a14cda802d531b78132d05f.url(options),
            method: 'post',
        })
    
    storea8b3ee4b2a14cda802d531b78132d05f.form = storea8b3ee4b2a14cda802d531b78132d05fForm
    /**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:21
 * @route '/admin/user/two-factor-authentication'
 */
const storee8dc4d1c850af5778a373f1adb88ae48 = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storee8dc4d1c850af5778a373f1adb88ae48.url(options),
    method: 'post',
})

storee8dc4d1c850af5778a373f1adb88ae48.definition = {
    methods: ["post"],
    url: '/admin/user/two-factor-authentication',
} satisfies RouteDefinition<["post"]>

/**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:21
 * @route '/admin/user/two-factor-authentication'
 */
storee8dc4d1c850af5778a373f1adb88ae48.url = (options?: RouteQueryOptions) => {
    return storee8dc4d1c850af5778a373f1adb88ae48.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:21
 * @route '/admin/user/two-factor-authentication'
 */
storee8dc4d1c850af5778a373f1adb88ae48.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storee8dc4d1c850af5778a373f1adb88ae48.url(options),
    method: 'post',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:21
 * @route '/admin/user/two-factor-authentication'
 */
    const storee8dc4d1c850af5778a373f1adb88ae48Form = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: storee8dc4d1c850af5778a373f1adb88ae48.url(options),
        method: 'post',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:21
 * @route '/admin/user/two-factor-authentication'
 */
        storee8dc4d1c850af5778a373f1adb88ae48Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: storee8dc4d1c850af5778a373f1adb88ae48.url(options),
            method: 'post',
        })
    
    storee8dc4d1c850af5778a373f1adb88ae48.form = storee8dc4d1c850af5778a373f1adb88ae48Form

export const store = {
    '/user/two-factor-authentication': storea8b3ee4b2a14cda802d531b78132d05f,
    '/admin/user/two-factor-authentication': storee8dc4d1c850af5778a373f1adb88ae48,
}

/**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::destroy
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:34
 * @route '/user/two-factor-authentication'
 */
const destroya8b3ee4b2a14cda802d531b78132d05f = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroya8b3ee4b2a14cda802d531b78132d05f.url(options),
    method: 'delete',
})

destroya8b3ee4b2a14cda802d531b78132d05f.definition = {
    methods: ["delete"],
    url: '/user/two-factor-authentication',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::destroy
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:34
 * @route '/user/two-factor-authentication'
 */
destroya8b3ee4b2a14cda802d531b78132d05f.url = (options?: RouteQueryOptions) => {
    return destroya8b3ee4b2a14cda802d531b78132d05f.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::destroy
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:34
 * @route '/user/two-factor-authentication'
 */
destroya8b3ee4b2a14cda802d531b78132d05f.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroya8b3ee4b2a14cda802d531b78132d05f.url(options),
    method: 'delete',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::destroy
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:34
 * @route '/user/two-factor-authentication'
 */
    const destroya8b3ee4b2a14cda802d531b78132d05fForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroya8b3ee4b2a14cda802d531b78132d05f.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::destroy
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:34
 * @route '/user/two-factor-authentication'
 */
        destroya8b3ee4b2a14cda802d531b78132d05fForm.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroya8b3ee4b2a14cda802d531b78132d05f.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroya8b3ee4b2a14cda802d531b78132d05f.form = destroya8b3ee4b2a14cda802d531b78132d05fForm
    /**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::destroy
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:34
 * @route '/admin/user/two-factor-authentication'
 */
const destroye8dc4d1c850af5778a373f1adb88ae48 = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroye8dc4d1c850af5778a373f1adb88ae48.url(options),
    method: 'delete',
})

destroye8dc4d1c850af5778a373f1adb88ae48.definition = {
    methods: ["delete"],
    url: '/admin/user/two-factor-authentication',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::destroy
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:34
 * @route '/admin/user/two-factor-authentication'
 */
destroye8dc4d1c850af5778a373f1adb88ae48.url = (options?: RouteQueryOptions) => {
    return destroye8dc4d1c850af5778a373f1adb88ae48.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::destroy
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:34
 * @route '/admin/user/two-factor-authentication'
 */
destroye8dc4d1c850af5778a373f1adb88ae48.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroye8dc4d1c850af5778a373f1adb88ae48.url(options),
    method: 'delete',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::destroy
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:34
 * @route '/admin/user/two-factor-authentication'
 */
    const destroye8dc4d1c850af5778a373f1adb88ae48Form = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroye8dc4d1c850af5778a373f1adb88ae48.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::destroy
 * @see vendor/laravel/fortify/src/Http/Controllers/TwoFactorAuthenticationController.php:34
 * @route '/admin/user/two-factor-authentication'
 */
        destroye8dc4d1c850af5778a373f1adb88ae48Form.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroye8dc4d1c850af5778a373f1adb88ae48.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroye8dc4d1c850af5778a373f1adb88ae48.form = destroye8dc4d1c850af5778a373f1adb88ae48Form

export const destroy = {
    '/user/two-factor-authentication': destroya8b3ee4b2a14cda802d531b78132d05f,
    '/admin/user/two-factor-authentication': destroye8dc4d1c850af5778a373f1adb88ae48,
}

const TwoFactorAuthenticationController = { store, destroy }

export default TwoFactorAuthenticationController