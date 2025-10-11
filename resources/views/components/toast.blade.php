

@if (session('success') || session('info') || session('error'))
    <div id="toast-container" class="flex flex-col gap-4 items-center" >
        <div class="card border !p-2"
            style="border-color: {{ session('success') ? '#22c55e' : (session('info') ? '#3b82f6' : '#ef4444') }};"
        >
            <div id="toast-message" class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div id="toast-icon" class="toast-icon">
                        @if (session('success'))
                            <x-ui.icon name="check-circle" class="size-5 fill-green-500" />
                        @elseif (session('info'))
                            <x-ui.icon name="info-circle" class="size-5 text-blue-500" />
                        @elseif (session('error'))
                            <x-ui.icon name="error-circle" class="size-5 text-red-500" />
                        @endif
                    </div>
                    <div id="toast-text" class="toast-text">
                        {{ session('success') ?? session('info') ?? session('error') }}
                    </div>
                </div>
                <button id="toast-close" class="size-6 cursor-pointer"
                    onclick="this.parentElement.parentElement.parentElement.remove()">
                    &times;
                </button>
            </div>
        </div>
    </div>
    <script>
       document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const toast = document.getElementById('toast-container');
                if (toast) {
                    toast.remove();
                }
            }, 5000);
        });
    </script>
@endif
