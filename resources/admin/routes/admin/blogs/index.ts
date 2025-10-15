import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
import update from './update'
/**
* @see \App\Http\Controllers\User\BlogController::store
 * @see app/Http/Controllers/User/BlogController.php:18
 * @route '/hidden/door/zone/master/blogs'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/hidden/door/zone/master/blogs',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\User\BlogController::store
 * @see app/Http/Controllers/User/BlogController.php:18
 * @route '/hidden/door/zone/master/blogs'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\BlogController::store
 * @see app/Http/Controllers/User/BlogController.php:18
 * @route '/hidden/door/zone/master/blogs'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\User\BlogController::store
 * @see app/Http/Controllers/User/BlogController.php:18
 * @route '/hidden/door/zone/master/blogs'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\BlogController::store
 * @see app/Http/Controllers/User/BlogController.php:18
 * @route '/hidden/door/zone/master/blogs'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\User\BlogController::update
 * @see app/Http/Controllers/User/BlogController.php:30
 * @route '/hidden/door/zone/master/blogs/{id}'
 */
export const update = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/hidden/door/zone/master/blogs/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\User\BlogController::update
 * @see app/Http/Controllers/User/BlogController.php:30
 * @route '/hidden/door/zone/master/blogs/{id}'
 */
update.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return update.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\BlogController::update
 * @see app/Http/Controllers/User/BlogController.php:30
 * @route '/hidden/door/zone/master/blogs/{id}'
 */
update.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\User\BlogController::update
 * @see app/Http/Controllers/User/BlogController.php:30
 * @route '/hidden/door/zone/master/blogs/{id}'
 */
    const updateForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\BlogController::update
 * @see app/Http/Controllers/User/BlogController.php:30
 * @route '/hidden/door/zone/master/blogs/{id}'
 */
        updateForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
/**
* @see \App\Http\Controllers\User\BlogController::destroy
 * @see app/Http/Controllers/User/BlogController.php:64
 * @route '/hidden/door/zone/master/blogs/{id}'
 */
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/hidden/door/zone/master/blogs/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\User\BlogController::destroy
 * @see app/Http/Controllers/User/BlogController.php:64
 * @route '/hidden/door/zone/master/blogs/{id}'
 */
destroy.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return destroy.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\BlogController::destroy
 * @see app/Http/Controllers/User/BlogController.php:64
 * @route '/hidden/door/zone/master/blogs/{id}'
 */
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\User\BlogController::destroy
 * @see app/Http/Controllers/User/BlogController.php:64
 * @route '/hidden/door/zone/master/blogs/{id}'
 */
    const destroyForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\BlogController::destroy
 * @see app/Http/Controllers/User/BlogController.php:64
 * @route '/hidden/door/zone/master/blogs/{id}'
 */
        destroyForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const blogs = {
    store,
update,
destroy,
}

export default blogs