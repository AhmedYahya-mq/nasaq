import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Settings\OtherBrowserSessionsController::destroy
 * @see app/Http/Controllers/Settings/OtherBrowserSessionsController.php:21
 * @route '/admin/\u0027settings/sessions'
 */
export const destroy = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/\u0027settings/sessions',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Settings\OtherBrowserSessionsController::destroy
 * @see app/Http/Controllers/Settings/OtherBrowserSessionsController.php:21
 * @route '/admin/\u0027settings/sessions'
 */
destroy.url = (options?: RouteQueryOptions) => {
    return destroy.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Settings\OtherBrowserSessionsController::destroy
 * @see app/Http/Controllers/Settings/OtherBrowserSessionsController.php:21
 * @route '/admin/\u0027settings/sessions'
 */
destroy.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Settings\OtherBrowserSessionsController::destroy
 * @see app/Http/Controllers/Settings/OtherBrowserSessionsController.php:21
 * @route '/admin/\u0027settings/sessions'
 */
    const destroyForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Settings\OtherBrowserSessionsController::destroy
 * @see app/Http/Controllers/Settings/OtherBrowserSessionsController.php:21
 * @route '/admin/\u0027settings/sessions'
 */
        destroyForm.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
/**
* @see \App\Http\Controllers\Settings\OtherBrowserSessionsController::destroyOne
 * @see app/Http/Controllers/Settings/OtherBrowserSessionsController.php:57
 * @route '/admin/settings/sessions/{sessionId}'
 */
export const destroyOne = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyOne.url(args, options),
    method: 'delete',
})

destroyOne.definition = {
    methods: ["delete"],
    url: '/admin/settings/sessions/{sessionId}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Settings\OtherBrowserSessionsController::destroyOne
 * @see app/Http/Controllers/Settings/OtherBrowserSessionsController.php:57
 * @route '/admin/settings/sessions/{sessionId}'
 */
destroyOne.url = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sessionId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    sessionId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        sessionId: args.sessionId,
                }

    return destroyOne.definition.url
            .replace('{sessionId}', parsedArgs.sessionId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Settings\OtherBrowserSessionsController::destroyOne
 * @see app/Http/Controllers/Settings/OtherBrowserSessionsController.php:57
 * @route '/admin/settings/sessions/{sessionId}'
 */
destroyOne.delete = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyOne.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Settings\OtherBrowserSessionsController::destroyOne
 * @see app/Http/Controllers/Settings/OtherBrowserSessionsController.php:57
 * @route '/admin/settings/sessions/{sessionId}'
 */
    const destroyOneForm = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroyOne.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Settings\OtherBrowserSessionsController::destroyOne
 * @see app/Http/Controllers/Settings/OtherBrowserSessionsController.php:57
 * @route '/admin/settings/sessions/{sessionId}'
 */
        destroyOneForm.delete = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroyOne.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroyOne.form = destroyOneForm
const sessions = {
    destroy,
destroyOne,
}

export default sessions