import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::__invoke
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
export const __invoke = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: __invoke.url(options),
    method: 'get',
})

__invoke.definition = {
    methods: ["get","head"],
    url: '/admin/email/verify',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::__invoke
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
__invoke.url = (options?: RouteQueryOptions) => {
    return __invoke.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::__invoke
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
__invoke.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: __invoke.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::__invoke
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
__invoke.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: __invoke.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::__invoke
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
    const __invokeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: __invoke.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::__invoke
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
        __invokeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: __invoke.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::__invoke
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
        __invokeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: __invoke.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    __invoke.form = __invokeForm
const EmailVerificationPromptController = { __invoke }

export default EmailVerificationPromptController