import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults, validateParameters } from './../../../wayfinder'
/**
 * @see routes/user.php:5
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
 * @see routes/user.php:5
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
 * @see routes/user.php:5
 * @route '/{locale?}'
 */
home.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:5
 * @route '/{locale?}'
 */
home.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: home.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:5
 * @route '/{locale?}'
 */
    const homeForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: home.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:5
 * @route '/{locale?}'
 */
        homeForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: home.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:5
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
 * @see routes/user.php:29
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
 * @see routes/user.php:29
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
 * @see routes/user.php:29
 * @route '/{locale?}/about'
 */
about.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:29
 * @route '/{locale?}/about'
 */
about.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: about.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:29
 * @route '/{locale?}/about'
 */
    const aboutForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: about.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:29
 * @route '/{locale?}/about'
 */
        aboutForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: about.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:29
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
 * @see routes/user.php:16
 * @route '/{locale?}/profile'
 */
export const profile = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profile.url(args, options),
    method: 'get',
})

profile.definition = {
    methods: ["get","head"],
    url: '/{locale?}/profile',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:16
 * @route '/{locale?}/profile'
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
 * @see routes/user.php:16
 * @route '/{locale?}/profile'
 */
profile.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profile.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:16
 * @route '/{locale?}/profile'
 */
profile.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: profile.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:16
 * @route '/{locale?}/profile'
 */
    const profileForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: profile.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:16
 * @route '/{locale?}/profile'
 */
        profileForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: profile.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:16
 * @route '/{locale?}/profile'
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
 * @see routes/user.php:23
 * @route '/{locale?}/login'
 */
export const login = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(args, options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/{locale?}/login',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:23
 * @route '/{locale?}/login'
 */
login.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return login.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
 * @see routes/user.php:23
 * @route '/{locale?}/login'
 */
login.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:23
 * @route '/{locale?}/login'
 */
login.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:23
 * @route '/{locale?}/login'
 */
    const loginForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: login.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:23
 * @route '/{locale?}/login'
 */
        loginForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: login.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:23
 * @route '/{locale?}/login'
 */
        loginForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: login.url(args, {
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
 * @route '/{locale?}/register'
 */
export const register = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(args, options),
    method: 'get',
})

register.definition = {
    methods: ["get","head"],
    url: '/{locale?}/register',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:26
 * @route '/{locale?}/register'
 */
register.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return register.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
 * @see routes/user.php:26
 * @route '/{locale?}/register'
 */
register.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:26
 * @route '/{locale?}/register'
 */
register.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: register.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:26
 * @route '/{locale?}/register'
 */
    const registerForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: register.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:26
 * @route '/{locale?}/register'
 */
        registerForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: register.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:26
 * @route '/{locale?}/register'
 */
        registerForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: register.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    register.form = registerForm
/**
 * @see routes/user.php:33
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
 * @see routes/user.php:33
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
 * @see routes/user.php:33
 * @route '/{locale?}/events'
 */
events.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:33
 * @route '/{locale?}/events'
 */
events.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: events.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:33
 * @route '/{locale?}/events'
 */
    const eventsForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: events.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:33
 * @route '/{locale?}/events'
 */
        eventsForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: events.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:33
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
 * @see routes/user.php:37
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
 * @see routes/user.php:37
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
 * @see routes/user.php:37
 * @route '/{locale?}/library'
 */
library.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: library.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:37
 * @route '/{locale?}/library'
 */
library.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: library.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:37
 * @route '/{locale?}/library'
 */
    const libraryForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: library.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:37
 * @route '/{locale?}/library'
 */
        libraryForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: library.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:37
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
 * @see routes/user.php:41
 * @route '/{locale?}/archives'
 */
export const archives = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archives.url(args, options),
    method: 'get',
})

archives.definition = {
    methods: ["get","head"],
    url: '/{locale?}/archives',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:41
 * @route '/{locale?}/archives'
 */
archives.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return archives.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
 * @see routes/user.php:41
 * @route '/{locale?}/archives'
 */
archives.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archives.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:41
 * @route '/{locale?}/archives'
 */
archives.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: archives.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:41
 * @route '/{locale?}/archives'
 */
    const archivesForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: archives.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:41
 * @route '/{locale?}/archives'
 */
        archivesForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: archives.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:41
 * @route '/{locale?}/archives'
 */
        archivesForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: archives.url(args, {
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
 * @route '/{locale?}/archive'
 */
export const archive = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archive.url(args, options),
    method: 'get',
})

archive.definition = {
    methods: ["get","head"],
    url: '/{locale?}/archive',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/user.php:45
 * @route '/{locale?}/archive'
 */
archive.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return archive.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
 * @see routes/user.php:45
 * @route '/{locale?}/archive'
 */
archive.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: archive.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:45
 * @route '/{locale?}/archive'
 */
archive.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: archive.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:45
 * @route '/{locale?}/archive'
 */
    const archiveForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: archive.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:45
 * @route '/{locale?}/archive'
 */
        archiveForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: archive.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:45
 * @route '/{locale?}/archive'
 */
        archiveForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: archive.url(args, {
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
 * @see routes/user.php:49
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
 * @see routes/user.php:49
 * @route '/{locale?}/blogs'
 */
blogs.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: blogs.url(args, options),
    method: 'get',
})
/**
 * @see routes/user.php:49
 * @route '/{locale?}/blogs'
 */
blogs.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: blogs.url(args, options),
    method: 'head',
})

    /**
 * @see routes/user.php:49
 * @route '/{locale?}/blogs'
 */
    const blogsForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: blogs.url(args, options),
        method: 'get',
    })

            /**
 * @see routes/user.php:49
 * @route '/{locale?}/blogs'
 */
        blogsForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: blogs.url(args, options),
            method: 'get',
        })
            /**
 * @see routes/user.php:49
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
    home,
about,
profile,
login,
register,
events,
library,
archives,
archive,
blogs,
}

export default locale