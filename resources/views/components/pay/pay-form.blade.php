<div class="min-h-screen p-4" x-data="payForm" x-init="errors = {{ json_encode($errors->toArray()) }};
init()" x-cloak>
    @push('scripts')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(['resources/js/pages/pay.js'])
    @endpush
    <div class="h-full grid grid-cols-1 md:grid-cols-2 gap-5 card">
        <div
            class="w-full rounded-lg bg-primary/20 px-4 py-3 overflow-hidden shadow-lg flex flex-col justify-center items-center gap-1 md:hidden">
            <div class="size-10 aspect-square">
                <img class="w-full" src="{{ asset('favicon.ico') }}" alt="{{ __('payments.Payment Image') }}">
            </div>
            <h2>
                {{ $item->name ?? ($item->title ?? __('payments.Pay')) }}
            </h2>
        </div>
        <div class="w-full flex flex-col gap-6 not-md:order-2">
            <div
                class="rounded-lg bg-primary/20 px-4 py-3 overflow-hidden shadow-lg md:flex flex-col justify-center items-center gap-1 hidden">
                <div class="size-10 aspect-square">
                    <img class="w-full" src="{{ asset('favicon.ico') }}" alt="{{ __('payments.Payment Image') }}">
                </div>
                <h2>
                    {{ $item->name ?? ($item->title ?? __('payments.Pay')) }}
                </h2>
            </div>
            <div class="w-full border bg-card/50 p-6 rounded-lg shadow-lg">
                @if ($isMembership)
                    <h2>
                        {{ $item->name }} - {{ __('payments.Annual') }}
                    </h2>
                    <strong class="text-lg block mb-4 ">
                        {{ __('payments.Price') }}:
                        {{ $item->regular_price }} <x-ui.icon name="riyal" class="inline size-5" />
                    </strong>
                    <div class="flex flex-col ">
                        <span>
                            {{ __('payments.Starts At') }}: {{ now()->format('Y-m-d h:i A') }}
                        </span>
                        <span class="text-destructive">
                            {{ __('payments.Ends At') }}: {{ now()->addYear()->format('Y-m-d h:i A') }}
                        </span>
                    </div>
                @else
                    <h2>
                        {{ $item->title }}
                    </h2>
                    <p>
                        {{ $item->description }}
                    </p>
                    <strong class="text-lg block">
                        {{ __('payments.Price') }}:
                        {{ $item->final_price }} <x-ui.icon name="riyal" class="inline size-5" />
                    </strong>
                @endif
            </div>
            <div class="w-full flex flex-col border bg-card/50 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-muted-foreground">
                        {{ __('payments.Base Price') }}:
                    </span>
                    <span class="font-semibold text-muted-foreground text-lg">
                        {{ $item->price }} <x-ui.icon name="riyal" class="inline size-5" />
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-muted-foreground">
                        {{ __('payments.Discount') }}:
                    </span>
                    <span class="font-semibold text-muted-foreground text-lg">
                        {{ $item->discounted_price ? $item->price - $item->discounted_price : 0 }}
                        <x-ui.icon name="riyal" class="inline size-5" />
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-muted-foreground">
                        {{ __('payments.Membership Discount') }}:
                    </span>
                    <span class="font-semibold text-muted-foreground text-lg">
                        {{ $item->membership_discount }}
                        <x-ui.icon name="riyal" class="inline size-5" />
                    </span>
                </div>
            </div>
            <div class="w-full flex flex-col border bg-card/50 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-muted-foreground">
                        {{ __('payments.Total Amount') }}:
                    </span>
                    <span class="font-semibold text-muted-foreground text-lg">
                        {{ $item->regular_price ?? $item->final_price }} <x-ui.icon name="riyal" class="inline size-5" />
                    </span>
                </div>
            </div>
        </div>
        <div class="w-full flex flex-col gap-6 @container not-md:order-3">
            <div>
                <div>
                    {{ __('payments.Payment Method') }}
                </div>
                <div class="grid grid-cols-1 @sm:grid-cols-2 gap-4 mt-3">
                    <div @click="paymentMethod = 'card'" class="cursor-pointer">
                        <div :class="{ 'border-primary': paymentMethod === 'card' }"
                            class="border p-4 rounded-lg w-full flex flex-col justify-center items-center gap-2">
                            <x-ui.icon name="credit-card" class="size-5" />
                            <span>{{ __('payments.Credit Card') }}</span>
                        </div>
                    </div>
                    <div @click="paymentMethod = 'stc'" class="cursor-pointer">
                        <div class="border p-4 rounded-lg w-full flex flex-col justify-center items-center gap-2"
                            :class="{ 'border-primary': paymentMethod === 'stc' }">
                            <x-ui.icon name="phone" class="size-5" />
                            <span>{{ __('payments.STC Pay') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div x-text="errors.form" x-show="errors.form"
                class="text-sm text-destructive bg-destructive/10 border border-destructive rounded-lg p-3">
            </div>
            {{-- success laravel with --}}
            @session('success')
                <div class="text-sm text-success bg-success/10 border border-success rounded-lg p-3">
                    {{ $value }}
                </div>
            @endsession

            <div>
                <div>
                    {{ __('payments.Payment Details') }}
                </div>
                <div class="flex flex-col gap-4 mt-2">
                    <form x-show="paymentMethod === 'card'" @submit.prevent="submitCard" action="#" method="post"
                        class="flex flex-col gap-4">
                        <div>
                            <label for="cc-number"
                                class="font-medium required-label">{{ __('payments.Card Details') }}</label>
                            <div dir="ltr" class="relative grid grid-cols-2 gap-y-[1px]">
                                <input aria-label="{{ __('payments.Credit Card') }}" autocomplete="cc-number"
                                    inputmode="numeric" error="error.unsupported_cc_type" dir="ltr" id="cc-number"
                                    x-model="card.number" @input="onCardNumberInput($event)" name="cc-number"
                                    @focus="card.touched.number = true" type="text"
                                    :class="{
                                        '!border-destructive focus:!border-destructive focus:!ring-destructive': errors
                                            .number && card.touched.number
                                    }"
                                    placeholder="1234 5678 9101 1121"
                                    class="relative block w-full rounded-lg border-0 px-4 py-2 text-sm  placeholder-muted-foreground shadow dark:border-1 !border-b-0 focus:z-[2] light:focus:shadow-xl focus:outline-none col-span-full rounded-b-none z-[1] *:focus:!border-primary focus:border-primary focus:ring-1 focus:ring-primary sm:text-sm sm:leading-6">
                                <div class="absolute right-2 top-1/4 z-[2] flex -translate-y-1/2 items-center gap-1">
                                    <img alt="MADA" x-show="card.type === 'mada' || card.type === ''"
                                        src="data:image/svg+xml,%3c?xml%20version='1.0'%20encoding='UTF-8'%20standalone='no'?%3e%3c!DOCTYPE%20svg%20PUBLIC%20'-//W3C//DTD%20SVG%201.1//EN'%20'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'%3e%3csvg%20width='100%25'%20height='100%25'%20viewBox='0%200%2096%2064'%20version='1.1'%20xmlns='http://www.w3.org/2000/svg'%20xmlns:xlink='http://www.w3.org/1999/xlink'%20xml:space='preserve'%20xmlns:serif='http://www.serif.com/'%20style='fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;'%3e%3cpath%20d='M95,6.894c0,-3.253%20-2.641,-5.894%20-5.894,-5.894l-82.212,0c-3.253,0%20-5.894,2.641%20-5.894,5.894l0,50.212c0,3.253%202.641,5.894%205.894,5.894l82.212,0c3.253,0%205.894,-2.641%205.894,-5.894l0,-50.212Z'%20style='fill:%23fff;stroke:%237e7e7e;stroke-width:0.5px;'/%3e%3cg%3e%3crect%20x='5.311'%20y='34.182'%20width='36.116'%20height='12.031'%20style='fill:%2384b740;'/%3e%3crect%20x='5.311'%20y='17.765'%20width='36.116'%20height='12.042'%20style='fill:%23259bd6;'/%3e%3cpath%20d='M77.542,43.769l-0.161,0.032c-0.557,0.107%20-0.761,0.15%20-1.168,0.15c-0.944,-0%20-2.059,-0.483%20-2.059,-2.756c-0,-1.169%200.193,-2.724%201.951,-2.724l0.011,0c0.3,0.022%200.644,0.054%201.287,0.247l0.139,0.043l0,5.008Zm0.29,-11.335l-0.29,0.054l0,4.203l-0.257,-0.075l-0.075,-0.021c-0.29,-0.086%20-0.954,-0.279%20-1.598,-0.279c-3.517,0%20-4.257,2.659%20-4.257,4.89c0,3.056%201.716,4.815%204.708,4.815c1.265,-0%202.198,-0.129%203.141,-0.44c0.869,-0.279%201.18,-0.676%201.18,-1.523l-0,-12.063c-0.836,0.15%20-1.705,0.3%20-2.552,0.439'%20style='fill:%2327292d;fill-rule:nonzero;'/%3e%3cpath%20d='M87.997,43.844l-0.15,0.043l-0.536,0.139c-0.504,0.129%20-0.954,0.204%20-1.297,0.204c-0.826,-0%20-1.319,-0.408%20-1.319,-1.105c-0,-0.45%200.203,-1.211%201.555,-1.211l1.747,-0l0,1.93Zm-1.233,-7.582c-1.083,0%20-2.198,0.193%20-3.581,0.622l-0.901,0.268l0.3,2.038l0.88,-0.29c0.922,-0.3%202.069,-0.493%202.927,-0.493c0.386,0%201.566,0%201.566,1.276l-0,0.558l-1.641,-0c-2.992,-0%20-4.375,0.954%20-4.375,3.002c-0,1.748%201.276,2.799%203.421,2.799c0.664,-0%201.587,-0.129%202.38,-0.322l0.043,-0.01l0.043,0.01l0.268,0.043c0.836,0.15%201.705,0.3%202.552,0.461l0,-6.691c0,-2.166%20-1.308,-3.271%20-3.882,-3.271'%20style='fill:%2327292d;fill-rule:nonzero;'/%3e%3cpath%20d='M67.162,43.844l-0.15,0.043l-0.536,0.139c-0.504,0.129%20-0.944,0.204%20-1.297,0.204c-0.826,-0%20-1.319,-0.408%20-1.319,-1.105c-0,-0.45%200.203,-1.211%201.544,-1.211l1.748,-0l0.01,1.93Zm-1.222,-7.582c-1.094,0%20-2.198,0.193%20-3.582,0.622l-0.9,0.268l0.3,2.038l0.879,-0.29c0.922,-0.3%202.07,-0.493%202.928,-0.493c0.386,0%201.565,0%201.565,1.276l0,0.558l-1.641,-0c-2.991,-0%20-4.385,0.954%20-4.385,3.002c-0,1.748%201.276,2.799%203.431,2.799c0.665,-0%201.587,-0.129%202.381,-0.322l0.043,-0.01l0.042,0.01l0.258,0.043c0.847,0.15%201.705,0.3%202.552,0.472l-0,-6.691c0.011,-2.188%20-1.298,-3.282%20-3.871,-3.282'%20style='fill:%2327292d;fill-rule:nonzero;'/%3e%3cpath%20d='M55.871,36.284c-1.362,-0%20-2.488,0.45%20-2.906,0.643l-0.107,0.054l-0.097,-0.075c-0.579,-0.418%20-1.426,-0.633%20-2.606,-0.633c-1.04,0%20-2.016,0.15%20-3.077,0.461c-0.912,0.279%20-1.266,0.719%20-1.266,1.544l0,7.646l2.853,0l-0,-7.067l0.139,-0.042c0.579,-0.193%200.922,-0.226%201.255,-0.226c0.826,0%201.244,0.44%201.244,1.298l-0,6.048l2.809,-0l0,-6.166c0,-0.365%20-0.075,-0.579%20-0.086,-0.622l-0.096,-0.182l0.193,-0.086c0.429,-0.193%200.901,-0.29%201.394,-0.29c0.568,0%201.244,0.226%201.244,1.298l-0,6.048l2.799,-0l-0,-6.327c-0,-2.241%20-1.201,-3.324%20-3.689,-3.324'%20style='fill:%2327292d;fill-rule:nonzero;'/%3e%3cpath%20d='M85.896,25.614c-0.419,0%20-1.116,-0.043%20-1.662,-0.15l-0.161,-0.032l-0,-4.128c-0,-0.344%20-0.065,-0.558%20-0.075,-0.59l-0.086,-0.172l0.182,-0.075c0.043,-0.021%200.086,-0.032%200.14,-0.053l0.032,-0.022c0.064,-0.021%200.128,-0.043%200.193,-0.064c0.032,-0.011%200.053,-0.022%200.075,-0.022c0.633,-0.171%201.212,-0.15%201.469,-0.171l0.011,-0c1.748,-0%201.951,1.555%201.951,2.723c-0.01,2.274%20-1.136,2.756%20-2.069,2.756m-0.011,-7.849l-0.075,-0c-1.641,-0%20-3.324,0.45%20-3.925,1.33c-0.321,0.429%20-0.504,0.965%20-0.514,1.597l-0,4.258c-0,0.364%20-0.076,0.504%20-0.086,0.536l-0.097,0.182l-5.179,-0l-0,-2.96l-0.011,0c-0.064,-3.12%20-1.909,-4.836%20-4.579,-4.836l-2.605,0c-0.108,0.762%20-0.193,1.298%20-0.301,2.059l2.595,0c1.362,0%202.081,1.158%202.081,2.938l-0,2.981l-0.183,-0.096c-0.032,-0.011%20-0.257,-0.086%20-0.611,-0.086l-4.482,-0c-0.086,0.568%20-0.193,1.308%20-0.311,2.048l13.779,0c0.472,-0.096%201.019,-0.182%201.491,-0.257c0.697,0.343%201.994,0.525%202.884,0.525c2.992,0%204.933,-2.005%204.933,-5.093c-0.011,-3.056%20-1.887,-5.062%20-4.804,-5.126'%20style='fill:%2327292d;fill-rule:nonzero;'/%3e%3cpath%20d='M57.78,28.971l4.074,-0c2.992,-0%204.386,-0.987%204.386,-3.421c0,-1.748%20-1.276,-3.142%20-3.421,-3.142l-2.755,0c-0.826,0%20-1.319,-0.472%20-1.319,-1.265c-0,-0.536%200.203,-1.201%201.554,-1.201l6.027,-0c0.129,-0.783%200.193,-1.276%200.311,-2.059l-6.262,-0c-2.917,-0%20-4.386,1.222%20-4.386,3.26c-0,2.016%201.276,3.067%203.42,3.067l2.756,-0c0.826,-0%201.319,0.654%201.319,1.34c0,0.45%20-0.203,1.383%20-1.544,1.383l-0.461,0l-8.825,-0.021l-1.609,-0c-1.361,-0%20-2.316,-0.772%20-2.316,-2.563l0,-1.233c0,-1.866%200.74,-3.024%202.316,-3.024l2.617,-0c0.118,-0.794%200.193,-1.298%200.3,-2.048l-3.571,-0c-2.67,-0%20-4.514,1.791%20-4.579,4.911l0,1.394c0.065,3.12%201.909,4.611%204.579,4.611l2.606,-0l4.783,0.011Z'%20style='fill:%2327292d;fill-rule:nonzero;'/%3e%3c/g%3e%3c/svg%3e"
                                        loading="lazy" class="h-4 sm:h-5 w-auto object-contain object-center">
                                    <img alt="Visa" x-show="card.type === 'visa' || card.type === ''"
                                        src="data:image/svg+xml,%3c?xml%20version='1.0'%20encoding='UTF-8'%20standalone='no'?%3e%3c!DOCTYPE%20svg%20PUBLIC%20'-//W3C//DTD%20SVG%201.1//EN'%20'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'%3e%3csvg%20width='100%25'%20height='100%25'%20viewBox='0%200%2096%2064'%20version='1.1'%20xmlns='http://www.w3.org/2000/svg'%20xmlns:xlink='http://www.w3.org/1999/xlink'%20xml:space='preserve'%20xmlns:serif='http://www.serif.com/'%20style='fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;'%3e%3cpath%20d='M95,6.894c0,-3.253%20-2.641,-5.894%20-5.894,-5.894l-82.212,0c-3.253,0%20-5.894,2.641%20-5.894,5.894l0,50.212c0,3.253%202.641,5.894%205.894,5.894l82.212,0c3.253,0%205.894,-2.641%205.894,-5.894l0,-50.212Z'%20style='fill:%23fff;stroke:%237e7e7e;stroke-width:0.5px;'/%3e%3cclipPath%20id='_clip1'%3e%3crect%20x='7.179'%20y='18.832'%20width='81.642'%20height='26.336'/%3e%3c/clipPath%3e%3cg%20clip-path='url(%23_clip1)'%3e%3cg%3e%3cpath%20d='M47.418,19.387l-5.431,25.384l-6.567,0l5.432,-25.384l6.566,0Zm27.627,16.39l3.457,-9.532l1.989,9.532l-5.446,0Zm7.326,8.994l6.074,0l-5.3,-25.384l-5.607,0c-1.259,0%20-2.323,0.733%20-2.795,1.863l-9.852,23.521l6.895,0l1.37,-3.79l8.424,-0l0.791,3.79Zm-17.137,-8.287c0.028,-6.701%20-9.267,-7.069%20-9.201,-10.062c0.019,-0.912%200.887,-1.879%202.784,-2.127c0.943,-0.123%203.534,-0.218%206.476,1.136l1.152,-5.383c-1.58,-0.574%20-3.614,-1.125%20-6.143,-1.125c-6.49,-0%20-11.059,3.451%20-11.097,8.391c-0.041,3.655%203.261,5.693%205.75,6.908c2.557,1.245%203.417,2.041%203.406,3.154c-0.017,1.704%20-2.041,2.455%20-3.929,2.485c-3.302,0.052%20-5.218,-0.892%20-6.745,-1.603l-1.19,5.562c1.534,0.705%204.365,1.317%207.303,1.348c6.898,0%2011.411,-3.408%2011.434,-8.684Zm-27.2,-17.097l-10.639,25.384l-6.942,0l-5.235,-20.258c-0.318,-1.248%20-0.595,-1.705%20-1.562,-2.23c-1.576,-0.857%20-4.183,-1.66%20-6.477,-2.158l0.157,-0.738l11.173,0c1.423,0%202.705,0.948%203.028,2.588l2.765,14.69l6.833,-17.278l6.899,0Z'%20style='fill:%230d357f;fill-rule:nonzero;'/%3e%3c/g%3e%3c/g%3e%3c/svg%3e"
                                        loading="lazy" class="h-4 sm:h-5 w-auto object-contain object-center">
                                    <img alt="MasterCard" x-show="card.type === 'mastercard' || card.type === ''"
                                        src="data:image/svg+xml,%3c?xml%20version='1.0'%20encoding='UTF-8'%20standalone='no'?%3e%3c!DOCTYPE%20svg%20PUBLIC%20'-//W3C//DTD%20SVG%201.1//EN'%20'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'%3e%3csvg%20width='100%25'%20height='100%25'%20viewBox='0%200%2096%2064'%20version='1.1'%20xmlns='http://www.w3.org/2000/svg'%20xmlns:xlink='http://www.w3.org/1999/xlink'%20xml:space='preserve'%20xmlns:serif='http://www.serif.com/'%20style='fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;'%3e%3cpath%20d='M95,7.094c0,-3.363%20-2.731,-6.094%20-6.094,-6.094l-81.812,0c-3.363,0%20-6.094,2.731%20-6.094,6.094l-0,49.812c-0,3.363%202.731,6.094%206.094,6.094l81.812,0c3.363,0%206.094,-2.731%206.094,-6.094l0,-49.812Z'%20style='fill:%23fff;stroke:%23b1b1b1;stroke-width:0.5px;'/%3e%3cpath%20d='M95,6.894c0,-3.253%20-2.641,-5.894%20-5.894,-5.894l-82.212,0c-3.253,0%20-5.894,2.641%20-5.894,5.894l0,50.212c0,3.253%202.641,5.894%205.894,5.894l82.212,0c3.253,0%205.894,-2.641%205.894,-5.894l0,-50.212Z'%20style='fill:%23fff;stroke:%237e7e7e;stroke-width:0.5px;'/%3e%3cg%20opacity='0'%3e%3crect%20x='14.04'%20y='9.539'%20width='67.919'%20height='44.921'%20style='fill:%23fff;'/%3e%3c/g%3e%3crect%20x='39.044'%20y='17.366'%20width='17.917'%20height='29.263'%20style='fill:%23ff5f00;'/%3e%3cpath%20d='M40.89,32c-0.005,-5.706%202.619,-11.106%207.107,-14.629c-3.278,-2.576%20-7.329,-3.978%20-11.498,-3.978c-10.209,0%20-18.61,8.401%20-18.61,18.61c0,10.208%208.401,18.609%2018.61,18.609c4.169,-0%208.22,-1.401%2011.498,-3.978c-4.489,-3.524%20-7.113,-8.927%20-7.107,-14.634Z'%20style='fill:%23eb001b;fill-rule:nonzero;'/%3e%3cpath%20d='M76.33,43.533l0,-0.6l0.259,0l-0,-0.124l-0.615,-0l-0,0.124l0.242,0l0,0.6l0.114,-0Zm1.194,-0l0,-0.724l-0.186,-0l-0.217,0.517l-0.217,-0.517l-0.186,-0l-0,0.724l0.134,-0l0,-0.548l0.202,0.47l0.139,0l0.202,-0.47l0,0.548l0.129,-0Z'%20style='fill:%23f79e1b;fill-rule:nonzero;'/%3e%3cpath%20d='M78.108,32c0,10.209%20-8.4,18.609%20-18.609,18.609c-4.171,-0%20-8.223,-1.402%20-11.502,-3.98c4.487,-3.526%207.111,-8.926%207.111,-14.632c-0,-5.705%20-2.624,-11.106%20-7.111,-14.631c3.279,-2.578%207.331,-3.98%2011.502,-3.98c10.209,-0%2018.609,8.4%2018.609,18.609l0,0.005Z'%20style='fill:%23f79e1b;fill-rule:nonzero;'/%3e%3c/svg%3e"
                                        loading="lazy" class="h-4 sm:h-5 w-auto object-contain object-center">
                                </div>
                                <input aria-label="{{ __('payments.Expiry Date') }}" autocomplete="cc-exp"
                                    inputmode="numeric" maxlength="7" data-maska="** / **" data-maska-eager="true"
                                    error="" dir="ltr" @focus="card.touched.expiry = true"
                                    :class="{
                                        '!border-destructive focus:!border-destructive focus:!ring-destructive': errors
                                            .expiry && card.touched.expiry
                                    }"
                                    x-model="card.expiry" @input="onExpiryInput($event)" id="cc-exp"
                                    name="cc-exp" type="text" placeholder="{{ __('payments.MM / YY') }}"
                                    class="relative block w-full  border-0 px-4 py-2 text-sm placeholder-muted-foreground shadow dark:border-1 focus:z-[2] light:focus:shadow-xl focus:outline-none rounded-none rounded-bl-lg *:focus:!border-primary focus:border-primary focus:ring-1 focus:ring-primary sm:text-sm sm:leading-6">
                                <input aria-label="{{ __('payments.CVC') }}" autocomplete="cc-csc"
                                    inputmode="numeric" maxlength="3" @focus="card.touched.cvc = true"
                                    :class="{
                                        '!border-destructive focus:!border-destructive focus:!ring-destructive': errors
                                            .cvc && card.touched.cvc
                                    }"
                                    x-model="card.cvc" data-maska="***" data-maska-eager="true" error=""
                                    dir="ltr" id="cc-csc" name="cc-csc" type="text"
                                    placeholder="{{ __('payments.CVC') }}" x-model="card.cvc"
                                    class="relative block w-full border-0 px-4 py-2 text-sm  placeholder-muted-foreground shadow dark:border-1 focus:z-[2] focus:shadow=xl focus:outline-none rounded-none rounded-br-lg *:focus:!border-primary focus:border-primary focus:ring-1 focus:ring-primary sm:text-sm sm:leading-6">
                            </div>
                            <div x-show="errors.number" x-text="errors.number"
                                class="text-sm text-destructive mt-1 mb-2"></div>
                            <div x-show="errors.expiry" x-text="errors.expiry"
                                class="text-sm text-destructive mt-1 mb-2"></div>
                            <div x-show="errors.month" x-text="errors.month"
                                class="text-sm text-destructive mt-1 mb-2"></div>
                            <div x-show="errors.year" x-text="errors.year"
                                class="text-sm text-destructive mt-1 mb-2"></div>
                            <div x-show="errors.cvc" x-text="errors.cvc" class="text-sm text-destructive mt-1 mb-2">
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="cc-name"
                                class="font-medium required-label">{{ __('payments.Cardholder Name') }}</label>
                            <input autocomplete="cc-name" dir="ltr" id="cc-name" name="cc-name"
                                type="text" placeholder="{{ __('payments.Name on card') }}" x-model="card.name"
                                @focus="card.touched.name = true"
                                :class="{
                                    '!border-destructive focus:!border-destructive focus:!ring-destructive': errors
                                        .name && card.touched.name
                                }"
                                class="relative block w-full  border-0 px-4 py-2 text-sm placeholder-muted-foreground shadow dark:border-1 focus:z-[2] light:focus:shadow-xl focus:outline-none rounded-lg *:focus:!border-primary focus:border-primary focus:ring-1 focus:ring-primary sm:text-sm sm:leading-6" />
                            <div x-show="errors.name" x-text="errors.name"
                                class="text-sm text-destructive mt-1 mb-2">
                            </div>
                        </div>
                        <button type="submit" :disabled="onProgress"
                            class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 transition mt-1 flex justify-center items-center gap-2">
                            <span>{{ __('payments.Pay') }} {{ $item->regular_price }} <x-ui.icon name="riyal"
                                    class="inline size-5" /></span>
                            <div x-show="onProgress"
                                class="border-2 border-white border-t-transparent animate-spin size-5 rounded-full">
                            </div>
                        </button>
                    </form>
                    {{-- stc pay form --}}
                    <form x-show="paymentMethod === 'stc'" @submit.prevent="submitStc" action="#" method="post"
                        class="flex flex-col gap-4">
                        <div class="flex flex-col gap-1">
                            <template x-if="!stc.otpSent">
                                <div>
                                    <label for="phoneNumber"
                                        class="font-medium required-label">{{ __('payments.Phone Number') }}</label>
                                    <input label="{{ __('payments.Phone Number') }}" inputmode="numeric"
                                        maxlength="12" autocomplete="tel-national" error=""
                                        data-maska="### ### ####" data-maska-eager="true" dir="ltr"
                                        id="stc-mobile" name="stc-mobile" type="text"
                                        placeholder="{{ __('payments.Phone Placeholder') }}"
                                        @focus="stc.touched.phone = true" maxlength="10" minlength="10"
                                        autocomplete="tel" aria-label="{{ __('payments.Phone Number') }}"
                                        x-model="stc.phone"
                                        :class="{
                                            '!border-destructive focus:!border-destructive focus:!ring-destructive': stcError &&
                                                stc.touched.phone
                                        }"
                                        class="w-full text-center border px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                    <div x-show="stcError" x-text="stcError"
                                        class="text-sm text-destructive mt-1 mb-2">
                                    </div>
                                </div>
                            </template>
                            <template x-if="stc.otpSent">
                                <div>
                                    <label for="stc-otp"
                                        class="font-medium required-label">{{ __('payments.OTP Code') }}</label>
                                    <input label="{{ __('payments.OTP Code') }}" inputmode="numeric"
                                        autocomplete="one-time-code" error="" data-maska="### ###"
                                        data-maska-eager="true" dir="ltr" @focus="stc.touched.otp = true"
                                        id="stc-otp" name="stc-otp" type="text"
                                        placeholder="{{ __('payments.OTP Placeholder') }}"
                                        aria-label="{{ __('payments.OTP Code') }}" x-model="stc.otp" maxlength="6"
                                        minlength="6"
                                        :class="{
                                            '!border-destructive focus:!border-destructive focus:!ring-destructive': otpError &&
                                                stc.touched.otp
                                        }"
                                        class="w-full text-center border px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                </div>
                            </template>
                        </div>
                        <button type="submit" :disabled="onProgress"
                            class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 transition mt-1 flex justify-center items-center gap-2">
                            <span x-show="!stc.otpSent">
                                {{ __('payments.Pay') }} {{ $item->regular_price }} <x-ui.icon name="riyal"
                                    class="inline size-5" />
                            </span>
                            <span x-show="stc.otpSent">
                                {{ __('payments.Verify') }}
                            </span>
                            <div x-show="onProgress"
                                class="border-2 border-white border-t-transparent animate-spin size-5 rounded-full">
                            </div>
                        </button>
                        {{-- عداد الوقت --}}
                        <div x-show="stc.otpSent" class="text-center text-sm text-muted-foreground">
                            <span>
                                <span x-text="stc.otpTimer"></span>
                                {{ __('payments.Minute') }}
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
