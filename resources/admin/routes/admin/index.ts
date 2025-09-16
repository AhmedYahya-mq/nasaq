import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
import membership from './membership'
import blogs from './blogs'
import profile from './profile'
import password from './password'
import twoFactor from './two-factor'
import sessions from './sessions'
import login from './login'
import verification from './verification'
/**
 * @see routes/admin.php:9
 * @route '/admin/dashboard'
 */
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/admin/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/admin.php:9
 * @route '/admin/dashboard'
 */
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
 * @see routes/admin.php:9
 * @route '/admin/dashboard'
 */
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})
/**
 * @see routes/admin.php:9
 * @route '/admin/dashboard'
 */
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

    /**
 * @see routes/admin.php:9
 * @route '/admin/dashboard'
 */
    const dashboardForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: dashboard.url(options),
        method: 'get',
    })

            /**
 * @see routes/admin.php:9
 * @route '/admin/dashboard'
 */
        dashboardForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboard.url(options),
            method: 'get',
        })
            /**
 * @see routes/admin.php:9
 * @route '/admin/dashboard'
 */
        dashboardForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboard.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    dashboard.form = dashboardForm
/**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:12
 * @route '/admin/membership'
 */
export const membership = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: membership.url(options),
    method: 'get',
})

membership.definition = {
    methods: ["get","head"],
    url: '/admin/membership',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:12
 * @route '/admin/membership'
 */
membership.url = (options?: RouteQueryOptions) => {
    return membership.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:12
 * @route '/admin/membership'
 */
membership.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: membership.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:12
 * @route '/admin/membership'
 */
membership.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: membership.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:12
 * @route '/admin/membership'
 */
    const membershipForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: membership.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:12
 * @route '/admin/membership'
 */
        membershipForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: membership.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\MembershipController::membership
 * @see app/Http/Controllers/User/MembershipController.php:12
 * @route '/admin/membership'
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
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:12
 * @route '/admin/blogs'
 */
export const blogs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: blogs.url(options),
    method: 'get',
})

blogs.definition = {
    methods: ["get","head"],
    url: '/admin/blogs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:12
 * @route '/admin/blogs'
 */
blogs.url = (options?: RouteQueryOptions) => {
    return blogs.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:12
 * @route '/admin/blogs'
 */
blogs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: blogs.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:12
 * @route '/admin/blogs'
 */
blogs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: blogs.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:12
 * @route '/admin/blogs'
 */
    const blogsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: blogs.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:12
 * @route '/admin/blogs'
 */
        blogsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: blogs.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\BlogController::blogs
 * @see app/Http/Controllers/User/BlogController.php:12
 * @route '/admin/blogs'
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
 * @see routes/admin.php:25
 * @route '/admin/membershipApplications'
 */
export const membershipApplications = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: membershipApplications.url(options),
    method: 'get',
})

membershipApplications.definition = {
    methods: ["get","head"],
    url: '/admin/membershipApplications',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/admin.php:25
 * @route '/admin/membershipApplications'
 */
membershipApplications.url = (options?: RouteQueryOptions) => {
    return membershipApplications.definition.url + queryParams(options)
}

/**
 * @see routes/admin.php:25
 * @route '/admin/membershipApplications'
 */
membershipApplications.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: membershipApplications.url(options),
    method: 'get',
})
/**
 * @see routes/admin.php:25
 * @route '/admin/membershipApplications'
 */
membershipApplications.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: membershipApplications.url(options),
    method: 'head',
})

    /**
 * @see routes/admin.php:25
 * @route '/admin/membershipApplications'
 */
    const membershipApplicationsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: membershipApplications.url(options),
        method: 'get',
    })

            /**
 * @see routes/admin.php:25
 * @route '/admin/membershipApplications'
 */
        membershipApplicationsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: membershipApplications.url(options),
            method: 'get',
        })
            /**
 * @see routes/admin.php:25
 * @route '/admin/membershipApplications'
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
 * @see routes/settings.php:39
 * @route '/admin/settings/appearance'
 */
export const appearance = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: appearance.url(options),
    method: 'get',
})

appearance.definition = {
    methods: ["get","head"],
    url: '/admin/settings/appearance',
} satisfies RouteDefinition<["get","head"]>

/**
 * @see routes/settings.php:39
 * @route '/admin/settings/appearance'
 */
appearance.url = (options?: RouteQueryOptions) => {
    return appearance.definition.url + queryParams(options)
}

/**
 * @see routes/settings.php:39
 * @route '/admin/settings/appearance'
 */
appearance.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: appearance.url(options),
    method: 'get',
})
/**
 * @see routes/settings.php:39
 * @route '/admin/settings/appearance'
 */
appearance.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: appearance.url(options),
    method: 'head',
})

    /**
 * @see routes/settings.php:39
 * @route '/admin/settings/appearance'
 */
    const appearanceForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: appearance.url(options),
        method: 'get',
    })

            /**
 * @see routes/settings.php:39
 * @route '/admin/settings/appearance'
 */
        appearanceForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: appearance.url(options),
            method: 'get',
        })
            /**
 * @see routes/settings.php:39
 * @route '/admin/settings/appearance'
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
 * @route '/admin/settings/security'
 */
export const security = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: security.url(options),
    method: 'get',
})

security.definition = {
    methods: ["get","head"],
    url: '/admin/settings/security',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
security.url = (options?: RouteQueryOptions) => {
    return security.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
security.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: security.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
security.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: security.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
    const securityForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: security.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
 */
        securityForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: security.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Settings\SecurityController::security
 * @see app/Http/Controllers/Settings/SecurityController.php:24
 * @route '/admin/settings/security'
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
 * @route '/admin/login'
 */
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/admin/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/admin/login'
 */
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/admin/login'
 */
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/admin/login'
 */
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/admin/login'
 */
    const loginForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: login.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/admin/login'
 */
        loginForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: login.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::login
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:46
 * @route '/admin/login'
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
 * @route '/admin/logout'
 */
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/admin/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:100
 * @route '/admin/logout'
 */
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:100
 * @route '/admin/logout'
 */
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:100
 * @route '/admin/logout'
 */
    const logoutForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: logout.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Auth\AuthenticatedSessionController::logout
 * @see app/Http/Controllers/Auth/AuthenticatedSessionController.php:100
 * @route '/admin/logout'
 */
        logoutForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: logout.url(options),
            method: 'post',
        })
    
    logout.form = logoutForm
const admin = {
    dashboard,
membership,
blogs,
membershipApplications,
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