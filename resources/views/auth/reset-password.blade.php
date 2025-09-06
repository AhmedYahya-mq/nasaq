<x-layouts.auth>
    <section class="min-h-screen flex items-center justify-center p-4 sm:p-6 bg-background">
        <div class="container mx-auto">

            <div
                class="w-full max-w-lg mx-auto bg-card rounded-2xl shadow-lg overflow-hidden animate-card-enter border border-border">

                <div class="p-8 sm:p-12 flex flex-col justify-center">

                    <div class="text-center mb-8 animate-fade-in-down">
                        <h2 class="text-3xl font-bold text-foreground">{{ __('login.reset_password_title') }}</h2>
                        <p class="text-muted-foreground mt-2">{{ __('login.reset_password_subtitle') }}</p>
                    </div>

                    <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        @error('token')
                            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                        @enderror
                        <input type="hidden" name="email" value="{{ $request->email ?? old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                        @enderror
                        {{-- New Password --}}
                        <div class="animate-fade-in-down" style="animation-delay: 100ms;">
                            <x-forms.input-password name="password" id="password" :label="__('login.new_password')" :placeholder="__('login.password_placeholder')"
                                required />
                            @error('password')
                                <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="animate-fade-in-down" style="animation-delay: 200ms;">
                            <x-forms.input-password name="password_confirmation" id="password_confirmation"
                                :label="__('login.confirm_new_password')" :placeholder="__('login.password_placeholder')" required />
                        </div>

                        <div class="animate-fade-in-down" style="animation-delay: 300ms;">
                            <button type="submit"
                                class="w-full  font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary bg-primary transition-all">
                                {{ __('login.update_password_button') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</x-layouts.auth>
