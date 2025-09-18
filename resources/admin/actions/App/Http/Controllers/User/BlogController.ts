import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\User\BlogController::index
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/admin/blogs'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/blogs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\BlogController::index
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/admin/blogs'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\BlogController::index
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/admin/blogs'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\BlogController::index
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/admin/blogs'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\BlogController::index
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/admin/blogs'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\BlogController::index
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/admin/blogs'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\BlogController::index
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/admin/blogs'
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
* @see \App\Http\Controllers\User\BlogController::store
 * @see app/Http/Controllers/User/BlogController.php:18
 * @route '/admin/blogs'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/blogs',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\User\BlogController::store
 * @see app/Http/Controllers/User/BlogController.php:18
 * @route '/admin/blogs'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\BlogController::store
 * @see app/Http/Controllers/User/BlogController.php:18
 * @route '/admin/blogs'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\User\BlogController::store
 * @see app/Http/Controllers/User/BlogController.php:18
 * @route '/admin/blogs'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\BlogController::store
 * @see app/Http/Controllers/User/BlogController.php:18
 * @route '/admin/blogs'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\User\BlogController::update
 * @see app/Http/Controllers/User/BlogController.php:29
 * @route '/admin/blogs/{id}'
 */
export const update = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/blogs/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\User\BlogController::update
 * @see app/Http/Controllers/User/BlogController.php:29
 * @route '/admin/blogs/{id}'
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
 * @see app/Http/Controllers/User/BlogController.php:29
 * @route '/admin/blogs/{id}'
 */
update.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\User\BlogController::update
 * @see app/Http/Controllers/User/BlogController.php:29
 * @route '/admin/blogs/{id}'
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
 * @see app/Http/Controllers/User/BlogController.php:29
 * @route '/admin/blogs/{id}'
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
* @see \App\Http\Controllers\User\BlogController::updateTranslation
 * @see app/Http/Controllers/User/BlogController.php:43
 * @route '/admin/blogs/{id}/translation'
 */
export const updateTranslation = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateTranslation.url(args, options),
    method: 'put',
})

updateTranslation.definition = {
    methods: ["put"],
    url: '/admin/blogs/{id}/translation',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\User\BlogController::updateTranslation
 * @see app/Http/Controllers/User/BlogController.php:43
 * @route '/admin/blogs/{id}/translation'
 */
updateTranslation.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return updateTranslation.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\BlogController::updateTranslation
 * @see app/Http/Controllers/User/BlogController.php:43
 * @route '/admin/blogs/{id}/translation'
 */
updateTranslation.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateTranslation.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\User\BlogController::updateTranslation
 * @see app/Http/Controllers/User/BlogController.php:43
 * @route '/admin/blogs/{id}/translation'
 */
    const updateTranslationForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: updateTranslation.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\BlogController::updateTranslation
 * @see app/Http/Controllers/User/BlogController.php:43
 * @route '/admin/blogs/{id}/translation'
 */
        updateTranslationForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: updateTranslation.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    updateTranslation.form = updateTranslationForm
/**
* @see \App\Http\Controllers\User\BlogController::destroy
 * @see app/Http/Controllers/User/BlogController.php:53
 * @route '/admin/blogs/{id}'
 */
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/blogs/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\User\BlogController::destroy
 * @see app/Http/Controllers/User/BlogController.php:53
 * @route '/admin/blogs/{id}'
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
 * @see app/Http/Controllers/User/BlogController.php:53
 * @route '/admin/blogs/{id}'
 */
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\User\BlogController::destroy
 * @see app/Http/Controllers/User/BlogController.php:53
 * @route '/admin/blogs/{id}'
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
 * @see app/Http/Controllers/User/BlogController.php:53
 * @route '/admin/blogs/{id}'
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
const BlogController = { index, store, update, updateTranslation, destroy }

export default BlogController