<?php

namespace App\Http\Controllers;

use App\Models\KalenderProker;
use App\Models\Kegiatan;
use App\Models\Divisi;
use Illuminate\Http\Request;

class KalenderProkerController extends Controller
{
    public function index(Request $request)
    {
        $query = KalenderProker::query()
            ->with(['kegiatan', 'divisi'])
            ->orderBy('tgl_mulai', 'asc');

        if ($request->has('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->boolean('publik_only', false)) {
            $query->where('is_publik', true);
        }

        $kaleders = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'data' => $kaleders->items(),
            'pagination' => [
                'total' => $kaleders->total(),
                'per_page' => $kaleders->perPage(),
                'current_page' => $kaleders->currentPage(),
                'last_page' => $kaleders->lastPage(),
            ]
        ]);
    }

    public function create()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'kegiatans' => Kegiatan::all(),
                'divisis' => Divisi::all(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'divisi_id' => 'nullable|exists:divisis,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
            'warna' => 'nullable|string|max:20',
            'is_publik' => 'boolean',
        ]);

        try {
            $kalender = KalenderProker::create($request->all());
            $kalender->load(['kegiatan', 'divisi']);

            return response()->json([
                'success' => true,
                'message' => 'Kalender proker berhasil dibuat',
                'data' => $kalender
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat kalender proker: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(KalenderProker $kalenderProker)
    {
        $kalenderProker->load(['kegiatan', 'divisi']);

        return response()->json([
            'success' => true,
            'data' => $kalenderProker
        ]);
    }

    public function edit(KalenderProker $kalenderProker)
    {
        $kalenderProker->load(['kegiatan', 'divisi']);

        return response()->json([
            'success' => true,
            'data' => [
                'kalender_proker' => $kalenderProker,
                'kegiatans' => Kegiatan::all(),
                'divisis' => Divisi::all(),
            ]
        ]);
    }

    public function update(Request $request, KalenderProker $kalenderProker)
    {
        $request->validate([
            'kegiatan_id' => 'sometimes|exists:kegiatans,id',
            'divisi_id' => 'nullable|exists:divisis,id',
            'tgl_mulai' => 'sometimes|date',
            'tgl_selesai' => 'nullable|date',
            'warna' => 'nullable|string|max:20',
            'is_publik' => 'boolean',
        ]);

        try {
            $kalenderProker->update($request->all());
            $kalenderProker->load(['kegiatan', 'divisi']);

            return response()->json([
                'success' => true,
                'message' => 'Kalender proker berhasil diperbarui',
                'data' => $kalenderProker
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(KalenderProker $kalenderProker)
    {
        try {
            $kalenderProker->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kalender proker berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCalendarEvents(Request $request)
    {
        $query = KalenderProker::query()
            ->with(['kegiatan', 'divisi']);

        if ($request->has('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        if (!auth()->check()) {
            $query->where('is_publik', true);
        }

        $events = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->kegiatan->nama_kegiatan ?? 'Kegiatan',
                'start' => $item->tgl_mulai,
                'end' => $item->tgl_selesai,
                'color' => $item->warna ?? '#3B82F6',
                'extendedProps' => [
                    'divisi' => $item->divisi->nama_divisi ?? 'DEMA FEBI',
                    'is_publik' => $item->is_publik,
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Event kalender berhasil diambil',
            'data' => $events
        ]);
    }

    public function getEventOptions(KalenderProker $kalenderProker)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $kalenderProker->id,
                'title' => $kalenderProker->kegiatan->nama_kegiatan ?? 'Kegiatan',
                'color' => $kalenderProker->warna ?? '#3B82F6',
            ]
        ]);
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:kalender_prokers,id',
            'status' => 'required|string|in:scheduled,ongoing,completed,cancelled'
        ]);

        try {
            KalenderProker::whereIn('id', $request->ids)
                ->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function markOngoing(KalenderProker $kalenderProker)
    {
        $kalenderProker->update(['status' => 'ongoing']);
        return response()->json(['success' => true, 'message' => 'Event sedang berlangsung']);
    }

    public function markCompleted(KalenderProker $kalenderProker)
    {
        $kalenderProker->update(['status' => 'completed']);
        return response()->json(['success' => true, 'message' => 'Event selesai']);
    }

    public function markCancelled(KalenderProker $kalenderProker)
    {
        $kalenderProker->update(['status' => 'cancelled']);
        return response()->json(['success' => true, 'message' => 'Event dibatalkan']);
    }
}