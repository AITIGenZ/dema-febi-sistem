<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KalenderProkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kegiatan' => [
                'id' => $this->kegiatan?->id,
                'nama' => $this->kegiatan?->nama_kegiatan,
                'deskripsi' => $this->kegiatan?->deskripsi,
            ],
            'divisi' => [
                'id' => $this->divisi?->id,
                'nama' => $this->divisi?->nama_divisi,
            ],
            'tgl_mulai' => $this->tgl_mulai?->format('Y-m-d'),
            'tgl_mulai_formatted' => $this->tgl_mulai?->format('d M Y'),
            'tgl_selesai' => $this->tgl_selesai?->format('Y-m-d'),
            'tgl_selesai_formatted' => $this->tgl_selesai?->format('d M Y'),
            'warna' => $this->warna,
            'is_publik' => (bool) $this->is_publik,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),
            'reminder_at' => $this->reminder_at?->format('Y-m-d H:i:s'),
            'created_by' => [
                'id' => $this->creator?->id,
                'name' => $this->creator?->name,
            ],
            'updated_by' => [
                'id' => $this->updater?->id,
                'name' => $this->updater?->name,
            ],
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'duration_days' => $this->getDurationInDays(),
            'is_ongoing' => $this->isOngoing(),
            'is_finished' => $this->isFinished(),
            'is_upcoming' => !$this->isOngoing() && !$this->isFinished(),
            'event_options' => $this->getEventOptions(),
        ];
    }
}
