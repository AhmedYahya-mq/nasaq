<x-layouts.auth>
    @props([
        'actionUrl' => '#',
    ])
    <section x-data="{ linkSent: false }" class="min-h-screen flex-center p-4 sm:p-6">
        <div class="container mx-auto">
            <div class="card w-full max-w-lg mx-auto animate-card-enter border border-border">
                <div class="flex flex-col justify-center">
                    @if (session('status') && session('status') == __(Password::RESET_LINK_SENT))
                        <div>
                            <div class="text-center animate-fade-in-down">
                                <div
                                    class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-500/10">
                                    <x-ui.icon name="check" class="h-8 w-8 text-green-500" />
                                </div>
                                <h2 class="text-2xl font-bold text-foreground">{{ __('login.link_sent_title') }}</h2>
                                <p class="text-muted-foreground mt-2 max-w-md mx-auto">
                                    {{ __('login.link_sent_subtitle') }}
                                </p>
                                <div class="mt-8">
                                    <a href="#"
                                        class="font-semibold text-primary hover:text-primary/80 transition-colors">
                                        {{ __('login.back_to_login_link') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            <div class="text-center mb-8 animate-fade-in-down">
                                <h2 class="text-3xl font-bold text-foreground">{{ __('login.forgot_password_title') }}
                                </h2>
                                <p class="text-muted-foreground mt-2">{{ __('login.forgot_password_subtitle') }}</p>
                            </div>
                            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="animate-fade-in-down">
                                    <x-forms.input type="email" name="email" id="email" :label="__('login.email')"
                                        :placeholder="__('login.email_placeholder')" icon="mail" required />
                                    @error('email')
                                        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="animate-fade-in-down">
                                    {{-- تم تعديل كلاسات الزر لتستخدم متغيراتك --}}
                                    <button type="submit"
                                        class="w-full text-primary-foreground font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring bg-primary transition-all">
                                        {{ __('login.send_reset_link_button') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

</x-layouts.auth>
