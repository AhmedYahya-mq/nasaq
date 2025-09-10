<label x-data="{ open: false }" class="relative lg:hidden cursor-pointer flex items-center justify-center">
    <input data-button-toggle-menu type="checkbox" class="peer hidden" />

    <svg viewBox="0 0 32 32" class="h-8 transition-transform duration-600 ease-in-out peer-checked:rotate-[-45deg]">
        <!-- Top & Bottom Line -->
        <path
            d="M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22"
            class="stroke-primary"
            style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:3;
             transition:stroke-dasharray 600ms cubic-bezier(0.4,0,0.2,1),
                        stroke-dashoffset 600ms cubic-bezier(0.4,0,0.2,1);
             stroke-dasharray:12 63;">
        </path>

        <!-- Middle Line -->
        <path d="M7 16 27 16" class="stroke-primary"
            style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:3;
             transition:stroke-dasharray 600ms cubic-bezier(0.4,0,0.2,1),
                        stroke-dashoffset 600ms cubic-bezier(0.4,0,0.2,1);">
        </path>
    </svg>
</label>
