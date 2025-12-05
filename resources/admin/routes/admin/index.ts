import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
import membership from './membership'
import membershipApplications from './membershipApplications'
import members from './members'
import blogs from './blogs'
import events from './events'
import event from './event'
import library from './library'
import profile from './profile'
import password from './password'
import twoFactor from './two-factor'
import sessions from './sessions'
import login from './login'
import verification from './verification'
/**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:18
 * @route '/hidden/door/zone/master'
 */
export const membership = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: membership.url(options),
    method: 'get',
})

membership.definition = {
    methods: ["get","head"],
    url: '/hidden/door/zone/master',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:18
 * @route '/hidden/door/zone/master'
 */
membership.url = (options?: RouteQueryOptions) => {
    return membership.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:18
 * @route '/hidden/door/zone/master'
 */
membership.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: membership.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:18
 * @route '/hidden/door/zone/master'
 */
membership.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: membership.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:18
 * @route '/hidden/door/zone/master'
 */
    const membershipForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: membership.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:18
 * @route '/hidden/door/zone/master'
 */
        membershipForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: membership.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:18
 * @route '/hidden/door/zone/master'
 */
        membershipForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: membership.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    membership.form = membershipForm
/**
* @see \App\Http\Controllers\User\MembershipController::memberships
 * @see app/Http/Controllers/User/MembershipController.php:13
 * @route '/hidden/door/zone/master/memberships'
 */
export const memberships = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: memberships.url(options),
    method: 'get',
})

memberships.definition = {
    methods: ["get","head"],
    url: '/hidden/door/zone/master/memberships',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\MembershipController::memberships
 * @see app/Http/Controllers/User/MembershipController.php:13
 * @route '/hidden/door/zone/master/memberships'
 */
memberships.url = (options?: RouteQueryOptions) => {
    return memberships.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\MembershipController::memberships
 * @see app/Http/Controllers/User/MembershipController.php:13
 * @route '/hidden/door/zone/master/memberships'
 */
memberships.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: memberships.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\MembershipController::memberships
 * @see app/Http/Controllers/User/MembershipController.php:13
 * @route '/hidden/door/zone/master/memberships'
 */
memberships.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: memberships.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\MembershipController::memberships
 * @see app/Http/Controllers/User/MembershipController.php:13
 * @route '/hidden/door/zone/master/memberships'
 */
    const membershipsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: memberships.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\MembershipController::memberships
 * @see app/Http/Controllers/User/MembershipController.php:13
 * @route '/hidden/door/zone/master/memberships'
 */
        membershipsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: memberships.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\MembershipController::memberships
 * @see app/Http/Controllers/User/MembershipController.php:13
 * @route '/hidden/door/zone/master/memberships'
 */
        membershipsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: memberships.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    memberships.form = membershipsForm
/**
* @see \App\Http\Controllers\MembershipApplictionController::membershipApplications
 * @see app/Http/Controllers/MembershipApplictionController.php:14
 * @route '/hidden/door/zone/master/membershipApplications'
 */
export const membershipApplications = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: membershipApplications.url(options),
    method: 'get',
})

membershipApplications.definition = {
    methods: ["get","head"],
    url: '/hidden/door/zone/master/membershipApplications',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\MembershipApplictionController::membershipApplications
 * @see app/Http/Controllers/MembershipApplictionController.php:14
 * @route '/hidden/door/zone/master/membershipApplications'
 */
membershipApplications.url = (options?: RouteQueryOptions) => {
    return membershipApplications.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\MembershipApplictionController::membershipApplications
 * @see app/Http/Controllers/MembershipApplictionController.php:14
 * @route '/hidden/door/zone/master/membershipApplications'
 */
membershipApplications.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: membershipApplications.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\MembershipApplictionController::membershipApplications
 * @see app/Http/Controllers/MembershipApplictionController.php:14
 * @route '/hidden/door/zone/master/membershipApplications'
 */
membershipApplications.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: membershipApplications.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\MembershipApplictionController::membershipApplications
 * @see app/Http/Controllers/MembershipApplictionController.php:14
 * @route '/hidden/door/zone/master/membershipApplications'
 */
    const membershipApplicationsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: membershipApplications.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\MembershipApplictionController::membershipApplications
 * @see app/Http/Controllers/MembershipApplictionController.php:14
 * @route '/hidden/door/zone/master/membershipApplications'
 */
        membershipApplicationsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: membershipApplications.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\MembershipApplictionController::membershipApplications
 * @see app/Http/Controllers/MembershipApplictionController.php:14
 * @route '/hidden/door/zone/master/membershipApplications'
 */
        membershipApplicationsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: membershipApplications.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    membershipApplications.form = membershipApplicationsForm
/**
* @see \App\Http\Controllers\UserController::members
 * @see app/Http/Controllers/UserController.php:12
 * @route '/hidden/door/zone/master/members'
 */
export const members = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: members.url(options),
    method: 'get',
})

