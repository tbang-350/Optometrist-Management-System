<?php

namespace App\Notifications\Channels;
use Illuminate\Notifications\Notification;
use Ntfy\Message;
use Ntfy\Client;
use Ntfy\Server;
use Spatie\Backup\Events\BackupWasSuccessful;
use Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFoundNotification;


class UnhealthyBackupNtfyChannel
{
    public function send($notifiable, UnhealthyBackupWasFoundNotification $notification)
    {
        info('CustomNtfyChannel - unhealthyBackupFound processing started');

        $server = new Server('https://ntfy.sh/');

        $backupDestination = $notification->backupDestination();

        $message = new Message();
        $message->topic('database-backup');
        $message->title('Unhealthy Backup Found');
        $message->body(
            "One or more backups for {$backupDestination->backupName()} on disk {$backupDestination->diskName()} are unhealthy , please check what went went wrong."
        );
        $message->tags(['nauseated_face','face_with_head_bandage','face_with_thermometer','mask']);
        $message->priority(Message::PRIORITY_MAX);

        $client = new Client($server);
        $client->send($message);

        info('CustomNtfyChannel - unhealthyBackupFound processing completed');
    }
}
