<?php

declare(strict_types=1);

use App\Http;
use App\Http\Action\AuthorizeAction;
use App\Http\Action\TokenAction;
use Slim\App;

return static function (App $app): void {
    $app->get('/', Http\Action\HomeAction::class);

    $app->map(['GET', 'POST'], '/authorize', AuthorizeAction::class);
    $app->post('/token', TokenAction::class);

    $app->post('/storage/image/upload', Http\Action\Storage\Image\UploadAction::class);
};
