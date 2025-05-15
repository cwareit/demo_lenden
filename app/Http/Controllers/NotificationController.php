<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Reader;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = Notification::with('readers')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('notifications.notifications', [
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark a notification as read.
     *
     * @param int $notificationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function read($notificationId)
    {
        $newReader = new Reader();
        $newReader->notificationId = $notificationId;
        $newReader->readerId = auth()->user()->id;
        $newReader->save();

        return back();
    }
}
