import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
import locale from './locale'
/**
 * @see routes/user.php:23
 * @route '/login'
 */
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/login',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:23
 * @route '/login'
 */
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:23
 * @route '/login'
 */
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:23
 * @route '/login'
 */
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:23
 * @route '/login'
 */
    const loginForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: login.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:23
 * @route '/login'
 */
        loginForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: login.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:23
 * @route '/login'
 */
        loginForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: login.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    login.form = loginForm
/**
 * @see routes/user.php:26
 * @route '/register'
 */
export const register = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})

register.definition = {
    methods: ["get","head"],
    url: '/register',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:26
 * @route '/register'
 */
register.url = (options?: RouteQueryOptions) => {
    return register.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:26
 * @route '/register'
 */
register.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:26
 * @route '/register'
 */
register.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: register.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:26
 * @route '/register'
 */
    const registerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: register.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:26
 * @route '/register'
 */
        registerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: register.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:26
 * @route '/register'
 */
        registerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: register.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    register.form = registerForm
/**
 * @see routes/user.php:5
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
 * @see routes/user.php:5
 * @route '/'
 */
home.url = (options?: RouteQueryOptions) => {
    return home.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:5
 * @route '/'
 */
home.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:5
 * @route '/'
 */
home.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: home.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:5
 * @route '/'
 */
    const homeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: home.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:5
 * @route '/'
 */
        homeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: home.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:5
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
 * @see routes/user.php:29
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
 * @see routes/user.php:29
 * @route '/about'
 */
about.url = (options?: RouteQueryOptions) => {
    return about.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:29
 * @route '/about'
 */
about.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:29
 * @route '/about'
 */
about.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: about.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:29
 * @route '/about'
 */
    const aboutForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: about.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:29
 * @route '/about'
 */
        aboutForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: about.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:29
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
 * @see routes/user.php:16
 * @route '/profile'
 */
export const profile = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profile.url(options),
    method: 'get',
})

profile.definition = {
    methods: ["get","head"],
    url: '/profile',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:16
 * @route '/profile'
 */
profile.url = (options?: RouteQueryOptions) => {
    return profile.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:16
 * @route '/profile'
 */
profile.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profile.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:16
 * @route '/profile'
 */
profile.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: profile.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:16
 * @route '/profile'
 */
    const profileForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: profile.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:16
 * @route '/profile'
 */
        profileForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: profile.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:16
 * @route '/profile'
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
 * @see routes/user.php:33
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
 * @see routes/user.php:33
 * @route '/events'
 */
events.url = (options?: RouteQueryOptions) => {
    return events.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:33
 * @route '/events'
 */
events.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:33
 * @route '/events'
 */
events.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: events.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:33
 * @route '/events'
 */
    const eventsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: events.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:33
 * @route '/events'
 */
        eventsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: events.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:33
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
 * @see routes/user.php:37
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
 * @see routes/user.php:37
 * @route '/library'
 */
library.url = (options?: RouteQueryOptions) => {
    return library.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:37
 * @route '/library'
 */
library.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: library.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:37
 * @route '/library'
 */
library.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: library.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:37
 * @route '/library'
 */
    const libraryForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: library.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:37
 * @route '/library'
 */
        libraryForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: library.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:37
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
 * @see routes/user.php:41
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
 * @see routes/user.php:41
 * @route '/archives'
 */
archives.url = (options?: RouteQueryOptions) => {
    return archives.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:41
 * @route '/archives'
 */
archives.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archives.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:41
 * @route '/archives'
 */
archives.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: archives.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:41
 * @route '/archives'
 */
    const archivesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: archives.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:41
 * @route '/archives'
 */
        archivesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: archives.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:41
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
 * @see routes/user.php:45
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
 * @see routes/user.php:45
 * @route '/archive'
 */
archive.url = (options?: RouteQueryOptions) => {
    return archive.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:45
 * @route '/archive'
 */
archive.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archive.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:45
 * @route '/archive'
 */
archive.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: archive.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:45
 * @route '/archive'
 */
    const archiveForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: archive.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:45
 * @route '/archive'
 */
        archiveForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: archive.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:45
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
 * @see routes/user.php:49
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
 * @see routes/user.php:49
 * @route '/blogs'
 */
blogs.url = (options?: RouteQueryOptions) => {
    return blogs.definition.url + queryParams(options)
}

/**
 * @see routes/user.php:49
 * @route '/blogs'
 */
blogs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: blogs.url(options),
    method: 'get',
})
/**
 * @see routes/user.php:49
 * @route '/blogs'
 */
blogs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: blogs.url(options),
    method: 'head',
})

    /**
 * @see routes/user.php:49
 * @route '/blogs'
 */
    const blogsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: blogs.url(options),
        method: 'get',
    })

            /**
 * @see routes/user.php:49
 * @route '/blogs'
 */
        blogsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: blogs.url(options),
            method: 'get',
        })
            /**
 * @see routes/user.php:49
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
    login,
register,
locale,
home,
about,
profile,
events,
library,
archives,
archive,
blogs,
}

export default client