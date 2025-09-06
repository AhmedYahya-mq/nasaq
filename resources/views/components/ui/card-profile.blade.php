  <div class="card flex flex-col">
      <div x-data="photoProfile"
        x-ref="progres"
          class="p-1 relative bg-background transition-all border border-muted size-[120px] aspect-square mx-auto mt-5 rounded-full grid place-items-center"
          style="background: conic-gradient(
                        var(--primary) 0% 0%,
                        var(--background) 0% 100%
                    );">
          <img data-photo-profile src="{{ auth()->user()->profile_photo_url }}" width="120" height="120"
              class="size-full rounded-full" alt="{{ auth()->user()->name }}">
          <label for="photo" aria-label="Change Profile Picture"
              class="absolute cursor-pointer bottom-1 -right-1  bg-card active:scale-90 transition-transform e p-2 rounded-full dark:shadow-[0_0px_15px_rgba(255,255,255,0.15)]
                                shadow-[0_0px_15px_rgba(0,0,0,0.30)]">
              <x-ui.icon name="camera" class="size-5" />
              <input type="file" id="photo" @change="updateFile($event)" style="display: none;" accept="image/*">
          </label>
          <div class="absolute inset-0 rounded-full bg-background/35"  x-show="loading" x-cloak>
                <div class="w-full h-full flex items-center justify-center"
                    role="status">
                    <span class="text-sm text-foreground font-semibold" x-text="percent"></span>
                </div>
          </div>
      </div>
      <div class="text-center mt-3 mb-5 px-4">
          <h2 class="text-lg font-semibold">{{ auth()->user()->name }}</h2>
          <p class="text-sm text-muted-foreground">أخصائي تغذية علاجية</p>
      </div>
  </div>
