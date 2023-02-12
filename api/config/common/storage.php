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
    FilesystemAdapter::class => static function (ContainerInterface $container): FilesystemAdapter {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var string $bucket
         */
        $bucket = $container->get('config')['storage']['bucket'];
        return new AwsS3V3Adapter($container->get(S3Client::class), $bucket);
    },
    S3Client::class => static function (ContainerInterface $container): S3Client {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{
         *     varsion:string,
         *     region:string,
         *     endpoint:string,
         *     use_path_style_endpoint:bool,
         *     credentials:string[],
         * } $options
         */
        $options = $container->get('config')[S3Client::class]['options'];
        return new S3Client($options);
    },
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
