<x-layouts.auth title="طلب العضوية">
    @push('scripts')
        @vite(['resources/js/pages/membership-request.js'])
    @endpush
    <x-membership.membership-form :application="$application" />
</x-layouts.auth>
