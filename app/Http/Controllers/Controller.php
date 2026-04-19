<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Event;
use App\Models\User;
use App\Notifications\EventNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function store(Request $request)
    {
        // Validasi dan simpan event
        $event = Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'user_id' => auth()->id(),
            // ... data lainnya
        ]);
        
        // KIRIM NOTIFIKASI KE PEMBUAT EVENT
        auth()->user()->notify(new EventNotification($event, 'created', 'creator'));
        
        // ATAU KIRIM KE BANYAK USER
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new EventNotification($event, 'created', 'admin'));
        
        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat!');
    }
    
    public function update(Request $request, Event $event)
    {
        $event->update($request->validated());
        
        // NOTIFIKASI UPDATE
        auth()->user()->notify(new EventNotification($event, 'updated'));
        
        return back()->with('success', 'Event berhasil diperbarui!');
}

}