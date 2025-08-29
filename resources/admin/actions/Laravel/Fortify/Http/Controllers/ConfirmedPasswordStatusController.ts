import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/user/confirmed-password-status'
 */
const show73be033a18dbbf60ac69beb63b807e15 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show73be033a18dbbf60ac69beb63b807e15.url(options),
    method: 'get',
})

show73be033a18dbbf60ac69beb63b807e15.definition = {
    methods: ["get","head"],
    url: '/user/confirmed-password-status',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/user/confirmed-password-status'
 */
show73be033a18dbbf60ac69beb63b807e15.url = (options?: RouteQueryOptions) => {
    return show73be033a18dbbf60ac69beb63b807e15.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/user/confirmed-password-status'
 */
show73be033a18dbbf60ac69beb63b807e15.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show73be033a18dbbf60ac69beb63b807e15.url(options),
    method: 'get',
})
/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/user/confirmed-password-status'
 */
show73be033a18dbbf60ac69beb63b807e15.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show73be033a18dbbf60ac69beb63b807e15.url(options),
    method: 'head',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/user/confirmed-password-status'
 */
    const show73be033a18dbbf60ac69beb63b807e15Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show73be033a18dbbf60ac69beb63b807e15.url(options),
        method: 'get',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/user/confirmed-password-status'
 */
        show73be033a18dbbf60ac69beb63b807e15Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show73be033a18dbbf60ac69beb63b807e15.url(options),
            method: 'get',
        })
            /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/user/confirmed-password-status'
 */
        show73be033a18dbbf60ac69beb63b807e15Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show73be033a18dbbf60ac69beb63b807e15.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show73be033a18dbbf60ac69beb63b807e15.form = show73be033a18dbbf60ac69beb63b807e15Form
    /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/admin/user/confirmed-password-status'
 */
const show03bb6f47c425a75e03602707f196920a = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show03bb6f47c425a75e03602707f196920a.url(options),
    method: 'get',
})

show03bb6f47c425a75e03602707f196920a.definition = {
    methods: ["get","head"],
    url: '/admin/user/confirmed-password-status',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/admin/user/confirmed-password-status'
 */
show03bb6f47c425a75e03602707f196920a.url = (options?: RouteQueryOptions) => {
    return show03bb6f47c425a75e03602707f196920a.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/admin/user/confirmed-password-status'
 */
show03bb6f47c425a75e03602707f196920a.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show03bb6f47c425a75e03602707f196920a.url(options),
    method: 'get',
})
/**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/admin/user/confirmed-password-status'
 */
show03bb6f47c425a75e03602707f196920a.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show03bb6f47c425a75e03602707f196920a.url(options),
    method: 'head',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/admin/user/confirmed-password-status'
 */
    const show03bb6f47c425a75e03602707f196920aForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show03bb6f47c425a75e03602707f196920a.url(options),
        method: 'get',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/admin/user/confirmed-password-status'
 */
        show03bb6f47c425a75e03602707f196920aForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show03bb6f47c425a75e03602707f196920a.url(options),
            method: 'get',
        })
            /**
* @see \Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController::show
 * @see vendor/laravel/fortify/src/Http/Controllers/ConfirmedPasswordStatusController.php:17
 * @route '/admin/user/confirmed-password-status'
 */
        show03bb6f47c425a75e03602707f196920aForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show03bb6f47c425a75e03602707f196920a.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show03bb6f47c425a75e03602707f196920a.form = show03bb6f47c425a75e03602707f196920aForm

export const show = {
    '/user/confirmed-password-status': show73be033a18dbbf60ac69beb63b807e15,
    '/admin/user/confirmed-password-status': show03bb6f47c425a75e03602707f196920a,
}

const ConfirmedPasswordStatusController = { show }

export default ConfirmedPasswordStatusController