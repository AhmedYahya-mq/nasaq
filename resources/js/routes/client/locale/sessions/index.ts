import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults, validateParameters } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\User\Settings\OtherBrowserSessionsController::destroy
 * @see app/Http/Controllers/User/Settings/OtherBrowserSessionsController.php:21
 * @route '/{locale?}/settings/sessions'
 */
export const destroy = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/{locale?}/settings/sessions',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\User\Settings\OtherBrowserSessionsController::destroy
 * @see app/Http/Controllers/User/Settings/OtherBrowserSessionsController.php:21
 * @route '/{locale?}/settings/sessions'
 */
destroy.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { locale: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    locale: args[0],
                }
    }

    args = applyUrlDefaults(args)

    validateParameters(args, [
            "locale",
        ])

    const parsedArgs = {
                        locale: args?.locale,
                }

    return destroy.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\Settings\OtherBrowserSessionsController::destroy
 * @see app/Http/Controllers/User/Settings/OtherBrowserSessionsController.php:21
 * @route '/{locale?}/settings/sessions'
 */
destroy.delete = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\User\Settings\OtherBrowserSessionsController::destroy
 * @see app/Http/Controllers/User/Settings/OtherBrowserSessionsController.php:21
 * @route '/{locale?}/settings/sessions'
 */
    const destroyForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\Settings\OtherBrowserSessionsController::destroy
 * @see app/Http/Controllers/User/Settings/OtherBrowserSessionsController.php:21
 * @route '/{locale?}/settings/sessions'
 */
        destroyForm.delete = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const sessions = {
    destroy,
}

export default sessions