import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedTwoFactorAuthenticationController.php:19
 * @route '/user/confirmed-two-factor-authentication'
 */
const storef63ba45a13a96ecb1eea539993770432 = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storef63ba45a13a96ecb1eea539993770432.url(options),
    method: 'post',
})

storef63ba45a13a96ecb1eea539993770432.definition = {
    methods: ["post"],
    url: '/user/confirmed-two-factor-authentication',
} satisfies RouteDefinition<["post"]>

/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedTwoFactorAuthenticationController.php:19
 * @route '/user/confirmed-two-factor-authentication'
 */
storef63ba45a13a96ecb1eea539993770432.url = (options?: RouteQueryOptions) => {
    return storef63ba45a13a96ecb1eea539993770432.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedTwoFactorAuthenticationController.php:19
 * @route '/user/confirmed-two-factor-authentication'
 */
storef63ba45a13a96ecb1eea539993770432.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storef63ba45a13a96ecb1eea539993770432.url(options),
    method: 'post',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedTwoFactorAuthenticationController.php:19
 * @route '/user/confirmed-two-factor-authentication'
 */
    const storef63ba45a13a96ecb1eea539993770432Form = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: storef63ba45a13a96ecb1eea539993770432.url(options),
        method: 'post',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedTwoFactorAuthenticationController.php:19
 * @route '/user/confirmed-two-factor-authentication'
 */
        storef63ba45a13a96ecb1eea539993770432Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: storef63ba45a13a96ecb1eea539993770432.url(options),
            method: 'post',
        })
    
    storef63ba45a13a96ecb1eea539993770432.form = storef63ba45a13a96ecb1eea539993770432Form
    /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedTwoFactorAuthenticationController.php:19
 * @route '/admin/user/confirmed-two-factor-authentication'
 */
const store6926e57caf0cc4ccbc3a0b4d133b8f86 = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store6926e57caf0cc4ccbc3a0b4d133b8f86.url(options),
    method: 'post',
})

store6926e57caf0cc4ccbc3a0b4d133b8f86.definition = {
    methods: ["post"],
    url: '/admin/user/confirmed-two-factor-authentication',
} satisfies RouteDefinition<["post"]>

/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedTwoFactorAuthenticationController.php:19
 * @route '/admin/user/confirmed-two-factor-authentication'
 */
store6926e57caf0cc4ccbc3a0b4d133b8f86.url = (options?: RouteQueryOptions) => {
    return store6926e57caf0cc4ccbc3a0b4d133b8f86.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedTwoFactorAuthenticationController.php:19
 * @route '/admin/user/confirmed-two-factor-authentication'
 */
store6926e57caf0cc4ccbc3a0b4d133b8f86.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store6926e57caf0cc4ccbc3a0b4d133b8f86.url(options),
    method: 'post',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedTwoFactorAuthenticationController.php:19
 * @route '/admin/user/confirmed-two-factor-authentication'
 */
    const store6926e57caf0cc4ccbc3a0b4d133b8f86Form = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store6926e57caf0cc4ccbc3a0b4d133b8f86.url(options),
        method: 'post',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedTwoFactorAuthenticationController.php:19
 * @route '/admin/user/confirmed-two-factor-authentication'
 */
        store6926e57caf0cc4ccbc3a0b4d133b8f86Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store6926e57caf0cc4ccbc3a0b4d133b8f86.url(options),
            method: 'post',
        })
    
    store6926e57caf0cc4ccbc3a0b4d133b8f86.form = store6926e57caf0cc4ccbc3a0b4d133b8f86Form

export const store = {
    '/user/confirmed-two-factor-authentication': storef63ba45a13a96ecb1eea539993770432,
    '/admin/user/confirmed-two-factor-authentication': store6926e57caf0cc4ccbc3a0b4d133b8f86,
}

const ConfirmedTwoFactorAuthenticationController = { store }

export default ConfirmedTwoFactorAuthenticationController