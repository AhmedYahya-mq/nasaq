import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults, validateParameters } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
const HomeController8ad1d6ee7ec35525f5453851d560eb7d = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HomeController8ad1d6ee7ec35525f5453851d560eb7d.url(args, options),
    method: 'get',
})

HomeController8ad1d6ee7ec35525f5453851d560eb7d.definition = {
    methods: ["get","head"],
    url: '/{locale?}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
HomeController8ad1d6ee7ec35525f5453851d560eb7d.url = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return HomeController8ad1d6ee7ec35525f5453851d560eb7d.definition.url
            .replace('{locale?}', parsedArgs.locale?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
HomeController8ad1d6ee7ec35525f5453851d560eb7d.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HomeController8ad1d6ee7ec35525f5453851d560eb7d.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
HomeController8ad1d6ee7ec35525f5453851d560eb7d.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: HomeController8ad1d6ee7ec35525f5453851d560eb7d.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
    const HomeController8ad1d6ee7ec35525f5453851d560eb7dForm = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: HomeController8ad1d6ee7ec35525f5453851d560eb7d.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
        HomeController8ad1d6ee7ec35525f5453851d560eb7dForm.get = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: HomeController8ad1d6ee7ec35525f5453851d560eb7d.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/{locale?}'
 */
        HomeController8ad1d6ee7ec35525f5453851d560eb7dForm.head = (args?: { locale?: string | number } | [locale: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: HomeController8ad1d6ee7ec35525f5453851d560eb7d.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    HomeController8ad1d6ee7ec35525f5453851d560eb7d.form = HomeController8ad1d6ee7ec35525f5453851d560eb7dForm
    /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
const HomeController980bb49ee7ae63891f1d891d2fbcf1c9 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HomeController980bb49ee7ae63891f1d891d2fbcf1c9.url(options),
    method: 'get',
})

HomeController980bb49ee7ae63891f1d891d2fbcf1c9.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
HomeController980bb49ee7ae63891f1d891d2fbcf1c9.url = (options?: RouteQueryOptions) => {
    return HomeController980bb49ee7ae63891f1d891d2fbcf1c9.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
HomeController980bb49ee7ae63891f1d891d2fbcf1c9.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HomeController980bb49ee7ae63891f1d891d2fbcf1c9.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
HomeController980bb49ee7ae63891f1d891d2fbcf1c9.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: HomeController980bb49ee7ae63891f1d891d2fbcf1c9.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
    const HomeController980bb49ee7ae63891f1d891d2fbcf1c9Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: HomeController980bb49ee7ae63891f1d891d2fbcf1c9.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
        HomeController980bb49ee7ae63891f1d891d2fbcf1c9Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: HomeController980bb49ee7ae63891f1d891d2fbcf1c9.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\User\HomeController::__invoke
 * @see app/Http/Controllers/User/HomeController.php:10
 * @route '/'
 */
        HomeController980bb49ee7ae63891f1d891d2fbcf1c9Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: HomeController980bb49ee7ae63891f1d891d2fbcf1c9.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    HomeController980bb49ee7ae63891f1d891d2fbcf1c9.form = HomeController980bb49ee7ae63891f1d891d2fbcf1c9Form

const HomeController = {
    '/{locale?}': HomeController8ad1d6ee7ec35525f5453851d560eb7d,
    '/': HomeController980bb49ee7ae63891f1d891d2fbcf1c9,
}

export default HomeController