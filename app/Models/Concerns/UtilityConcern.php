<?php

namespace App\Models\Concerns;

use App\Enums\BillInvoiceAddFlagEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait UtilityConcern
{
    protected function tenantAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function ownerAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId1Amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId2Amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId3Amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId4Amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId5Amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    //Tenant Invoice Add Flag
    public function isTenantInvoiceNotReflected(): bool
    {
        return $this->tenant_invoice_add_flag->is(BillInvoiceAddFlagEnum::NOT_REFLECTED);
    }

    public function isTenantInvoiceReflected(): bool
    {
        return $this->tenant_invoice_add_flag->is(BillInvoiceAddFlagEnum::REFLECTED);
    }

    //Owner Invoice Add Flag
    public function isOwnerInvoiceNotReflected(): bool
    {
        return $this->owner_invoice_add_flag->is(BillInvoiceAddFlagEnum::NOT_REFLECTED);
    }

    public function isOwnerInvoiceReflected(): bool
    {
        return $this->owner_invoice_add_flag->is(BillInvoiceAddFlagEnum::REFLECTED);
    }

    public function getAmountFormat($columnCheck, $amount)
    {
        return $columnCheck ? formatCurrency($amount) : '';
    }

    public function getTenantAmount()
    {
        return $this->getAmountFormat($this->tenant_id, $this->tenant_amount);
    }

    public function getOwnerAmount()
    {
        return $this->getAmountFormat($this->owner_id, $this->owner_amount);
    }

    public function isShowDeleteButton()
    {
        $checkTenant = !$this->tenant_id || $this->isTenantInvoiceNotReflected();
        $checkOwner = !$this->owner_id || $this->isOwnerInvoiceNotReflected();
        return $checkTenant && $checkOwner;
    }

    public function isShowEditButton()
    {
        $checkTenant = $this->tenant_id && $this->isTenantInvoiceNotReflected();
        $checkOwner = $this->owner_id && $this->isOwnerInvoiceNotReflected();
        return $checkTenant || $checkOwner;
    }


}
