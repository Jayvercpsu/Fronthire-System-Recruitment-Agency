<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Api\Exception\AuthorizationRequired;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class MediaStorageService
{
    private ?Cloudinary $cloudinary = null;

    public function store(UploadedFile $file, string $folder, ?string $filename = null): string
    {
        if ($this->shouldUseCloudinary()) {
            return $this->storeToCloudinary($file, $folder, $filename);
        }

        return $this->storeToLocal($file, $folder, $filename);
    }

    public function delete(?string $storedValue): void
    {
        if (! is_string($storedValue) || trim($storedValue) === '') {
            return;
        }

        if (! $this->isRemotePath($storedValue)) {
            Storage::disk($this->localDisk())->delete($storedValue);

            return;
        }

        if (! $this->hasCloudinaryCredentials()) {
            return;
        }

        $asset = $this->extractCloudinaryAssetIdentifiers($storedValue);
        if ($asset === null) {
            return;
        }

        try {
            $this->cloudinaryClient()
                ->uploadApi()
                ->destroy($asset['public_id'], array_merge(
                    [
                        'resource_type' => $asset['resource_type'],
                        'type' => 'upload',
                        'invalidate' => true,
                    ],
                    $this->cloudinaryHttpOptions()
                ));
        } catch (Throwable $exception) {
            throw $this->normalizeCloudinaryException($exception, 'Unable to delete file from Cloudinary.');
        }
    }

    public function url(?string $storedValue): ?string
    {
        if (! is_string($storedValue) || trim($storedValue) === '') {
            return null;
        }

        if ($this->isRemotePath($storedValue)) {
            return $storedValue;
        }

        return $this->localDiskAdapter()->url($storedValue);
    }

    public function isRemotePath(?string $storedValue): bool
    {
        if (! is_string($storedValue) || trim($storedValue) === '') {
            return false;
        }

        return filter_var($storedValue, FILTER_VALIDATE_URL) !== false
            && Str::startsWith(Str::lower($storedValue), ['http://', 'https://']);
    }

    public function localAbsolutePath(?string $storedValue): ?string
    {
        if (! is_string($storedValue) || trim($storedValue) === '' || $this->isRemotePath($storedValue)) {
            return null;
        }

        return $this->localDiskAdapter()->path($storedValue);
    }

    public function cloudinaryDownloadUrl(?string $storedValue): ?string
    {
        if (! $this->isRemotePath($storedValue)) {
            return $storedValue;
        }

        return preg_replace('#/upload/#', '/upload/fl_attachment/', $storedValue, 1) ?: $storedValue;
    }

    private function storeToLocal(UploadedFile $file, string $folder, ?string $filename = null): string
    {
        $targetFolder = $this->normalizeFolder($folder);
        $targetName = $this->buildLocalFilename($file, $filename);

        return $file->storeAs($targetFolder, $targetName, $this->localDisk());
    }

    private function storeToCloudinary(UploadedFile $file, string $folder, ?string $filename = null): string
    {
        $resourceType = $this->detectResourceType($file);
        $targetFolder = $this->cloudinaryTargetFolder($folder);

        $options = [
            'resource_type' => $resourceType,
            'folder' => $targetFolder,
            'use_filename' => true,
            'unique_filename' => false,
            'overwrite' => false,
            'filename_override' => $file->getClientOriginalName(),
        ];

        if ($resourceType === 'raw') {
            $options['public_id'] = $this->buildRawPublicId($file, $filename);
        } else {
            $options['public_id'] = $this->buildNonRawPublicId($file, $filename);
        }

        $options = array_merge($options, $this->cloudinaryHttpOptions());

        try {
            $result = $this->cloudinaryClient()->uploadApi()->upload($file->getRealPath(), $options);
        } catch (Throwable $exception) {
            throw $this->normalizeCloudinaryException($exception, 'Unable to upload file to Cloudinary.');
        }

        $secureUrl = $result['secure_url'] ?? null;
        if (! is_string($secureUrl) || trim($secureUrl) === '') {
            throw new RuntimeException('Cloudinary upload did not return a secure_url.');
        }

        return $secureUrl;
    }

    private function detectResourceType(UploadedFile $file): string
    {
        $mimeType = Str::lower($file->getMimeType() ?: '');

        if (Str::startsWith($mimeType, 'image/')) {
            return 'image';
        }

        if (Str::startsWith($mimeType, 'video/')) {
            return 'video';
        }

        return 'raw';
    }

    private function localDisk(): string
    {
        return config('media.local_disk', 'public');
    }

    private function localDiskAdapter(): FilesystemAdapter
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($this->localDisk());

        return $disk;
    }

    private function shouldUseCloudinary(): bool
    {
        if (! config('media.files_use_cloudinary', false)) {
            return false;
        }

        return $this->hasCloudinaryCredentials();
    }

    private function hasCloudinaryCredentials(): bool
    {
        return filled(config('media.cloudinary.cloud_name'))
            && filled(config('media.cloudinary.api_key'))
            && filled(config('media.cloudinary.api_secret'));
    }

    private function cloudinaryClient(): Cloudinary
    {
        if ($this->cloudinary instanceof Cloudinary) {
            return $this->cloudinary;
        }

        $config = [
            'cloud' => [
                'cloud_name' => config('media.cloudinary.cloud_name'),
                'api_key' => config('media.cloudinary.api_key'),
                'api_secret' => config('media.cloudinary.api_secret'),
            ],
            'url' => [
                'secure' => (bool) config('media.cloudinary.secure', true),
            ],
        ];

        $cname = config('media.cloudinary.cname');
        if (is_string($cname) && trim($cname) !== '') {
            $config['url']['cname'] = trim($cname);
        }

        $this->cloudinary = new Cloudinary($config);

        return $this->cloudinary;
    }

    private function cloudinaryTargetFolder(string $folder): string
    {
        $root = trim((string) config('media.cloudinary.folder', 'LMS-ASSETS'), '/');
        $child = $this->normalizeFolder($folder);

        if ($child === '') {
            return $root;
        }

        return trim("{$root}/{$child}", '/');
    }

    private function normalizeFolder(string $folder): string
    {
        return trim($folder, " \t\n\r\0\x0B/");
    }

    private function buildRawPublicId(UploadedFile $file, ?string $filename = null): string
    {
        $sourceName = is_string($filename) && trim($filename) !== ''
            ? $filename
            : $file->getClientOriginalName();

        $baseName = $this->sanitizeSegment(pathinfo($sourceName, PATHINFO_FILENAME));
        $extension = pathinfo($sourceName, PATHINFO_EXTENSION);

        if ($extension === '') {
            $extension = $file->getClientOriginalExtension();
        }

        $extension = $this->sanitizeExtension($extension);
        $finalName = $extension !== '' ? "{$baseName}.{$extension}" : $baseName;

        return $finalName;
    }

    private function buildNonRawPublicId(UploadedFile $file, ?string $filename = null): string
    {
        if (is_string($filename) && trim($filename) !== '') {
            $base = $this->sanitizeSegment(pathinfo($filename, PATHINFO_FILENAME));
        } else {
            $originalBase = pathinfo((string) $file->getClientOriginalName(), PATHINFO_FILENAME);
            $base = $this->sanitizeSegment($originalBase);
            $base .= '-'.Str::lower(Str::random(8));
        }

        return $base;
    }

    private function buildLocalFilename(UploadedFile $file, ?string $filename = null): string
    {
        if (is_string($filename) && trim($filename) !== '') {
            $base = $this->sanitizeSegment(pathinfo($filename, PATHINFO_FILENAME));
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
        } else {
            $base = $this->sanitizeSegment(pathinfo((string) $file->getClientOriginalName(), PATHINFO_FILENAME));
            $base .= '-'.Str::lower(Str::random(8));
            $extension = $file->getClientOriginalExtension() ?: $file->guessExtension();
        }

        $extension = $this->sanitizeExtension($extension);

        return $extension !== '' ? "{$base}.{$extension}" : $base;
    }

    private function sanitizeSegment(string $value): string
    {
        $ascii = Str::of($value)->ascii()->value();
        $clean = preg_replace('/[^A-Za-z0-9._-]+/', '-', $ascii) ?: '';
        $clean = trim($clean, '.-_ ');

        return $clean !== '' ? $clean : 'file';
    }

    private function sanitizeExtension(?string $extension): string
    {
        if (! is_string($extension) || trim($extension) === '') {
            return '';
        }

        return Str::lower(preg_replace('/[^A-Za-z0-9]+/', '', $extension) ?: '');
    }

    /**
     * @return array{verify: bool|string}
     */
    private function cloudinaryHttpOptions(): array
    {
        $verifySsl = (bool) config('media.cloudinary.verify_ssl', true);
        $caBundle = config('media.cloudinary.ca_bundle');

        if (is_string($caBundle) && trim($caBundle) !== '') {
            return ['verify' => trim($caBundle)];
        }

        return ['verify' => $verifySsl];
    }

    /**
     * @return array{resource_type: string, public_id: string}|null
     */
    private function extractCloudinaryAssetIdentifiers(string $storedValue): ?array
    {
        $path = parse_url($storedValue, PHP_URL_PATH);
        if (! is_string($path)) {
            return null;
        }

        if (! preg_match('#/(image|video|raw)/upload/(.+)$#', $path, $matches)) {
            return null;
        }

        $resourceType = $matches[1];
        $publicIdSegments = explode('/', $matches[2]);

        if (isset($publicIdSegments[0]) && preg_match('/^v\d+$/', $publicIdSegments[0])) {
            array_shift($publicIdSegments);
        }

        $publicId = implode('/', $publicIdSegments);
        $publicId = urldecode($publicId);

        if ($resourceType !== 'raw') {
            $publicId = preg_replace('/\.[^\/.]+$/', '', $publicId) ?: $publicId;
        }

        if (trim($publicId) === '') {
            return null;
        }

        return [
            'resource_type' => $resourceType,
            'public_id' => $publicId,
        ];
    }

    private function normalizeCloudinaryException(Throwable $exception, string $defaultMessage): RuntimeException
    {
        $message = $exception->getMessage();

        if (Str::contains($message, ['cURL error 60', 'SSL certificate problem'])) {
            return new RuntimeException(
                'Set CLOUDINARY_VERIFY_SSL=false for local dev only OR set CLOUDINARY_CA_BUNDLE.',
                (int) $exception->getCode(),
                $exception
            );
        }

        if ($exception instanceof AuthorizationRequired || Str::contains(Str::lower($message), ['unauthorized', 'invalid signature'])) {
            return new RuntimeException(
                'Cloudinary authorization failed. Check CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, and CLOUDINARY_API_SECRET.',
                (int) $exception->getCode(),
                $exception
            );
        }

        return new RuntimeException($defaultMessage, (int) $exception->getCode(), $exception);
    }
}
