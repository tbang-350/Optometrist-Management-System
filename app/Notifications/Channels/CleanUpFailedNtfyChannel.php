<?php

namespace App\Notifications\Channels;
use Illuminate\Notifications\Notification;
use Ntfy\Message;
use Ntfy\Client;
use Ntfy\Server;
use Spatie\Backup\Events\BackupWasSuccessful;
use Spatie\Backup\Notifications\Notifications\CleanupHasFailedNotification;


class CleanUpFailedNtfyChannel
{
    public function send($notifiable, CleanupHasFailedNotification $notification)
    {
        info('CustomNtfyChannel - CleanupHasFailedNotification processing started');

        $server = new Server('https://ntfy.sh/');

        $backupDestination = $notification->backupDestination();

        $message = new Message();
        $message->topic('database-backup');
        $message->title('Cleanup Failed');
        $message->body(
            "Cleanup for {$backupDestination->backupName()} on disk {$backupDestination->diskName()} has failed , please check what went went wrong as well as your eamil for more details."
        );
        $message->tags(['warning','exclamation']);
        $message->priority(Message::PRIORITY_MAX);

        $client = new Client($server);
        $client->send($message);

        info('CustomNtfyChannel - CleanupHasFailedNotification processing completed');
    }
}