members.definition = {
    methods: ["get","head"],
    url: '/hidden/door/zone/master/members',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\UserController::members
 * @see app/Http/Controllers/UserController.php:12
 * @route '/hidden/door/zone/master/members'
 */
members.url = (options?: RouteQueryOptions) => {
    return members.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\UserController::members
 * @see app/Http/Controllers/UserController.php:12
 * @route '/hidden/door/zone/master/members'
 */
members.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: members.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\UserController::members
 * @see app/Http/Controllers/UserController.php:12
 * @route '/hidden/door/zone/master/members'
 */
members.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: members.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\UserController::members
 * @see app/Http/Controllers/UserController.php:12
 * @route '/hidden/door/zone/master/members'
 */
    const membersForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: members.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\UserController::members
 * @see app/Http/Controllers/UserController.php:12
 * @route '/hidden/door/zone/master/members'
 */
        membersForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: members.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\UserController::members
 * @see app/Http/Controllers/UserController.php:12
 * @route '/hidden/door/zone/master/members'
 */
        membersForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: members.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    members.form = membersForm
/**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/hidden/door/zone/master/blogs'
 */
export const blogs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: blogs.url(options),
    method: 'get',
})

blogs.definition = {
    methods: ["get","head"],
    url: '/hidden/door/zone/master/blogs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/hidden/door/zone/master/blogs'
 */
blogs.url = (options?: RouteQueryOptions) => {
    return blogs.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/hidden/door/zone/master/blogs'
 */
blogs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: blogs.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/hidden/door/zone/master/blogs'
 */
blogs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: blogs.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/hidden/door/zone/master/blogs'
 */
    const blogsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: blogs.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/hidden/door/zone/master/blogs'
 */
        blogsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: blogs.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:13
 * @route '/hidden/door/zone/master/blogs'
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
/**
* @see \App\Http\Controllers\User\EventController::events
 * @see app/Http/Controllers/User/EventController.php:27
 * @route '/hidden/door/zone/master/events'
 */
export const events = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})

events.definition = {
    methods: ["get","head"],
    url: '/hidden/door/zone/master/events',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\EventController::events
 * @see app/Http/Controllers/User/EventController.php:27
 * @route '/hidden/door/zone/master/events'
 */
events.url = (options?: RouteQueryOptions) => {
    return events.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\EventController::events
 * @see app/Http/Controllers/User/EventController.php:27
 * @route '/hidden/door/zone/master/events'
 */
events.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\EventController::events
 * @see app/Http/Controllers/User/EventController.php:27
 * @route '/hidden/door/zone/master/events'
 */
events.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: events.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\EventController::events
 * @see app/Http/Controllers/User/EventController.php:27
 * @route '/hidden/door/zone/master/events'
 */
    const eventsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: events.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\EventController::events
 * @see app/Http/Controllers/User/EventController.php:27
 * @route '/hidden/door/zone/master/events'
 */
        eventsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: events.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\EventController::events
 * @see app/Http/Controllers/User/EventController.php:27
 * @route '/hidden/door/zone/master/events'
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
* @see \App\Http\Controllers\User\LibraryController::library
 * @see app/Http/Controllers/User/LibraryController.php:19
 * @route '/hidden/door/zone/master/library'
 */
export const library = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: library.url(options),
    method: 'get',
})

