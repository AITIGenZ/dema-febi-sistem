<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * List semua notifikasi untuk user yang login
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'data' => $notifications->items(),
            'pagination' => [
                'total' => $notifications->total(),
                'per_page' => $notifications->perPage(),
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
            ],
        ]);
    }

    /**
     * Daftar notifikasi yang belum dibaca
     */
    public function unread(): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $unreadNotifications = $user->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $unreadCount = $user->unreadNotifications()->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $unreadNotifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => class_basename($notification->type),
                    'data' => $notification->data,
                    'created_at' => $notification->created_at,
                    'time_ago' => $notification->created_at->diffForHumans(),
                ];
            }),
        ]);
    }

    /**
     * Tandai notifikasi sebagai dibaca
     */
    public function markAsRead(string $id): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notification = $user->notifications()->find($id);

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'message' => 'Notifikasi berhasil ditandai sebagai dibaca',
            'notification' => [
                'id' => $notification->id,
                'data' => $notification->data,
                'read_at' => $notification->read_at,
            ],
        ]);
    }

    /**
     * Tandai semua notifikasi sebagai dibaca
     */
    public function markAllAsRead(): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $count = $user->unreadNotifications()->update(['read_at' => now()]);

        return response()->json([
            'message' => 'Semua notifikasi berhasil ditandai sebagai dibaca',
            'updated_count' => $count,
        ]);
    }

    /**
     * Hapus notifikasi
     */
    public function destroy(string $id): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notification = $user->notifications()->find($id);

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        $notification->delete();

        return response()->json([
            'message' => 'Notifikasi berhasil dihapus',
        ]);
    }

    /**
     * Hapus semua notifikasi
     */
    public function deleteAll(): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $count = $user->notifications()->delete();

        return response()->json([
            'message' => 'Semua notifikasi berhasil dihapus',
            'deleted_count' => $count,
        ]);
    }

    /**
     * Hitung notifikasi belum dibaca
     */
    public function unreadCount(): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $count = $user->unreadNotifications()->count();

        return response()->json([
            'unread_count' => $count,
        ]);
    }
}
