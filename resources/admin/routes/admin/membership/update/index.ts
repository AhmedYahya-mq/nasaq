import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\User\MembershipController::translation
 * @see app/Http/Controllers/User/MembershipController.php:35
 * @route '/admin/membership/{membership}/translation'
 */
export const translation = (args: { membership: number | { id: number } } | [membership: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: translation.url(args, options),
    method: 'put',
})

translation.definition = {
    methods: ["put"],
    url: '/admin/membership/{membership}/translation',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\User\MembershipController::translation
 * @see app/Http/Controllers/User/MembershipController.php:35
 * @route '/admin/membership/{membership}/translation'
 */
translation.url = (args: { membership: number | { id: number } } | [membership: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return translation.definition.url
            .replace('{membership}', parsedArgs.membership.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\MembershipController::translation
 * @see app/Http/Controllers/User/MembershipController.php:35
 * @route '/admin/membership/{membership}/translation'
 */
translation.put = (args: { membership: number | { id: number } } | [membership: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: translation.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\User\MembershipController::translation
 * @see app/Http/Controllers/User/MembershipController.php:35
 * @route '/admin/membership/{membership}/translation'
 */
    const translationForm = (args: { membership: number | { id: number } } | [membership: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: translation.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\MembershipController::translation
 * @see app/Http/Controllers/User/MembershipController.php:35
 * @route '/admin/membership/{membership}/translation'
 */
        translationForm.put = (args: { membership: number | { id: number } } | [membership: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: translation.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    translation.form = translationForm
const update = {
    translation,
}

export default update