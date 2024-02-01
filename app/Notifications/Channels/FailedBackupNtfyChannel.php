<?php

namespace App\Notifications\Channels;
use Illuminate\Notifications\Notification;
use Ntfy\Message;
use Ntfy\Client;
use Ntfy\Server;
use Spatie\Backup\Events\BackupWasSuccessful;
use Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification;


class FailedBackupNtfyChannel
{
    public function send($notifiable, BackupHasFailedNotification $notification)
    {
        info('CustomNtfyChannel - BackupHasFailedNotification processing started');

        $server = new Server('https://ntfy.sh/');

        $backupDestination = $notification->backupDestination();

        $message = new Message();
        $message->topic('database-backup');
        $message->title('Backup Failed');
        $message->body(
            "Backup for {$backupDestination->backupName()} on disk {$backupDestination->diskName()} has failed , please check what went went wrong."
        );
        $message->tags(['rotating_light','exclamation','skull']);
        $message->priority(Message::PRIORITY_MAX);

        $client = new Client($server);
        $client->send($message);

        info('CustomNtfyChannel - BackupHasFailedNotification processing completed');
    }
}
