import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/user/two-factor-recovery-codes'
 */
const index86252b38e5c39cafdc01180413a6f9f2 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index86252b38e5c39cafdc01180413a6f9f2.url(options),
    method: 'get',
})

index86252b38e5c39cafdc01180413a6f9f2.definition = {
    methods: ["get","head"],
    url: '/user/two-factor-recovery-codes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/user/two-factor-recovery-codes'
 */
index86252b38e5c39cafdc01180413a6f9f2.url = (options?: RouteQueryOptions) => {
    return index86252b38e5c39cafdc01180413a6f9f2.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/user/two-factor-recovery-codes'
 */
index86252b38e5c39cafdc01180413a6f9f2.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index86252b38e5c39cafdc01180413a6f9f2.url(options),
    method: 'get',
})
/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/user/two-factor-recovery-codes'
 */
index86252b38e5c39cafdc01180413a6f9f2.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index86252b38e5c39cafdc01180413a6f9f2.url(options),
    method: 'head',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/user/two-factor-recovery-codes'
 */
    const index86252b38e5c39cafdc01180413a6f9f2Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index86252b38e5c39cafdc01180413a6f9f2.url(options),
        method: 'get',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/user/two-factor-recovery-codes'
 */
        index86252b38e5c39cafdc01180413a6f9f2Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index86252b38e5c39cafdc01180413a6f9f2.url(options),
            method: 'get',
        })
            /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/user/two-factor-recovery-codes'
 */
        index86252b38e5c39cafdc01180413a6f9f2Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index86252b38e5c39cafdc01180413a6f9f2.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index86252b38e5c39cafdc01180413a6f9f2.form = index86252b38e5c39cafdc01180413a6f9f2Form
    /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
const index90aae05e13bf46644dd99c5385502b4a = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index90aae05e13bf46644dd99c5385502b4a.url(options),
    method: 'get',
})

index90aae05e13bf46644dd99c5385502b4a.definition = {
    methods: ["get","head"],
    url: '/admin/user/two-factor-recovery-codes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
index90aae05e13bf46644dd99c5385502b4a.url = (options?: RouteQueryOptions) => {
    return index90aae05e13bf46644dd99c5385502b4a.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
index90aae05e13bf46644dd99c5385502b4a.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index90aae05e13bf46644dd99c5385502b4a.url(options),
    method: 'get',
})
/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
index90aae05e13bf46644dd99c5385502b4a.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index90aae05e13bf46644dd99c5385502b4a.url(options),
    method: 'head',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
    const index90aae05e13bf46644dd99c5385502b4aForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index90aae05e13bf46644dd99c5385502b4a.url(options),
        method: 'get',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
        index90aae05e13bf46644dd99c5385502b4aForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index90aae05e13bf46644dd99c5385502b4a.url(options),
            method: 'get',
        })
            /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::index
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:20
 * @route '/admin/user/two-factor-recovery-codes'
 */
        index90aae05e13bf46644dd99c5385502b4aForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index90aae05e13bf46644dd99c5385502b4a.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index90aae05e13bf46644dd99c5385502b4a.form = index90aae05e13bf46644dd99c5385502b4aForm

export const index = {
    '/user/two-factor-recovery-codes': index86252b38e5c39cafdc01180413a6f9f2,
    '/admin/user/two-factor-recovery-codes': index90aae05e13bf46644dd99c5385502b4a,
}

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:39
 * @route '/user/two-factor-recovery-codes'
 */
const store86252b38e5c39cafdc01180413a6f9f2 = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store86252b38e5c39cafdc01180413a6f9f2.url(options),
    method: 'post',
})

store86252b38e5c39cafdc01180413a6f9f2.definition = {
    methods: ["post"],
    url: '/user/two-factor-recovery-codes',
} satisfies RouteDefinition<["post"]>

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:39
 * @route '/user/two-factor-recovery-codes'
 */
store86252b38e5c39cafdc01180413a6f9f2.url = (options?: RouteQueryOptions) => {
    return store86252b38e5c39cafdc01180413a6f9f2.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:39
 * @route '/user/two-factor-recovery-codes'
 */
store86252b38e5c39cafdc01180413a6f9f2.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store86252b38e5c39cafdc01180413a6f9f2.url(options),
    method: 'post',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:39
 * @route '/user/two-factor-recovery-codes'
 */
    const store86252b38e5c39cafdc01180413a6f9f2Form = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store86252b38e5c39cafdc01180413a6f9f2.url(options),
        method: 'post',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:39
 * @route '/user/two-factor-recovery-codes'
 */
        store86252b38e5c39cafdc01180413a6f9f2Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store86252b38e5c39cafdc01180413a6f9f2.url(options),
            method: 'post',
        })
    
    store86252b38e5c39cafdc01180413a6f9f2.form = store86252b38e5c39cafdc01180413a6f9f2Form
    /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:39
 * @route '/admin/user/two-factor-recovery-codes'
 */
const store90aae05e13bf46644dd99c5385502b4a = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store90aae05e13bf46644dd99c5385502b4a.url(options),
    method: 'post',
})

store90aae05e13bf46644dd99c5385502b4a.definition = {
    methods: ["post"],
    url: '/admin/user/two-factor-recovery-codes',
} satisfies RouteDefinition<["post"]>

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:39
 * @route '/admin/user/two-factor-recovery-codes'
 */
store90aae05e13bf46644dd99c5385502b4a.url = (options?: RouteQueryOptions) => {
    return store90aae05e13bf46644dd99c5385502b4a.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:39
 * @route '/admin/user/two-factor-recovery-codes'
 */
store90aae05e13bf46644dd99c5385502b4a.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store90aae05e13bf46644dd99c5385502b4a.url(options),
    method: 'post',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:39
 * @route '/admin/user/two-factor-recovery-codes'
 */
    const store90aae05e13bf46644dd99c5385502b4aForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store90aae05e13bf46644dd99c5385502b4a.url(options),
        method: 'post',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\RecoveryCodeController::store
 * @see vendor/laravel/fortify/src/Http/Controllers/RecoveryCodeController.php:39
 * @route '/admin/user/two-factor-recovery-codes'
 */
        store90aae05e13bf46644dd99c5385502b4aForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store90aae05e13bf46644dd99c5385502b4a.url(options),
            method: 'post',
        })
    
    store90aae05e13bf46644dd99c5385502b4a.form = store90aae05e13bf46644dd99c5385502b4aForm

export const store = {
    '/user/two-factor-recovery-codes': store86252b38e5c39cafdc01180413a6f9f2,
    '/admin/user/two-factor-recovery-codes': store90aae05e13bf46644dd99c5385502b4a,
}

const RecoveryCodeController = { index, store }

export default RecoveryCodeController