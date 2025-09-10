import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\User\Settings\ProfileController::update
 * @see app/Http/Controllers/User/Settings/ProfileController.php:28
 * @route '/user/profile-photo'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/user/profile-photo',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::update
 * @see app/Http/Controllers/User/Settings/ProfileController.php:28
 * @route '/user/profile-photo'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::update
 * @see app/Http/Controllers/User/Settings/ProfileController.php:28
 * @route '/user/profile-photo'
 */
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\User\Settings\ProfileController::update
 * @see app/Http/Controllers/User/Settings/ProfileController.php:28
 * @route '/user/profile-photo'
 */
    const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::update
 * @see app/Http/Controllers/User/Settings/ProfileController.php:28
 * @route '/user/profile-photo'
 */
        updateForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(options),
            method: 'post',
        })
    
    update.form = updateForm
const photo = {
    update,
}

export default photo