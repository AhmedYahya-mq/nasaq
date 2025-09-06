import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults, validateParameters } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\User\Settings\ProfileController::update
 * @see app/Http/Controllers/User/Settings/ProfileController.php:28
 * @route '/{locale?}/user/profile-photo'
 */
export const update = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(args, options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/{locale?}/user/profile-photo',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::update
 * @see app/Http/Controllers/User/Settings/ProfileController.php:28
 * @route '/{locale?}/user/profile-photo'
 */
update.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::update
 * @see app/Http/Controllers/User/Settings/ProfileController.php:28
 * @route '/{locale?}/user/profile-photo'
 */
update.post = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\User\Settings\ProfileController::update
 * @see app/Http/Controllers/User/Settings/ProfileController.php:28
 * @route '/{locale?}/user/profile-photo'
 */
    const updateForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::update
 * @see app/Http/Controllers/User/Settings/ProfileController.php:28
 * @route '/{locale?}/user/profile-photo'
 */
        updateForm.post = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, options),
            method: 'post',
        })
    
    update.form = updateForm
const photo = {
    update,
}

export default photo