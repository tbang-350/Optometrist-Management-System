<?php

namespace App\Providers;

use App\Notifications\Channels\CleanUpFailedNtfyChannel;
use App\Notifications\Channels\CleanupSuccessfulNtfyChannel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Channels\CustomNtfyChannel;
use App\Notifications\Channels\FailedBackupNtfyChannel;
use App\Notifications\Channels\HealthyBackupFoundNtfyChannel;
use App\Notifications\Channels\UnhealthyBackupNtfyChannel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadGoogleDriver();

        Notification::extend('customNtfy', function ($app) {
            return new CustomNtfyChannel();
        });

        Notification::extend('failedBackupNtfy', function ($app) {
            return new FailedBackupNtfyChannel();
        });

        Notification::extend('unhealthyBackupNtfy', function ($app) {
            return new UnhealthyBackupNtfyChannel();
        });

        Notification::extend('healthyBackupNtfy', function ($app) {
            return new HealthyBackupFoundNtfyChannel();
        });

        Notification::extend('cleanupSuccessfulNtfy', function ($app) {
            return new CleanupSuccessfulNtfyChannel();
        });

        Notification::extend('cleanupFailedNtfy', function ($app) {
            return new CleanUpFailedNtfyChannel();
        });


    }


    public function loadGoogleDriver(): void
    {

        try {
            Storage::extend('google', function($app, $config) {
                $options = [];

                if (!empty($config['teamDriveId'] ?? null)) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }

                if (!empty($config['sharedFolderId'] ?? null)) {
                    $options['sharedFolderId'] = $config['sharedFolderId'];
                }

                $client = new \Google\Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);

                $service = new \Google\Service\Drive($client);
                $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
                $driver = new \League\Flysystem\Filesystem($adapter);

                return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter);
            });
        } catch(\Exception $e) {
            // your exception handling logic
        }

    }

}
