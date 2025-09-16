<section id="goals">
    <div class="relative min-h-auto md:p-20 p-5">
        <h2 class="md:text-center">{{ __('home.goals.title') }}</h2>
        <div class="md:flex justify-center mt-5 w-full not-md:px-4">
            <div class="@container flex">
                <div class="border-primary border h-[calc(150px*5)] relative">

                    <x-ui.leader-line>
                        <div class="w-full h-[140px] bg-card p-5 shadow-md rounded-lg">
                            <h3 class="text-lg font-semibold">
                                {{ __('home.goals.goal1_title') }}
                            </h3>
                            <p class="text-sm text-muted-foreground mt-2">
                                {{ __('home.goals.goal1_desc') }}
                            </p>
                        </div>
                    </x-ui.leader-line>

                    <x-ui.leader-line dirction="left" nath="1">
                        <div class="w-full h-[140px] bg-card p-5 shadow-md rounded-lg">
                            <h3 class="text-lg font-semibold">
                                {{ __('home.goals.goal2_title') }}
                            </h3>
                            <p class="text-sm text-muted-foreground mt-2">
                                {{ __('home.goals.goal2_desc') }}
                            </p>
                        </div>
                    </x-ui.leader-line>

                    <x-ui.leader-line nath="2">
                        <div class="w-full h-[140px] bg-card p-5 shadow-md rounded-lg">
                            <h3 class="text-lg font-semibold">
                                {{ __('home.goals.goal3_title') }}
                            </h3>
                            <p class="text-sm text-muted-foreground mt-2">
                                {{ __('home.goals.goal3_desc') }}
                            </p>
                        </div>
                    </x-ui.leader-line>

                    <x-ui.leader-line dirction="left" nath="3">
                        <div class="w-full h-[140px] bg-card p-5 shadow-md rounded-lg">
                            <h3 class="text-lg font-semibold">
                                {{ __('home.goals.goal4_title') }}
                            </h3>
                            <p class="text-sm text-muted-foreground mt-2">
                                {{ __('home.goals.goal4_desc') }}
                            </p>
                        </div>
                    </x-ui.leader-line>

                    <x-ui.leader-line nath="4">
                        <div class="w-full h-[140px] bg-card p-5 shadow-md rounded-lg">
                            <h3 class="text-lg font-semibold">
                                {{ __('home.goals.goal5_title') }}
                            </h3>
                            <p class="text-sm text-muted-foreground mt-2">
                                {{ __('home.goals.goal5_desc') }}
                            </p>
                        </div>
                    </x-ui.leader-line>

                </div>
            </div>
        </div>
    </div>
</section>
