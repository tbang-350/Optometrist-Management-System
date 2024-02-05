<?php

namespace App\Notifications\Channels;
use Illuminate\Notifications\Notification;
use Ntfy\Message;
use Ntfy\Client;
use Ntfy\Server;
use Spatie\Backup\Notifications\Notifications\HealthyBackupWasFoundNotification;

class HealthyBackupFoundNtfyChannel
{
    public function send($notifiable, HealthyBackupWasFoundNotification $notification)
    {
        info('CustomNtfyChannel - BackupHasFailedNotification processing started');

        $server = new Server('https://ntfy.sh/');

        $backupDestination = $notification->backupDestination();

        $message = new Message();
        $message->topic('database-backup');
        $message->title('Healthy Backup Found');
        $message->body(
            "All Backups for {$backupDestination->backupName()} on disk {$backupDestination->diskName()} are considered healthy , please check cloud storege for more details and inspection ."
        );
        $message->tags(['white_check_mark']);
        $message->priority(Message::PRIORITY_MIN);

        $client = new Client($server);
        $client->send($message);

        info('CustomNtfyChannel - BackupHasFailedNotification processing completed');
    }
}
