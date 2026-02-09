<x-layouts.guest-layout title="{{ __('payments.Pay') }}">
    <x-pay.pay-form :item="$item" :intent-token="$intentToken" :is-membership="$isMembership" :membership-action="$membershipAction" :start-at="$startAt" :ends-at="$endsAt" />
</x-layouts.guest-layout>
