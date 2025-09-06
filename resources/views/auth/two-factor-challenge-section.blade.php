<x-layouts.auth>
    @push('scripts')
        @vite(['resources/js/pages/twoFactorChallenge.js'])
    @endpush
    <section x-data='twoFactorChallenge({{ $errors->has('recovery_code') ? 'true' : 'false' }})'
        class="min-h-screen flex-center p-4 sm:p-6">
        <div class="w-full max-w-md mx-auto z-10">
            <div class="card animate-card-enter border border-border">
                <div class="">
                    <div
                        class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-lg bg-primary/10 border border-primary/20">
                        <x-ui.icon name="lock-closed" class="h-8 w-8 text-primary" />
                    </div>
                    <div>
                        <template x-if="isCodeView">
                            <div>
                                <h2 class="text-xl font-extrabold text-center text-foreground">
                                    {{ __('login.2fa_title_code') }}</h2>
                                <p class="text-center text-sm text-muted-foreground mt-1">
                                    {{ __('login.2fa_subtitle_code') }}</p>
                            </div>
                        </template>
                        <template x-if="!isCodeView">
                            <div>
                                <h2 class="text-xl font-extrabold text-center text-foreground">
                                    {{ __('login.2fa_title_recovery') }}</h2>
                                <p class="text-center text-sm text-muted-foreground mt-1">
                                    {{ __('login.2fa_subtitle_recovery') }}
                                </p>
                            </div>
                        </template>
                    </div>
                    <div>
                        <div x-show="isCodeView" x-cloak x-ref="code">
                            <x-forms.input type="text" name="code" id="code" value="{{ old('code') }}"
                                :label="__('login.2fa_app_code_label')" x-model="inputValue" :placeholder="__('login.2fa_code_placeholder')" autocomplete="one-time-code"
                                class="text-md text-center" />
                            @error('code')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"
                                    x-text="error || '{{ $message ?? '' }}'">
                                </p>
                            @enderror
                        </div>
                        <div x-show="!isCodeView" x-cloak x-ref="recovery_code">
                            <x-forms.input type="text" name="recovery_code" x-model="inputValue" id="recovery_code"
                                :label="__('login.2fa_recovery_code_label')" :placeholder="__('login.2fa_recovery_placeholder')" class="text-md text-center" />
                            @error('recovery_code')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"
                                    x-text="error || '{{ $message ?? '' }}'">
                                </p>
                            @enderror
                        </div>
                    </div>
                    <form action="{{ route('two-factor.login.store') }}" method="POST" class="mt-8 ">
                        @csrf
                        <input type="hidden" :name="inputName" x-ref="input" />
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full  font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring bg-primary transition-all">
                                {{ __('login.2fa_verify_button') }}
                            </button>
                        </div>
                        <!-- روابط تبديل الطرق -->
                        <div class="mt-4">
                            <button @click="toogle" type="reset"
                                class="text-sm text-primary hover:underline focus:outline-none text-center w-full">
                                <span x-show="!isCodeView" x-cloak>{{ __('login.2fa_use_recovery_code') }}</span>
                                <span x-show="isCodeView" x-cloak>{{ __('login.2fa_use_app_code') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layouts.auth>