library.definition = {
    methods: ["get","head"],
    url: '/hidden/door/zone/master/library',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\LibraryController::library
 * @see app/Http/Controllers/User/LibraryController.php:19
 * @route '/hidden/door/zone/master/library'
 */
library.url = (options?: RouteQueryOptions) => {
    return library.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\LibraryController::library
 * @see app/Http/Controllers/User/LibraryController.php:19
 * @route '/hidden/door/zone/master/library'
 */
library.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: library.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\LibraryController::library
 * @see app/Http/Controllers/User/LibraryController.php:19
 * @route '/hidden/door/zone/master/library'
 */
library.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: library.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\LibraryController::library
 * @see app/Http/Controllers/User/LibraryController.php:19
 * @route '/hidden/door/zone/master/library'
 */
    const libraryForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: library.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\LibraryController::library
 * @see app/Http/Controllers/User/LibraryController.php:19
 * @route '/hidden/door/zone/master/library'
 */
        libraryForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: library.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\LibraryController::library
 * @see app/Http/Controllers/User/LibraryController.php:19
 * @route '/hidden/door/zone/master/library'
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
 * @see [serialized-closure]:2
 * @route '/hidden/door/zone/master/settings/appearance'
 */
export const appearance = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: appearance.url(options),
    method: 'get',
})

appearance.definition = {
    methods: ["get","head"],
    url: '/hidden/door/zone/master/settings/appearance',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see [serialized-closure]:2
 * @route '/hidden/door/zone/master/settings/appearance'
 */
appearance.url = (options?: RouteQueryOptions) => {
    return appearance.definition.url + queryParams(options)
}

/**
 * @see [serialized-closure]:2
 * @route '/hidden/door/zone/master/settings/appearance'
 */
appearance.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: appearance.url(options),
    method: 'get',
})
/**
 * @see [serialized-closure]:2
 * @route '/hidden/door/zone/master/settings/appearance'
 */
appearance.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: appearance.url(options),
    method: 'head',
})

    /**
 * @see [serialized-closure]:2
 * @route '/hidden/door/zone/master/settings/appearance'
 */
    const appearanceForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: appearance.url(options),
        method: 'get',
    })

            /**
 * @see [serialized-closure]:2
 * @route '/hidden/door/zone/master/settings/appearance'
 */
        appearanceForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: appearance.url(options),
            method: 'get',
        })
            /**
 * @see [serialized-closure]:2
 * @route '/hidden/door/zone/master/settings/appearance'
 */
        appearanceForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: appearance.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    appearance.form = appearanceForm
/**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/hidden/door/zone/master/settings/security'
 */
export const security = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: security.url(options),
    method: 'get',
})

security.definition = {
    methods: ["get","head"],
    url: '/hidden/door/zone/master/settings/security',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/hidden/door/zone/master/settings/security'
 */
security.url = (options?: RouteQueryOptions) => {
    return security.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/hidden/door/zone/master/settings/security'
 */
security.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: security.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/hidden/door/zone/master/settings/security'
 */
security.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: security.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/hidden/door/zone/master/settings/security'
 */
    const securityForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: security.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/hidden/door/zone/master/settings/security'
 */
        securityForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: security.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/hidden/door/zone/master/settings/security'
 */
        securityForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: security.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    security.form = securityForm
/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/hidden/door/zone/master/login'
 */
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/hidden/door/zone/master/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/hidden/door/zone/master/login'
 */
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/hidden/door/zone/master/login'
 */
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/hidden/door/zone/master/login'
 */
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/hidden/door/zone/master/login'
 */
    const loginForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: login.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/hidden/door/zone/master/login'
 */
        loginForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: login.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/hidden/door/zone/master/login'
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
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:100
 * @route '/hidden/door/zone/master/logout'
 */
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/hidden/door/zone/master/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:100
 * @route '/hidden/door/zone/master/logout'
 */
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:100
 * @route '/hidden/door/zone/master/logout'
 */
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:100
 * @route '/hidden/door/zone/master/logout'
 */
    const logoutForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: logout.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:100
 * @route '/hidden/door/zone/master/logout'
 */
        logoutForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: logout.url(options),
            method: 'post',
        })
    
    logout.form = logoutForm
const admin = {
    membership,
memberships,
membershipApplications,
members,
blogs,
events,
event,
library,
profile,
password,
appearance,
security,
twoFactor,
sessions,
login,
logout,
verification,
}

export default admin