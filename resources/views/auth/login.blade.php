<x-layouts.auth>
    @props([
        'title' => __('login.title'),
        'subtitle' => __('login.subtitle'),
        'actionUrl' => '#',
    ])

    <section class="h-screen flex items-center justify-center">
        <div class="container mx-auto">
            <div
                class="flex flex-col lg:flex-row w-full max-w-6xl mx-auto bg-card rounded-2xl shadow-2xl overflow-hidden animate-card-enter border border-border/20">
                <div class="w-full lg:w-1/2 p-8 sm:p-12 bg-primary/20 flex flex-col justify-center">
                    <div class="text-center  mb-8 animate-fade-in-down">
                        <h2 class="text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-primary">
                            {{ $title }}</h2>
                        <p class="text-lg text-muted-foreground mt-2">{{ $subtitle }}</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="animate-fade-in-down">
                            <x-forms.input type="email" name="email" id="email" :label="__('login.email')"
                                :placeholder="__('login.email_placeholder')" icon="mail" value="{{ old('email') }}" required />
                            @error('email')
                                <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1  gap-6 ">
                            <x-forms.input-password name="password" id="password" :label="__('login.password')" :placeholder="__('login.password_placeholder')"
                                required />
                        </div>
                        <x-forms.checkbox name="remember" id="remember" :label="__('login.remember_me')" />
                        <div class="grid grid-cols-1  gap-6 ">
                            <a href="{{ route('password.request') }}"
                                class="font-semibold text-primary hover:text-primary/80 transition-colors">{{ __('login.forgit_password') }}</a>
                        </div>

                        <div class="animate-fade-in-down" style="animation-delay: 700ms;">
                            <button type="submit"
                                class="w-full text-white font-bold py-3 px-6 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary/80 cursor-pointer bg-gradient-to-r from-primary to-primary/80 hover:shadow-primary/30">
                                {{ __('login.create_button') }}
                            </button>
                        </div>

                        <p class="text-center text-sm text-muted-foreground pt-4 animate-fade-in-down">
                            {{ __('login.register_prompt') }}
                            <a href="{{ route('register') }}"
                                class="font-semibold text-primary hover:text-primary/80 transition-colors">{{ __('login.register_link') }}</a>
                        </p>
                    </form>
                </div>
                <div class="hidden lg:flex w-1/2 items-center justify-center p-12   to-background bg-primary/10 ">
                    <img src="{{ asset('images/login.svg') }}" alt="Register Illustration"
                        class="w-full max-w-md animate-image-float">
                </div>
            </div>
        </div>
    </section>
</x-layouts.auth>
