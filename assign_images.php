<?php
/**
 * Assign downloaded real engine images to products by brand
 */
require_once __DIR__ . '/includes/config.php';

// Map brands to downloaded image filenames
$brandImageMap = [
    'Cummins' => ['ThOOhZyO9bP8.jpg', 'h1bS0onJ6WKj.jpg', 'pi0kB9PPKgIr.png'],
    'Caterpillar' => ['F8BMTfFAnilj.jpg', '7ZK4NJugdPxL.jpg'],
    'Detroit Diesel' => ['9dnFXOZehH7C.jpg', 'QyoeGA5qymXg.jpg', 'WLUNSZYZrMGJ.jpg'],
    'Volvo Penta' => ['Xdbj8lpdz1iq.jpg', 'ihwLjx2p8g4R.png', 'uKgFJe0aNOfo.jpg'],
    'Yanmar' => ['sO5xbAo4TbUu.jpg', 'Pqm7XLjXmuiO.jpg'],
    'MAN' => ['9xDtixgiSq2f.jpg', '3A1szG9oG6zK.jpg'],
    'MTU' => ['djSAFQsa7Dkq.jpg', 'RNWJ91Rhx0Po.jpg', '112N8IxmNnHB.jpg'],
    'John Deere' => ['dDhISUQgFrKp.jpg', '02uWeEqBKSkU.png', '3PCdM3kLTWZO.jpg'],
    'Mitsubishi' => ['dLypb7Nt26kq.webp', 'IjyE0h0zzLFn.jpg'],
    'Scania' => ['IjyE0h0zzLFn.jpg'],
    'Perkins' => ['3PCdM3kLTWZO.jpg'],
    'FPT / Iveco' => ['JDhGApyx5oOq.webp'],
    'Deutz' => ['dDhISUQgFrKp.jpg'],
    'Doosan' => ['dLypb7Nt26kq.webp'],
    'Lehman / Ford' => ['9dnFXOZehH7C.jpg'],
    'Baudouin' => ['IjyE0h0zzLFn.jpg'],
    'Hino' => ['dLypb7Nt26kq.webp'],
    'Isuzu' => ['3PCdM3kLTWZO.jpg'],
];

echo "Assigning images to products...\n";
$count = 0;

$products = $pdo->query("SELECT id, brand FROM products WHERE is_active = 1 ORDER BY id")->fetchAll();

foreach ($products as $product) {
    $brand = $product['brand'];
    $images = $brandImageMap[$brand] ?? ['ThOOhZyO9bP8.jpg'];
    $image = $images[$count % count($images)];
    
    $pdo->prepare("UPDATE products SET image = ? WHERE id = ?")->execute(['products/' . $image, $product['id']]);
    $count++;
}

echo "Done! Assigned images to $count products.\n";
