<?php

namespace App\DTOs\Payment;

use App\Enums\PaymentStatus;

final class PaymentResponseDTO
{
    public ?string $id;
    public PaymentStatus $status;
    public ?string $sourceType;
    public ?string $company;
    public ?string $description;
    public array $raw;
    public ?string $errorMessage = null;

    private function __construct(
        ?string $id,
        PaymentStatus $status,
        ?string $sourceType,
        ?string $company,
        ?string $description,
        array $raw,
        ?string $errorMessage
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->sourceType = $sourceType;
        $this->company = $company;
        $this->description = $description;
        $this->raw = $raw;
        $this->errorMessage = $errorMessage;
    }

    public static function fromGatewayResponse($response): self
    {
        $raw = is_array($response) ? $response : (is_object($response) ? json_decode(json_encode($response), true) : []);
        $root = $raw['data'] ?? $raw;

        $id = $root['id'] ?? null;
        $status = $root['status'] ?? ($raw['status'] ?? 'initiated');
        $source = $root['source'] ?? ($raw['source'] ?? []);
        $sourceType = $source['type'] ?? null;
        $company = $source['company'] ?? null;
        $description = $root['description'] ?? ($raw['description'] ?? null);
        $errorMessage = $raw['error']['message'] ?? $root['error']['message'] ?? null;

        return new self($id, PaymentStatus::tryFrom($status), $sourceType, $company, $description, $raw, $errorMessage);
    }
}
