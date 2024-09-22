<?php

namespace App\Observers;

use App\Models\Copy;

class CopyObserver
{
    /**
     * Handle the Copy "created" event.
     */
    public function created(Copy $copy): void
    {
        $copy->name = "{$copy->number} numaralı {$copy->artifact->name} Nüshası";
        $copy->save();
    }

    /**
     * Handle the Copy "updated" event.
     */
    public function updated(Copy $copy): void
    {
        //
    }

    /**
     * Handle the Copy "deleted" event.
     */
    public function deleted(Copy $copy): void
    {
        //
    }

    /**
     * Handle the Copy "restored" event.
     */
    public function restored(Copy $copy): void
    {
        //
    }

    /**
     * Handle the Copy "force deleted" event.
     */
    public function forceDeleted(Copy $copy): void
    {
        //
    }
}
