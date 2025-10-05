<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public static $wrap = null;
    protected $minimal = false;

    public function __construct($resource, $minimal = false)
    {
        parent::__construct($resource);
        $this->minimal = $minimal;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->minimal) {
            return $this->minimalData();
        }
        return $this->fullData();
    }


    protected function minimalData(){
        return [
            'success' => true,
            'payment_id' => $this->id,
            'moyasar_id' => $this->moyasar_id,
            'status' => $this->status,
            'transaction_url' => $this->transaction_url,
            'message' => $this->message
        ];
    }

    protected function fullData(){
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'moyasar_id' => $this->moyasar_id,
            'payable_id' => $this->payable_id,
            'payable_type' => $this->payable_type,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,
            'source_type' => $this->source_type,
            'company' => $this->company,
            'description' => $this->description,
            'transaction_url' => $this->transaction_url,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
