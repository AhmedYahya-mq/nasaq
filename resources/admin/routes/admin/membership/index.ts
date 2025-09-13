import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
import update from './update'
/**
* @see \App\Http\Controllers\User\MembershipController::store
 * @see app/Http/Controllers/User/MembershipController.php:17
 * @route '/admin/membership'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/membership',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\User\MembershipController::store
 * @see app/Http/Controllers/User/MembershipController.php:17
 * @route '/admin/membership'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\MembershipController::store
 * @see app/Http/Controllers/User/MembershipController.php:17
 * @route '/admin/membership'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\User\MembershipController::store
 * @see app/Http/Controllers/User/MembershipController.php:17
 * @route '/admin/membership'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\MembershipController::store
 * @see app/Http/Controllers/User/MembershipController.php:17
 * @route '/admin/membership'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\User\MembershipController::update
 * @see app/Http/Controllers/User/MembershipController.php:23
 * @route '/admin/membership/{membership}'
 */
export const update = (args: { membership: number | { id: number } } | [membership: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/membership/{membership}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\User\MembershipController::update
 * @see app/Http/Controllers/User/MembershipController.php:23
 * @route '/admin/membership/{membership}'
 */
update.url = (args: { membership: number | { id: number } } | [membership: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { membership: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { membership: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    membership: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        membership: typeof args.membership === 'object'
                ? args.membership.id
                : args.membership,
                }

    return update.definition.url
            .replace('{membership}', parsedArgs.membership.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\MembershipController::update
 * @see app/Http/Controllers/User/MembershipController.php:23
 * @route '/admin/membership/{membership}'
 */
update.put = (args: { membership: number | { id: number } } | [membership: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\User\MembershipController::update
 * @see app/Http/Controllers/User/MembershipController.php:23
 * @route '/admin/membership/{membership}'
 */
    const updateForm = (args: { membership: number | { id: number } } | [membership: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\MembershipController::update
 * @see app/Http/Controllers/User/MembershipController.php:23
 * @route '/admin/membership/{membership}'
 */
        updateForm.put = (args: { membership: number | { id: number } } | [membership: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\User\MembershipController::destroy
 * @see app/Http/Controllers/User/MembershipController.php:43
 * @route '/admin/membership/{id}'
 */
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/membership/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\User\MembershipController::destroy
 * @see app/Http/Controllers/User/MembershipController.php:43
 * @route '/admin/membership/{id}'
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
* @see \App\Http\Controllers\User\MembershipController::destroy
 * @see app/Http/Controllers/User/MembershipController.php:43
 * @route '/admin/membership/{id}'
 */
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\User\MembershipController::destroy
 * @see app/Http/Controllers/User/MembershipController.php:43
 * @route '/admin/membership/{id}'
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
* @see \App\Http\Controllers\User\MembershipController::destroy
 * @see app/Http/Controllers/User/MembershipController.php:43
 * @route '/admin/membership/{id}'
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
const membership = {
    store,
update,
destroy,
}

export default membership