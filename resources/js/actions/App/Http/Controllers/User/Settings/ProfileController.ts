import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults, validateParameters } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\User\Settings\ProfileController::photoUpdate
 * @see app/Http/Controllers/User/Settings/ProfileController.php:25
 * @route '/api/user/profile-photo'
 */
export const photoUpdate = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: photoUpdate.url(options),
    method: 'post',
})

photoUpdate.definition = {
    methods: ["post"],
    url: '/api/user/profile-photo',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::photoUpdate
 * @see app/Http/Controllers/User/Settings/ProfileController.php:25
 * @route '/api/user/profile-photo'
 */
photoUpdate.url = (options?: RouteQueryOptions) => {
    return photoUpdate.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::photoUpdate
 * @see app/Http/Controllers/User/Settings/ProfileController.php:25
 * @route '/api/user/profile-photo'
 */
photoUpdate.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: photoUpdate.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\User\Settings\ProfileController::photoUpdate
 * @see app/Http/Controllers/User/Settings/ProfileController.php:25
 * @route '/api/user/profile-photo'
 */
    const photoUpdateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: photoUpdate.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::photoUpdate
 * @see app/Http/Controllers/User/Settings/ProfileController.php:25
 * @route '/api/user/profile-photo'
 */
        photoUpdateForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: photoUpdate.url(options),
            method: 'post',
        })
    
    photoUpdate.form = photoUpdateForm
/**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
const editf42fe1483114d7819678b9a3db662e1a = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editf42fe1483114d7819678b9a3db662e1a.url(args, options),
    method: 'get',
})

editf42fe1483114d7819678b9a3db662e1a.definition = {
    methods: ["get","head"],
    url: '/{locale?}/user/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
editf42fe1483114d7819678b9a3db662e1a.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return editf42fe1483114d7819678b9a3db662e1a.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
editf42fe1483114d7819678b9a3db662e1a.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: editf42fe1483114d7819678b9a3db662e1a.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
editf42fe1483114d7819678b9a3db662e1a.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: editf42fe1483114d7819678b9a3db662e1a.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
    const editf42fe1483114d7819678b9a3db662e1aForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: editf42fe1483114d7819678b9a3db662e1a.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
        editf42fe1483114d7819678b9a3db662e1aForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: editf42fe1483114d7819678b9a3db662e1a.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
        editf42fe1483114d7819678b9a3db662e1aForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: editf42fe1483114d7819678b9a3db662e1a.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    editf42fe1483114d7819678b9a3db662e1a.form = editf42fe1483114d7819678b9a3db662e1aForm
    /**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
const edit24336b274ff0444f46cda8a0a44a347b = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit24336b274ff0444f46cda8a0a44a347b.url(options),
    method: 'get',
})

edit24336b274ff0444f46cda8a0a44a347b.definition = {
    methods: ["get","head"],
    url: '/user/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
edit24336b274ff0444f46cda8a0a44a347b.url = (options?: RouteQueryOptions) => {
    return edit24336b274ff0444f46cda8a0a44a347b.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
edit24336b274ff0444f46cda8a0a44a347b.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit24336b274ff0444f46cda8a0a44a347b.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
edit24336b274ff0444f46cda8a0a44a347b.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit24336b274ff0444f46cda8a0a44a347b.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
    const edit24336b274ff0444f46cda8a0a44a347bForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit24336b274ff0444f46cda8a0a44a347b.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
        edit24336b274ff0444f46cda8a0a44a347bForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit24336b274ff0444f46cda8a0a44a347b.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::edit
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
        edit24336b274ff0444f46cda8a0a44a347bForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit24336b274ff0444f46cda8a0a44a347b.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    edit24336b274ff0444f46cda8a0a44a347b.form = edit24336b274ff0444f46cda8a0a44a347bForm

export const edit = {
    '/{locale?}/user/profile': editf42fe1483114d7819678b9a3db662e1a,
    '/user/profile': edit24336b274ff0444f46cda8a0a44a347b,
}

const ProfileController = { photoUpdate, edit }

export default ProfileController