<?php
/**
 * Download real marine diesel engine images
 * Uses free stock/placeholder images for each engine brand
 */

require_once __DIR__ . '/includes/config.php';

$uploadDir = __DIR__ . '/assets/uploads/products/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

// Image URLs for each brand (using freely available product images)
$brandImages = [
    'Cummins' => 'https://images.unsplash.com/photo-1613214149922-f1809c99b414?w=600&h=400&fit=crop',
    'Caterpillar' => 'https://images.unsplash.com/photo-1504222490345-c075b6008014?w=600&h=400&fit=crop',
    'Detroit Diesel' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600&h=400&fit=crop',
    'Volvo Penta' => 'https://images.unsplash.com/photo-1605281317010-fe5ffe798166?w=600&h=400&fit=crop',
    'Yanmar' => 'https://images.unsplash.com/photo-1611689342806-0863700ce1e4?w=600&h=400&fit=crop',
    'MAN' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600&h=400&fit=crop',
    'MTU' => 'https://images.unsplash.com/photo-1504222490345-c075b6008014?w=600&h=400&fit=crop',
    'John Deere' => 'https://images.unsplash.com/photo-1613214149922-f1809c99b414?w=600&h=400&fit=crop',
    'Mitsubishi' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600&h=400&fit=crop',
    'Scania' => 'https://images.unsplash.com/photo-1504222490345-c075b6008014?w=600&h=400&fit=crop',
    'Perkins' => 'https://images.unsplash.com/photo-1613214149922-f1809c99b414?w=600&h=400&fit=crop',
    'FPT / Iveco' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600&h=400&fit=crop',
    'Deutz' => 'https://images.unsplash.com/photo-1504222490345-c075b6008014?w=600&h=400&fit=crop',
    'Doosan' => 'https://images.unsplash.com/photo-1613214149922-f1809c99b414?w=600&h=400&fit=crop',
    'Lehman / Ford' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600&h=400&fit=crop',
    'Baudouin' => 'https://images.unsplash.com/photo-1504222490345-c075b6008014?w=600&h=400&fit=crop',
    'Hino' => 'https://images.unsplash.com/photo-1613214149922-f1809c99b414?w=600&h=400&fit=crop',
    'Isuzu' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600&h=400&fit=crop',
];

echo "Downloading engine images...\n";
$count = 0;

// Get all products
$products = $pdo->query("SELECT id, sku, brand, slug FROM products WHERE is_active = 1")->fetchAll();

foreach ($products as $product) {
    $imageUrl = $brandImages[$product['brand']] ?? $brandImages['Cummins'];
    $filename = $product['slug'] . '.jpg';
    $filepath = $uploadDir . $filename;
    
    if (!file_exists($filepath)) {
        $ctx = stream_context_create(['http' => ['timeout' => 10, 'user_agent' => 'Mozilla/5.0']]);
        $imageData = @file_get_contents($imageUrl, false, $ctx);
        if ($imageData) {
            file_put_contents($filepath, $imageData);
            $pdo->prepare("UPDATE products SET image = ? WHERE id = ?")->execute(['products/' . $filename, $product['id']]);
            $count++;
            echo "  Downloaded: {$product['slug']}\n";
        } else {
            echo "  FAILED: {$product['slug']}\n";
        }
    } else {
        $pdo->prepare("UPDATE products SET image = ? WHERE id = ?")->execute(['products/' . $filename, $product['id']]);
        $count++;
    }
    
    // Small delay to be polite
    usleep(200000);
}

echo "\nDone! $count images processed.\n";
