<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display all notifications
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a single notification as read and redirect to action
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($id);
        
        $notification->markAsRead();
        
        // Show toast
        session()->flash('toast', [
            'variant' => 'success',
            'heading' => 'Notification marked as read',
        ]);
        
        // Redirect to action URL if exists
        if (isset($notification->data['action_url'])) {
            return redirect($notification->data['action_url']);
        }
        
        return back();
    }

    /**
     * Mark all notifications as read
     */
    public function markAllRead()
    {
        $count = Auth::user()->unreadNotifications->count();
        Auth::user()->unreadNotifications->markAsRead();
        
        session()->flash('toast', [
            'variant' => 'success',
            'heading' => 'All notifications marked as read',
            'text' => "$count notification(s) marked as read",
        ]);
        
        return back();
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($id);
        
        $notification->delete();
        
        session()->flash('toast', [
            'variant' => 'success',
            'heading' => 'Notification deleted',
        ]);
        
        return back();
    }

    /**
     * Clear all read notifications
     */
    public function clearRead()
    {
        $count = Auth::user()
            ->notifications()
            ->whereNotNull('read_at')
            ->count();
            
        Auth::user()
            ->notifications()
            ->whereNotNull('read_at')
            ->delete();
        
        session()->flash('toast', [
            'variant' => 'success',
            'heading' => 'Read notifications cleared',
            'text' => "$count notification(s) deleted",
        ]);
        
        return back();
    }
}
