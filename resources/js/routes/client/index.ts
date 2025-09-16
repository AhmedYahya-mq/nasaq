import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
import twoFactor from './two-factor'
import locale from './locale'
import profile from './profile'
import sessions from './sessions'
/**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
export const profile = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profile.url(options),
    method: 'get',
})

profile.definition = {
    methods: ["get","head"],
    url: '/user/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
profile.url = (options?: RouteQueryOptions) => {
    return profile.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
profile.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profile.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
profile.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: profile.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
    const profileForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: profile.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
        profileForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: profile.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\Settings\ProfileController::profile
 * @see app/Http/Controllers/User/Settings/ProfileController.php:20
 * @route '/user/profile'
 */
        profileForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: profile.url({
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
 * @route '/'
 */
export const home = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(options),
    method: 'get',
})

home.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
home.url = (options?: RouteQueryOptions) => {
    return home.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
home.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
home.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: home.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
    const homeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: home.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
        homeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: home.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
        homeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: home.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    home.form = homeForm
/**
 * @see routes/user.php:53
 * @route '/about'
 */
export const about = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(options),
    method: 'get',
})

about.definition = {
    methods: ["get","head"],
    url: '/about',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:53
 * @route '/about'
 */
about.url = (options?: RouteQueryOptions) => {
    return about.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:53
 * @route '/about'
 */
about.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:53
 * @route '/about'
 */
about.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: about.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:53
 * @route '/about'
 */
    const aboutForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: about.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:53
 * @route '/about'
 */
        aboutForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: about.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:53
 * @route '/about'
 */
        aboutForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: about.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    about.form = aboutForm
/**
 * @see routes/user.php:57
 * @route '/events'
 */
export const events = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})

events.definition = {
    methods: ["get","head"],
    url: '/events',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:57
 * @route '/events'
 */
events.url = (options?: RouteQueryOptions) => {
    return events.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:57
 * @route '/events'
 */
events.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:57
 * @route '/events'
 */
events.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: events.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:57
 * @route '/events'
 */
    const eventsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: events.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:57
 * @route '/events'
 */
        eventsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: events.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:57
 * @route '/events'
 */
        eventsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: events.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    events.form = eventsForm
/**
 * @see routes/user.php:61
 * @route '/library'
 */
export const library = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: library.url(options),
    method: 'get',
})

library.definition = {
    methods: ["get","head"],
    url: '/library',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:61
 * @route '/library'
 */
library.url = (options?: RouteQueryOptions) => {
    return library.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:61
 * @route '/library'
 */
library.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: library.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:61
 * @route '/library'
 */
library.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: library.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:61
 * @route '/library'
 */
    const libraryForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: library.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:61
 * @route '/library'
 */
        libraryForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: library.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:61
 * @route '/library'
 */
        libraryForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: library.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    library.form = libraryForm
/**
 * @see routes/user.php:65
 * @route '/archives'
 */
export const archives = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archives.url(options),
    method: 'get',
})

archives.definition = {
    methods: ["get","head"],
    url: '/archives',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:65
 * @route '/archives'
 */
archives.url = (options?: RouteQueryOptions) => {
    return archives.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:65
 * @route '/archives'
 */
archives.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archives.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:65
 * @route '/archives'
 */
archives.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: archives.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:65
 * @route '/archives'
 */
    const archivesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: archives.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:65
 * @route '/archives'
 */
        archivesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: archives.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:65
 * @route '/archives'
 */
        archivesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: archives.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    archives.form = archivesForm
/**
 * @see routes/user.php:69
 * @route '/archive'
 */
export const archive = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archive.url(options),
    method: 'get',
})

archive.definition = {
    methods: ["get","head"],
    url: '/archive',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:69
 * @route '/archive'
 */
archive.url = (options?: RouteQueryOptions) => {
    return archive.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:69
 * @route '/archive'
 */
archive.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archive.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:69
 * @route '/archive'
 */
archive.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: archive.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:69
 * @route '/archive'
 */
    const archiveForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: archive.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:69
 * @route '/archive'
 */
        archiveForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: archive.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:69
 * @route '/archive'
 */
        archiveForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: archive.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    archive.form = archiveForm
/**
 * @see routes/user.php:73
 * @route '/blogs'
 */
export const blogs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: blogs.url(options),
    method: 'get',
})

blogs.definition = {
    methods: ["get","head"],
    url: '/blogs',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:73
 * @route '/blogs'
 */
blogs.url = (options?: RouteQueryOptions) => {
    return blogs.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:73
 * @route '/blogs'
 */
blogs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: blogs.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:73
 * @route '/blogs'
 */
blogs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: blogs.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:73
 * @route '/blogs'
 */
    const blogsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: blogs.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:73
 * @route '/blogs'
 */
        blogsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: blogs.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:73
 * @route '/blogs'
 */
        blogsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: blogs.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    blogs.form = blogsForm
const client = {
    twoFactor,
locale,
profile,
sessions,
home,
about,
events,
library,
archives,
archive,
blogs,
}

export default client