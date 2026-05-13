<?php

namespace App\Repositories\Api;

use App\Models\InvoiceItem;
use App\Repositories\CustomRepository;

class InvoiceItemRepository extends CustomRepository
{
    protected $model = InvoiceItem::class;

    public function getListForSearch($dataSearch = [])
    {
        $invoiceId = data_get($dataSearch, 'invoice_id');
        $itemType = data_get($dataSearch, 'item_type');
        $itemName = data_get($dataSearch, 'item_name');
        $amount = data_get($dataSearch, 'amount');
        $debtId = data_get($dataSearch, 'debt_id');
        $roomSidePaidId = data_get($dataSearch, 'room_side_paid_id');
        $note = data_get($dataSearch, 'note');

        $q = $this->select(['*'])
            ->when($invoiceId, function ($query) use ($invoiceId) {
                $query->where($this->modelField('invoice_id'), $invoiceId);
            })
            ->when($itemType !== null && $itemType !== '', function ($query) use ($itemType) {
                $query->where($this->modelField('item_type'), $itemType);
            })
            ->when($itemName, function ($query) use ($itemName) {
                $query->whereLike($this->modelField('item_name'), $itemName);
            })
            ->when($amount !== null && $amount !== '', function ($query) use ($amount) {
                $query->where($this->modelField('amount'), $amount);
            })
            ->when($debtId, function ($query) use ($debtId) {
                $query->where($this->modelField('debt_id'), $debtId);
            })
            ->when($roomSidePaidId, function ($query) use ($roomSidePaidId) {
                $query->where($this->modelField('room_side_paid_id'), $roomSidePaidId);
            })
            ->when($note, function ($query) use ($note) {
                $query->whereLike($this->modelField('note'), $note);
            });

        return $q->paginate(getConstant('PER_PAGE_DEFAULT'));
    }
}
