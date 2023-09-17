<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationSeenController extends Controller
{
  public function __invoke(DatabaseNotification $notification)
  {
    // ruter vraca DatabaseNotification. Policy mora da se registruje u AuthServiceProvider.php
    $this->authorize('update', $notification);
    $notification->markAsRead();

    return redirect()->back()->with('success', 'Notification marked as read');
  }
}
