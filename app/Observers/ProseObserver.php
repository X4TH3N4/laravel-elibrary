<?php

namespace App\Observers;

use App\Models\Prose;

class ProseObserver
{
    /**
     * Handle the Prose "created" event.
     */
    public function created(Prose $prose): void
    {
        $copy = $prose->copy;

        $prose->name = "{$copy->id} ID'li {$copy->name}'nın Neşiri";
        $prose->save();
    }

    /**
     * Handle the Prose "updated" event.
     */
    public function updated(Prose $prose): void
    {
        //
    }

    /**
     * Handle the Prose "deleted" event.
     */
    public function deleted(Prose $prose): void
    {
        //
    }

    /**
     * Handle the Prose "restored" event.
     */
    public function restored(Prose $prose): void
    {
        //
    }

    /**
     * Handle the Prose "force deleted" event.
     */
    public function forceDeleted(Prose $prose): void
    {
        //
    }
}
