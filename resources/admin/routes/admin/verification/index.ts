import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::notice
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
export const notice = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: notice.url(options),
    method: 'get',
})

notice.definition = {
    methods: ["get","head"],
    url: '/admin/email/verify',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::notice
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
notice.url = (options?: RouteQueryOptions) => {
    return notice.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::notice
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
notice.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: notice.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::notice
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
notice.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: notice.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::notice
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
    const noticeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: notice.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::notice
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
        noticeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: notice.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Auth\EmailVerificationPromptController::notice
 * @see app/Http/Controllers/Auth/EmailVerificationPromptController.php:16
 * @route '/admin/email/verify'
 */
        noticeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: notice.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    notice.form = noticeForm
/**
* @see \App\Http\Controllers\Auth\VerifyEmailController::verify
 * @see app/Http/Controllers/Auth/VerifyEmailController.php:14
 * @route '/admin/email/verify/{id}/{hash}'
 */
export const verify = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(args, options),
    method: 'get',
})

verify.definition = {
    methods: ["get","head"],
    url: '/admin/email/verify/{id}/{hash}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\VerifyEmailController::verify
 * @see app/Http/Controllers/Auth/VerifyEmailController.php:14
 * @route '/admin/email/verify/{id}/{hash}'
 */
verify.url = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                    hash: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                                hash: args.hash,
                }

    return verify.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace('{hash}', parsedArgs.hash.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\VerifyEmailController::verify
 * @see app/Http/Controllers/Auth/VerifyEmailController.php:14
 * @route '/admin/email/verify/{id}/{hash}'
 */
verify.get = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Auth\VerifyEmailController::verify
 * @see app/Http/Controllers/Auth/VerifyEmailController.php:14
 * @route '/admin/email/verify/{id}/{hash}'
 */
verify.head = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: verify.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Auth\VerifyEmailController::verify
 * @see app/Http/Controllers/Auth/VerifyEmailController.php:14
 * @route '/admin/email/verify/{id}/{hash}'
 */
    const verifyForm = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: verify.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Auth\VerifyEmailController::verify
 * @see app/Http/Controllers/Auth/VerifyEmailController.php:14
 * @route '/admin/email/verify/{id}/{hash}'
 */
        verifyForm.get = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: verify.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Auth\VerifyEmailController::verify
 * @see app/Http/Controllers/Auth/VerifyEmailController.php:14
 * @route '/admin/email/verify/{id}/{hash}'
 */
        verifyForm.head = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: verify.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    verify.form = verifyForm
/**
* @see \App\Http\Controllers\Auth\EmailVerificationNotificationController::send
 * @see app/Http/Controllers/Auth/EmailVerificationNotificationController.php:14
 * @route '/admin/email/verification-notification'
 */
export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/admin/email/verification-notification',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Auth\EmailVerificationNotificationController::send
 * @see app/Http/Controllers/Auth/EmailVerificationNotificationController.php:14
 * @route '/admin/email/verification-notification'
 */
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\EmailVerificationNotificationController::send
 * @see app/Http/Controllers/Auth/EmailVerificationNotificationController.php:14
 * @route '/admin/email/verification-notification'
 */
send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Auth\EmailVerificationNotificationController::send
 * @see app/Http/Controllers/Auth/EmailVerificationNotificationController.php:14
 * @route '/admin/email/verification-notification'
 */
    const sendForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: send.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Auth\EmailVerificationNotificationController::send
 * @see app/Http/Controllers/Auth/EmailVerificationNotificationController.php:14
 * @route '/admin/email/verification-notification'
 */
        sendForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: send.url(options),
            method: 'post',
        })
    
    send.form = sendForm
const verification = {
    notice,
verify,
send,
}

export default verification