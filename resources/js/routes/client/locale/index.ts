import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults, validateParameters } from './../../../wayfinder'
import profile from './profile'
import twoFactor from './two-factor'
import sessions from './sessions'
/**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
export const profile = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profile.url(args, options),
    method: 'get',
})

profile.definition = {
    methods: ["get","head"],
    url: '/{locale?}/user/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
profile.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return profile.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
profile.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profile.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
profile.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: profile.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
    const profileForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: profile.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
        profileForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: profile.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/{locale?}/user/profile'
 */
        profileForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: profile.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    profile.form = profileForm
/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
export const home = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(args, options),
    method: 'get',
})

home.definition = {
    methods: ["get","head"],
    url: '/{locale?}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
home.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return home.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
home.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
home.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: home.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
    const homeForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: home.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
        homeForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: home.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
        homeForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: home.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    home.form = homeForm
/**
 * @see routes/user.php:59
 * @route '/{locale?}/about'
 */
export const about = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(args, options),
    method: 'get',
})

about.definition = {
    methods: ["get","head"],
    url: '/{locale?}/about',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:59
 * @route '/{locale?}/about'
 */
about.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return about.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
 * @see routes/user.php:59
 * @route '/{locale?}/about'
 */
about.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:59
 * @route '/{locale?}/about'
 */
about.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: about.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:59
 * @route '/{locale?}/about'
 */
    const aboutForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: about.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:59
 * @route '/{locale?}/about'
 */
        aboutForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: about.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:59
 * @route '/{locale?}/about'
 */
        aboutForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: about.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    about.form = aboutForm
/**
 * @see routes/user.php:63
 * @route '/{locale?}/events'
 */
export const events = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(args, options),
    method: 'get',
})

events.definition = {
    methods: ["get","head"],
    url: '/{locale?}/events',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:63
 * @route '/{locale?}/events'
 */
events.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return events.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
 * @see routes/user.php:63
 * @route '/{locale?}/events'
 */
events.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:63
 * @route '/{locale?}/events'
 */
events.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: events.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:63
 * @route '/{locale?}/events'
 */
    const eventsForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: events.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:63
 * @route '/{locale?}/events'
 */
        eventsForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: events.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:63
 * @route '/{locale?}/events'
 */
        eventsForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: events.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    events.form = eventsForm
/**
 * @see routes/user.php:67
 * @route '/{locale?}/library'
 */
export const library = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: library.url(args, options),
    method: 'get',
})

library.definition = {
    methods: ["get","head"],
    url: '/{locale?}/library',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:67
 * @route '/{locale?}/library'
 */
library.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return library.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
 * @see routes/user.php:67
 * @route '/{locale?}/library'
 */
library.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: library.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:67
 * @route '/{locale?}/library'
 */
library.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: library.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:67
 * @route '/{locale?}/library'
 */
    const libraryForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: library.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:67
 * @route '/{locale?}/library'
 */
        libraryForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: library.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:67
 * @route '/{locale?}/library'
 */
        libraryForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: library.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    library.form = libraryForm
/**
 * @see routes/user.php:71
 * @route '/{locale?}/blogs'
 */
export const blogs = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: blogs.url(args, options),
    method: 'get',
})

blogs.definition = {
    methods: ["get","head"],
    url: '/{locale?}/blogs',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:71
 * @route '/{locale?}/blogs'
 */
blogs.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return blogs.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
 * @see routes/user.php:71
 * @route '/{locale?}/blogs'
 */
blogs.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: blogs.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:71
 * @route '/{locale?}/blogs'
 */
blogs.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: blogs.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:71
 * @route '/{locale?}/blogs'
 */
    const blogsForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: blogs.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:71
 * @route '/{locale?}/blogs'
 */
        blogsForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: blogs.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:71
 * @route '/{locale?}/blogs'
 */
        blogsForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: blogs.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    blogs.form = blogsForm
const locale = {
    profile,
twoFactor,
sessions,
home,
about,
events,
library,
blogs,
}

export default locale