  <div class="card flex flex-col">
      <div
          class="p-1 relative bg-background border border-muted size-[120px] aspect-square mx-auto mt-5 rounded-full grid place-items-center">
          <img src="{{ asset('images/avatar-1.jpg') }}" width="120" height="120" class="size-full rounded-full"
              alt="Profile Background">
          <button aria-label="Change Profile Picture"
              class="absolute cursor-pointer bottom-1 -right-1  bg-card active:scale-90 transition-transform e p-2 rounded-full dark:shadow-[0_0px_15px_rgba(255,255,255,0.15)]
                                shadow-[0_0px_15px_rgba(0,0,0,0.30)]">
              <x-ui.icon name="camera" class="size-5" />
          </button>
      </div>
      <div class="text-center mt-3 mb-5 px-4">
          <h2 class="text-lg font-semibold">أحمد محمد</h2>
          <p class="text-sm text-muted-foreground">أخصائي تغذية علاجية</p>
      </div>
  </div>
