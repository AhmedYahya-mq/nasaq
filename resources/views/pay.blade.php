<x-layouts.auth title="{{ __('payments.Pay') }}">
    <x-pay.pay-form :item="$item" :intent-token="$intentToken" :is-membership="$isMembership" :start-at="$startAt" :ends-at="$endsAt" />
</x-layouts.auth>
