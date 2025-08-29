import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \Laravel\Fortify\Http\Controllers\ProfileInformationController::update
 * @see vendor/laravel/fortify/src/Http/Controllers/ProfileInformationController.php:21
 * @route '/user/profile-information'
 */
const updateff08cb6693b71204c910cc859d0dab36 = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateff08cb6693b71204c910cc859d0dab36.url(options),
    method: 'put',
})

updateff08cb6693b71204c910cc859d0dab36.definition = {
    methods: ["put"],
    url: '/user/profile-information',
} satisfies RouteDefinition<["put"]>

/**
* @see \Laravel\Fortify\Http\Controllers\ProfileInformationController::update
 * @see vendor/laravel/fortify/src/Http/Controllers/ProfileInformationController.php:21
 * @route '/user/profile-information'
 */
updateff08cb6693b71204c910cc859d0dab36.url = (options?: RouteQueryOptions) => {
    return updateff08cb6693b71204c910cc859d0dab36.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\ProfileInformationController::update
 * @see vendor/laravel/fortify/src/Http/Controllers/ProfileInformationController.php:21
 * @route '/user/profile-information'
 */
updateff08cb6693b71204c910cc859d0dab36.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateff08cb6693b71204c910cc859d0dab36.url(options),
    method: 'put',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\ProfileInformationController::update
 * @see vendor/laravel/fortify/src/Http/Controllers/ProfileInformationController.php:21
 * @route '/user/profile-information'
 */
    const updateff08cb6693b71204c910cc859d0dab36Form = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: updateff08cb6693b71204c910cc859d0dab36.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\ProfileInformationController::update
 * @see vendor/laravel/fortify/src/Http/Controllers/ProfileInformationController.php:21
 * @route '/user/profile-information'
 */
        updateff08cb6693b71204c910cc859d0dab36Form.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: updateff08cb6693b71204c910cc859d0dab36.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    updateff08cb6693b71204c910cc859d0dab36.form = updateff08cb6693b71204c910cc859d0dab36Form
    /**
* @see \Laravel\Fortify\Http\Controllers\ProfileInformationController::update
 * @see vendor/laravel/fortify/src/Http/Controllers/ProfileInformationController.php:21
 * @route '/admin/settings/profile'
 */
const update8562ee3723325e24e2b233ab40f4f6e4 = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update8562ee3723325e24e2b233ab40f4f6e4.url(options),
    method: 'put',
})

update8562ee3723325e24e2b233ab40f4f6e4.definition = {
    methods: ["put"],
    url: '/admin/settings/profile',
} satisfies RouteDefinition<["put"]>

/**
* @see \Laravel\Fortify\Http\Controllers\ProfileInformationController::update
 * @see vendor/laravel/fortify/src/Http/Controllers/ProfileInformationController.php:21
 * @route '/admin/settings/profile'
 */
update8562ee3723325e24e2b233ab40f4f6e4.url = (options?: RouteQueryOptions) => {
    return update8562ee3723325e24e2b233ab40f4f6e4.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\ProfileInformationController::update
 * @see vendor/laravel/fortify/src/Http/Controllers/ProfileInformationController.php:21
 * @route '/admin/settings/profile'
 */
update8562ee3723325e24e2b233ab40f4f6e4.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update8562ee3723325e24e2b233ab40f4f6e4.url(options),
    method: 'put',
})

    /**
* @see \Laravel\Fortify\Http\Controllers\ProfileInformationController::update
 * @see vendor/laravel/fortify/src/Http/Controllers/ProfileInformationController.php:21
 * @route '/admin/settings/profile'
 */
    const update8562ee3723325e24e2b233ab40f4f6e4Form = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update8562ee3723325e24e2b233ab40f4f6e4.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \Laravel\Fortify\Http\Controllers\ProfileInformationController::update
 * @see vendor/laravel/fortify/src/Http/Controllers/ProfileInformationController.php:21
 * @route '/admin/settings/profile'
 */
        update8562ee3723325e24e2b233ab40f4f6e4Form.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update8562ee3723325e24e2b233ab40f4f6e4.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update8562ee3723325e24e2b233ab40f4f6e4.form = update8562ee3723325e24e2b233ab40f4f6e4Form

export const update = {
    '/user/profile-information': updateff08cb6693b71204c910cc859d0dab36,
    '/admin/settings/profile': update8562ee3723325e24e2b233ab40f4f6e4,
}

const ProfileInformationController = { update }

export default ProfileInformationController