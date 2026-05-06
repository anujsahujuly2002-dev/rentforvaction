<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\PropertyGalleryImage;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class GetImageAnotherServerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-image-another-server-command {--download : Download images to local storage} {--test-range= : Test specific property ID range like 1000-1100} {--batch-size=10 : Number of properties to process in each batch} {--skip-discovery : Skip discovering new images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan and migrate property images from hrbo.com server including main and gallery images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Increase memory limit for large migrations
        ini_set('memory_limit', '512M');
        $this->info('Memory limit set to: ' . ini_get('memory_limit'));

        $csvFile = '/var/www/rentforvacations/property_images.csv';
        $oldServerGalleryUrl = 'https://www.hrbo.com/public/storage/upload/property_image/gallery_image/';
        $downloadImages = $this->option('download');

        if (!file_exists($csvFile)) {
            $this->error("CSV file not found: {$csvFile}");
            return 1;
        }

        $startTime = now();
        $this->logWithTime('Starting image migration from CSV file...');
        $this->logWithTime($downloadImages ? 'Download mode: ON - Images will be downloaded' : 'Scan mode: ON - Only updating database');
        $this->logWithTime("Start time: " . $startTime->format('Y-m-d H:i:s'));

        // Process properties from CSV file
        $this->processPropertiesFromCSV($csvFile, $oldServerGalleryUrl, $downloadImages, $startTime);
    }

    private function processPropertiesFromCSV($csvFile, $oldServerGalleryUrl, $downloadImages, $startTime)
    {
        $stats = [
            'total_properties' => 0,
            'properties_updated' => 0,
            'main_images_set' => 0,
            'gallery_images_added' => 0,
            'images_downloaded' => 0,
            'download_failed' => 0,
            'properties_not_found' => 0
        ];

        // Read CSV file
        $csvData = array_map('str_getcsv', file($csvFile));
        $header = array_shift($csvData); // Remove header row

        $stats['total_properties'] = count($csvData);
        $this->logWithTime("Found {$stats['total_properties']} properties in CSV");

        foreach ($csvData as $row) {
            if (empty($row[0])) continue; // Skip empty rows
            $propertyId = $row[0];
            $images = array_slice($row, 1, 10); // Get image1 to image10
            $images = array_filter($images); // Remove empty values
            if (empty($images)) {
                $this->warn("No images found for property {$propertyId}");
                continue;
            }

            $this->logWithTime("Processing Property ID: {$propertyId} with " . count($images) . " images");

            // Check if directory already exists (skip if already processed)
            $galleryPath = storage_path("app/public/upload/property_image/gallery_image/{$propertyId}/");
            if (file_exists($galleryPath)) {
                $this->info("Directory already exists for property {$propertyId}, skipping...");
                continue;
            }

            // Find property in database
            $property = Property::where('old_id', $propertyId)->first();
            if (!$property) {
                $this->warn("Property with old ID {$propertyId} not found in database");
                $stats['properties_not_found']++;
                continue;
            }

            // First image becomes main image
            $mainImage = $images[0];
            $property->property_image = $mainImage;
            $property->save();
            $stats['main_images_set']++;
            $this->info("✓ Set main image: {$mainImage}");

            if ($downloadImages) {
                $mainImageUrl = $oldServerGalleryUrl . $propertyId . '/' . $mainImage;
                if ($this->downloadMainImage($mainImageUrl, $property->id, $mainImage)) {
                    $stats['images_downloaded']++;
                } else {
                    $stats['download_failed']++;
                }
            }

            // Store all images (including first one) in gallery table
            foreach ($images as $imageName) {
                // Check if image already exists
                $existingImage = PropertyGalleryImage::where('property_id', $property->id)
                    ->where('image_name', $imageName)
                    ->first();

                if (!$existingImage) {
                    PropertyGalleryImage::create([
                        'property_id' => $property->id,
                        'image_name' => $imageName
                    ]);
                    $stats['gallery_images_added']++;
                    $this->info("✓ Added to gallery: {$imageName}");
                } else {
                    $this->info("Image {$imageName} already exists in gallery");
                }

                if ($downloadImages) {
                    $imageUrl = $oldServerGalleryUrl . $propertyId . '/' . $imageName;
                    if ($this->downloadGalleryImage($imageUrl, $property->id, $imageName)) {
                        $stats['images_downloaded']++;
                    } else {
                        $stats['download_failed']++;
                    }
                }
            }

            $stats['properties_updated']++;
            $this->logWithTime("Completed Property ID: {$propertyId}");

            // Small delay to prevent overwhelming the server
            usleep(200000); // 0.2 seconds
        }

        $endTime = now();
        $duration = $startTime->diffForHumans($endTime, true);

        $this->displayCSVStats($stats);
        $this->logWithTime('CSV migration completed!');
        $this->logWithTime("End time: " . $endTime->format('Y-m-d H:i:s'));
        $this->logWithTime("Total duration: " . $duration);
    }

    private function displayCSVStats($stats)
    {
        $this->info('');
        $this->info('=== CSV MIGRATION STATISTICS ===');
        $this->info("Total properties in CSV: {$stats['total_properties']}");
        $this->info("Properties updated: {$stats['properties_updated']}");
        $this->info("Properties not found: {$stats['properties_not_found']}");
        $this->info("Main images set: {$stats['main_images_set']}");
        $this->info("Gallery images added: {$stats['gallery_images_added']}");
        $this->info("Images downloaded: {$stats['images_downloaded']}");
        $this->info("Download failed: {$stats['download_failed']}");
        $this->info('================================');
    }

    private function logWithTime($message)
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        $this->info("[$timestamp] $message");
    }


    private function downloadGalleryImage($imageUrl, $propertyId, $imageName)
    {
        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 20,
                    'header' => [
                        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                        'Accept: image/webp,image/apng,image/*,*/*;q=0.8',
                        'Connection: close'
                    ]
                ]
            ]);

            $imageData = file_get_contents($imageUrl, false, $context);
            if ($imageData !== false) {
                // Store in existing gallery structure: storage/app/public/upload/property_image/gallery_image/{propertyId}/
                $destinationPath = storage_path("app/public/upload/property_image/gallery_image/{$propertyId}/");

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $fullPath = $destinationPath . $imageName;
                file_put_contents($fullPath, $imageData);
                $this->info("Downloaded gallery: {$imageName}");

                return true;
            }
        } catch (\Exception $e) {
            $this->error("Failed to download gallery image {$imageUrl}: " . $e->getMessage());
        }

        return false;
    }

    private function downloadMainImage($imageUrl, $propertyId, $imageName)
    {
        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 20,
                    'header' => [
                        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                        'Accept: image/webp,image/apng,image/*,*/*;q=0.8',
                        'Connection: close'
                    ]
                ]
            ]);

            $imageData = file_get_contents($imageUrl, false, $context);
            if ($imageData !== false) {
                // Store in main image folder: storage/app/public/upload/property_image/main_image/
                $destinationPath = storage_path("app/public/upload/property_image/main_image/");

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $fullPath = $destinationPath . $imageName;
                file_put_contents($fullPath, $imageData);
                $this->info("Downloaded main image: {$imageName}");

                return true;
            }
        } catch (\Exception $e) {
            $this->error("Failed to download main image {$imageUrl}: " . $e->getMessage());
        }

        return false;
    }

    private function displayStats($stats)
    {
        $this->info('');
        $this->info('=== MIGRATION STATISTICS ===');
        $this->info("Total properties processed: {$stats['total_properties']}");
        $this->info("Properties with galleries: {$stats['properties_with_galleries']}");
        $this->info("New images discovered: {$stats['new_images_discovered']}");
        $this->info("Existing images verified: {$stats['existing_images_verified']}");
        $this->info("Images not accessible: {$stats['images_not_accessible']}");
        $this->info("Images downloaded successfully: {$stats['downloaded_successfully']}");
        $this->info("Images download failed: {$stats['download_failed']}");
        $this->info('===============================');
    }
}
