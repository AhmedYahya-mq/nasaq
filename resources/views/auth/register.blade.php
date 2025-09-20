<x-layouts.auth title="إنشاء حساب">
    @props([
        'title' => __('register.title'),
        'subtitle' => __('register.subtitle'),
        'actionUrl' => '#',
    ])

    <section class="min-h-screen  flex items-center justify-center p-4 sm:p-6">
        <div class="container mx-auto">
            <div
                class="flex flex-col lg:flex-row w-full max-w-6xl mx-auto bg-card rounded-2xl shadow-2xl overflow-hidden animate-card-enter border border-border/20">
                <div class="w-full lg:w-1/2 p-8 sm:p-12 bg-primary/20 flex flex-col justify-center">
                    <div class="text-center  mb-8 animate-fade-in-down">
                        <h2 class="text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-primary">
                            {{ $title }}</h2>
                        <p class="text-lg text-muted-foreground mt-2">{{ $subtitle }}</p>
                    </div>

                    <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="animate-fade-in-down" style="animation-delay: 200ms;">
                                <x-forms.input type="text" name="name" id="name" value="{{ old('name') }}"
                                    :label="__('register.full_name')" :placeholder="__('register.full_name_placeholder')" icon="user" required />
                                @error('name')
                                    <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="animate-fade-in-down" style="animation-delay: 300ms;">
                                <x-forms.datepicker name="birthday" id="birthday" value="{{ old('barthday') }}"
                                    :label="__('register.date_of_birth')" :placeholder="__('register.date_of_birth')" />
                                @error('birthday')
                                    <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="animate-fade-in-down" style="animation-delay: 400ms;">
                            <x-forms.input type="email" name="email" id="email" value="{{ old('email') }}"
                                :label="__('register.email')" :placeholder="__('register.email_placeholder')" icon="mail" required />
                            @error('email')
                                <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="animate-fade-in-down" style="animation-delay: 500ms;">
                            <x-forms.tel-input name="phone" id="phone" value="{{ old('phone') }}"
                                :label="__('register.phone_number')" required />
                            @error('phone')
                                <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in-down"
                            style="animation-delay: 600ms;">
                            <div>
                                <x-forms.input-password name="password" id="password" :label="__('register.password')"
                                    :placeholder="__('register.password_placeholder')" required />
                                @error('password')
                                    <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                                @enderror
                            </div>
                            <x-forms.input-password name="password_confirmation" id="password_confirmation"
                                :label="__('register.confirm_password')" :placeholder="__('register.password_placeholder')" required />
                        </div>

                        <div class="animate-fade-in-down" style="animation-delay: 700ms;">
                            <button type="submit"
                                class="w-full text-white font-bold py-3 px-6 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary/80 transition-all duration-300 transform hover:scale-105 active:scale-100 bg-gradient-to-r from-primary to-primary/80 hover:shadow-primary/30">
                                {{ __('register.create_button') }}
                            </button>
                        </div>

                        <p class="text-center text-sm text-muted-foreground pt-4 animate-fade-in-down"
                            style="animation-delay: 800ms;">
                            {{ __('register.login_prompt') }}
                            <a href="{{ route('login') }}"
                                class="font-semibold text-primary hover:text-primary/80 transition-colors">{{ __('register.login_link') }}</a>
                        </p>
                    </form>
                </div>
                <div class="hidden lg:flex w-1/2 items-center justify-center p-12   to-background bg-primary/10 ">
                    <img src="{{ asset('images/register.svg') }}" alt="Register Illustration"
                        class="w-full max-w-md animate-image-float">
                </div>
            </div>
        </div>
    </section>

</x-layouts.auth>
