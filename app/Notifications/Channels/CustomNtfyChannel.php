<?php

namespace App\Notifications\Channels;
use Illuminate\Notifications\Notification;
use Ntfy\Message;
use Ntfy\Client;
use Ntfy\Server;
use Spatie\Backup\Events\BackupWasSuccessful;
use Spatie\Backup\Notifications\Notifications\BackupWasSuccessfulNotification;


class CustomNtfyChannel
{
    public function send($notifiable, BackupWasSuccessfulNotification $notification)
    {
        info('CustomNtfyChannel - BackupWasSuccessfulNotification processing started');

        $server = new Server('https://ntfy.sh/');

        $backupDestination = $notification->backupDestination();

        $new_variable = $backupDestination->usedStorage();



        $message = new Message();
        $message->topic('database-backup');
        $message->title('Backup Successful');
        $message->tags(['tada']);
        $message->body(
            "Backup for {$backupDestination->backupName()} on disk {$backupDestination->diskName()} was successful."
        );
        $message->priority(Message::PRIORITY_HIGH);



        $client = new Client($server);
        $client->send($message);

        info('CustomNtfyChannel - BackupWasSuccessfulNotification processing completed');
    }
}
