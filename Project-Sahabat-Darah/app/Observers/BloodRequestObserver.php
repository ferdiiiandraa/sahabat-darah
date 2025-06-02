<?php

namespace App\Observers;

use App\Models\BloodRequest;
use App\Models\Transaction;

class BloodRequestObserver
{
    /**
     * Handle the BloodRequest "created" event.
     */
    public function created(BloodRequest $bloodRequest)
    {
        Transaction::create([
            'blood_request_id' => $bloodRequest->id,
            'patient_name' => $bloodRequest->patient_name,
            'tanggal_transaksi' => $bloodRequest->updated_at,
        ]);
    }

    /**
     * Handle the BloodRequest "updated" event.
     */
    public function updated(BloodRequest $bloodRequest): void
    {
        //
    }

    /**
     * Handle the BloodRequest "deleted" event.
     */
    public function deleted(BloodRequest $bloodRequest): void
    {
        //
    }

    /**
     * Handle the BloodRequest "restored" event.
     */
    public function restored(BloodRequest $bloodRequest): void
    {
        //
    }

    /**
     * Handle the BloodRequest "force deleted" event.
     */
    public function forceDeleted(BloodRequest $bloodRequest): void
    {
        //
    }
}
