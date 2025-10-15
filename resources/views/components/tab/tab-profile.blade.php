<div class="relative pb-14">
    <form x-data='profileForm(@json($user))' @submit.prevent='submit' x-ref="form" method="post">
        <div>
            <x-forms.input id="email" name="email" label="{{ __('profile.email') }}" type="email"
                placeholder="{{ __('profile.email_placeholder') }}" class="w-full" icon="mail" x-model="form.email" />
            <template x-if="errors.email">
                <div class="text-sm text-destructive" x-text="errors.email"></div>
            </template>
            <div x-show="isVerificationRequired" class="mt-2 text-sm text-yellow-600 flex items-center gap-1">
                <span>@lang('profile.email_not_verified')</span>
                <button type="button"
                    class="underline text-primary hover:text-primary/80 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary rounded "
                    @click="sendVerification" :disabled="loading">
                    <span x-show="!loading" x-text='textSendEmail'></span>
                    <span x-show="loading">@lang('profile.sending_verification_link')...
                        <div
                            class="mx-1 animate-spin inline-block w-4 h-4 border-2 border-current border-t-transparent rounded-full ml-1">

                        </div>
                    </span>
                </button>
            </div>
            <div x-show='isSendEmail' class="text-sm text-green-600 mt-2">
                @lang('profile.verification_link_sent')
            </div>
            <div x-show='isErrorSendEmail' class="text-sm text-destructive mt-2">
                @lang('profile.error_sending_verification_link')
            </div>
        </div>
        <div class="@container flex flex-col gap-y-3.5">
            <div class="grid grid-cols-1 @md:grid-cols-2 gap-4">
                <div>
                    <x-forms.input id="first-name" name="name" label="{{ __('profile.first_name') }}" type="text" placeholder="{{ __('profile.first_name_placeholder') }}"
                        class="w-full mb-3.5" icon="user" x-model="form.name" />
                    <template x-if="errors.name">
                        <div class="text-sm text-destructive" x-text="errors.name"></div>
                    </template>
                </div>
                <div>
                    <x-forms.tel-input id="phone" name="phone" label="{{ __('profile.phone') }}" x-model="form.phone"
                        value="{{ $user->phone }}" />
                    <template x-if="errors.phone">
                        <div class="text-sm text-destructive" x-text="errors.phone"></div>
                    </template>
                </div>
                <div>
                    <x-forms.input id="address" name="address" x-model="form.address" label="{{ __('profile.address') }}" type="text"
                        placeholder="{{ __('profile.address') }}" class="w-full" icon="location" />
                    <template x-if="errors.address">
                        <div class="text-sm text-destructive" x-text="errors.address"></div>
                    </template>
                </div>
                <div>
                    <x-forms.datepicker label="{{ __('profile.birthday') }}" id="birthday" x-init="$watch('selectedDate', value => form.birthday = value)"
                        value="{{ $user->birthday }}" name="birthday" />
                    <template x-if="errors.birthday">
                        <div class="text-sm text-destructive" x-text="errors.birthday"></div>
                    </template>
                </div>
            </div>
            <div>
                <x-forms.input id="job-title" name="job-title" x-model="form.job_title" label="{{ __('profile.job_title') }}"
                    type="text" placeholder="{{ __('profile.job_title') }}" class="w-full" icon="job" />
                <template x-if="errors.job_title">
                    <div class="text-sm text-destructive" x-text="errors.job_title"></div>
                </template>
            </div>
            <div>
                <x-forms.select id="employment_status" name="employment_status" x-model="form.employment_status"
                    label="{{ __('profile.employment_status') }}" :options="\App\Enums\EmploymentStatus::toKeyValueArray()" />

                <template x-if="errors.employment_status">
                    <div class="text-sm text-destructive" x-text="errors.employment_status"></div>
                </template>
            </div>
            <div>
                <x-forms.text-area name="bio" x-model="form.bio" label="{{ __('profile.bio') }}" placeholder="{{ __('profile.bio_placeholder') }}" />
                <template x-if="errors.bio">
                    <div class="text-sm text-destructive" x-text="errors.bio"></div>
                </template>
            </div>
        </div>
        <div class="absolute bottom-0 rtl:left-5 ltr:right-5 flex items-center gap-3 rtl:flex-row-reverse">
            <div class="flex gap-3">
                <button :disabled="disabled"
                    class="flex rtl:flex-row-reverse items-center gap-1.5 badget badget-primary hover:badget-80 disabled:badget-primary/35 transition-colors py-2 px-3 rounded-md hover:bg-primary/60 cursor-pointer"
                    aria-label="{{ __('profile.update') }}">
                    {{-- loading spinner --}}
                    <span x-show="disabled" class="border-2 border-primary border-r-transparent inline-block rounded-full size-4 animate-spin"></span>
                    {{ __('profile.update') }}
                </button>
                <button type="button" :disabled="disabled" @click="reset"
                    class="badget badget-destructive hover:badget-70 disabled:badget-destructive/35 py-2 px-3 rounded-md transition-colors cursor-pointer"
                    aria-label="{{ __('profile.cancel') }}">

                    {{ __('profile.cancel') }}
                </button>
            </div>
            <div x-show="saved" x-transition class="text-sm text-green-600 font-medium">
                {{ __('profile.saved') }}
            </div>
        </div>
    </form>
</div>
