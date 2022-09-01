<?php

declare(strict_types=1);

namespace App\Http\Action\Storage\Image;

use App\Http\Response\JsonResponse;
use DomainException;
use League\Flysystem\Filesystem;
use League\Flysystem\UnableToWriteFile;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UploadAction implements RequestHandlerInterface
{
    public function __construct(
        private Filesystem $storage
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (\count($uploadedFiles = $request->getUploadedFiles()) !== 1) {
            throw new DomainException('Exact 1 image should be specified.');
        }
        /** @var UploadedFileInterface $image */
        $image = reset($uploadedFiles);
        // TODO: validate file is image
        try {
            $this->storage->write($image->getClientFilename(), $image->getStream()->getContents());
        } catch (UnableToWriteFile $e) {
            echo '<pre>';
            var_dump($e);
            exit;
        }
        return new JsonResponse(['success' => true]);
    }
}
