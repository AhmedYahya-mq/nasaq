<?php

namespace App\DTOs\Payment;

final class PaymentPayloadDTO
{
    public int $amount;
    public string $currency;
    public string $description;
    public string $callbackUrl;
    public array $metadata;
    public array $source;

    private function __construct(
        int $amount,
        string $currency,
        string $description,
        string $callbackUrl,
        array $metadata,
        array $source = []
    ) {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->callbackUrl = $callbackUrl;
        $this->metadata = $metadata;
        $this->source = $source;
    }

    public static function fromBase(
        int $amount,
        string $currency,
        string $description,
        string $callbackUrl,
        array $metadata
    ): self {
        return new self($amount, $currency, $description, $callbackUrl, $metadata);
    }

    public function withSource(array $source): self
    {
        $clone = clone $this;
        $clone->source = $source;
        return $clone;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'description' => $this->description,
            'callback_url' => $this->callbackUrl,
            'metadata' => $this->metadata,
            'source' => $this->source,
        ];
    }
}
