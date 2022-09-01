<?php

declare(strict_types=1);

use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;
use Psr\Container\ContainerInterface;

use function App\env;

return [
    Filesystem::class => static fn (ContainerInterface $container): Filesystem => new Filesystem($container->get(FilesystemAdapter::class)),
    FilesystemAdapter::class => static fn (ContainerInterface $container): FilesystemAdapter => new AwsS3V3Adapter($container->get(S3Client::class), $container->get('config')['storage']['bucket']),
    S3Client::class => static fn (ContainerInterface $container): S3Client => new S3Client($container->get('config')[S3Client::class]['options']),
    'config' => [
        'storage' => [
            'bucket' => env('S3_BUCKET'),
        ],
        S3Client::class => [
            'options' => [
                'version' => 'latest',
                'region'  => 'eu-central-1',
                'endpoint' => env('S3_ENDPOINT'),
                'use_path_style_endpoint' => true,
                'credentials' => [
                    'key'    => env('S3_KEY_ID'),
                    'secret' => env('S3_KEY_SECRET'),
                ],
            ],
        ],
    ],
];
