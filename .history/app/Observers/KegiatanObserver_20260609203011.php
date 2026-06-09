<?php

namespace App\Observers;

use App\Models\Kegiatan;

class KegiatanObserver
{
    /**
     * Handle the Kegiatan "created" event.
     */
    public function created(Kegiatan $kegiatan): void
    {
        //
    }

    /**
     * Handle the Kegiatan "updated" event.
     */
    public function updated(Kegiatan $kegiatan): void
    {
        //
    }

    /**
     * Handle the Kegiatan "deleted" event.
     */
    public function deleted(Kegiatan $kegiatan): void
    {
        //
    }

    /**
     * Handle the Kegiatan "restored" event.
     */
    public function restored(Kegiatan $kegiatan): void
    {
        //
    }

    /**
     * Handle the Kegiatan "force deleted" event.
     */
    public function forceDeleted(Kegiatan $kegiatan): void
    {
        //
    }
}
