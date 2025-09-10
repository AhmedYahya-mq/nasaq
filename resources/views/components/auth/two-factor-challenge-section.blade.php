<section
    x-data="{ authMethod: 'app' }"
    class="min-h-screen flex-center p-4 sm:p-6"
>
    <div class="w-full max-w-md mx-auto z-10">

        <div class="card animate-card-enter border border-border">
            <div class="">

                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-lg bg-primary/10 border border-primary/20">
                    <x-ui.icon name="lock-closed" class="h-8 w-8 text-primary" />
                </div>
                <h2 class="text-3xl font-extrabold text-center text-foreground">{{ __('login.2fa_title') }}</h2>
                <p class="text-muted-foreground text-center mt-2">{{ __('login.2fa_subtitle') }}</p>

                <form action="{{ $actionUrl }}" method="POST" class="mt-8 ">
                    @csrf
                    <input type="hidden" name="challenge_type" :value="authMethod">

                    <div x-show="authMethod === 'app'" x-transition>
                        <x-forms.input
                            type="text"
                            name="code"
                            id="code"
                            :label="__('login.2fa_app_code_label')"
                            :placeholder="__('login.2fa_code_placeholder')"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            maxlength="6"
                            x-on:input="$event.target.value = $event.target.value.replace(/[^0-9]/g, '')"
                            class="r text-2xl tracking-[0.5em] text-center"
                        />
                    </div>

                    <div x-show="authMethod === 'recovery'" x-transition style="display: none;">
                        <x-forms.input
                            type="text"
                            name="recovery_code"
                            id="recovery_code"
                            :label="__('login.2fa_recovery_code_label')"
                            :placeholder="__('login.2fa_recovery_code_placeholder')"
                            maxlength="10"
                            x-on:input="$event.target.value = $event.target.value.replace(/[^a-zA-Z0-9]/g, '')"
                            class="text-lg"
                        />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full  font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring bg-primary transition-all">
                            {{ __('login.2fa_verify_button') }}
                        </button>
                    </div>
                </form>
            </div>
        <!-- روابط تبديل الطرق -->
         <div class="mt-4">
            <button
                x-show="authMethod === 'app'"
                @click="authMethod = 'recovery'"
                type="button"
                class="w-full text-secondary-foreground font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg"
            >
                {{ __('login.2fa_use_recovery_code') }}
            </button>
            <button
                x-show="authMethod === 'recovery'"
                @click="authMethod = 'app'"
                type="button"
                class="w-full text-secondary-foreground font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg"
                style="display: none;"
            >
                {{ __('login.2fa_use_app_code') }}
            </button>
        </div>
        </div>


    </div>
</section>
