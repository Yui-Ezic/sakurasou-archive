<?php

declare(strict_types=1);

use App\Http;
use Slim\App;

return static function (App $app): void {
    $app->get('/', Http\Action\HomeAction::class);

    $app->post('/storage/image/upload', Http\Action\Storage\Image\UploadAction::class);
};
