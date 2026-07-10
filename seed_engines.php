<?php
/**
 * Marine Diesel Engines Database Seeder
 * Seeds all categories and products with real part numbers
 */

require_once __DIR__ . '/includes/config.php';

echo "=== Marine Diesel Engines Database Seeder ===\n\n";

// Categories (Manufacturers)
$categories = [
    ['Cummins', 'cummins', 'Complete line of remanufactured Cummins marine diesel engines. From the compact 4BTA to the powerful KTA50, all models available.'],
    ['Caterpillar', 'caterpillar', 'Remanufactured Caterpillar (CAT) marine diesel engines. C7 through C32 and legacy 3400/3500 series.'],
    ['Detroit Diesel', 'detroit-diesel', 'Remanufactured Detroit Diesel marine engines. Series 53, 71, 92, 149, and modern Series 60/DD series.'],
    ['Volvo Penta', 'volvo-penta', 'Remanufactured Volvo Penta marine diesel engines. D1 through D13 complete range for recreational and commercial.'],
    ['Yanmar', 'yanmar', 'Remanufactured Yanmar marine diesel engines. From the 1GM10 to the 6LY series for sailboats and powerboats.'],
    ['MAN', 'man', 'Remanufactured MAN marine diesel engines. D2676, D2868, and D2862 series for yachts and commercial vessels.'],
    ['MTU', 'mtu', 'Remanufactured MTU marine diesel engines. Series 60, 2000, and 4000 for high-performance marine applications.'],
    ['John Deere', 'john-deere', 'Remanufactured John Deere PowerTech marine diesel engines. 4045, 6068, 6090, and 6135 series.'],
    ['Mitsubishi', 'mitsubishi', 'Remanufactured Mitsubishi marine diesel engines. S6B3 through S16R for commercial and industrial marine.'],
    ['Scania', 'scania', 'Remanufactured Scania marine diesel engines. DI13 and DI16 series for commercial marine applications.'],
    ['Perkins', 'perkins', 'Remanufactured Perkins marine diesel engines. Classic 4.108, 4.236, 6.354 and modern 1100 series.'],
    ['FPT / Iveco', 'fpt-iveco', 'Remanufactured FPT (Iveco) marine diesel engines. N40 through C16 series for pleasure and commercial.'],
    ['Deutz', 'deutz', 'Remanufactured Deutz marine diesel engines. BF4M, BF6M, and TCD series for marine auxiliary and propulsion.'],
    ['Doosan', 'doosan', 'Remanufactured Doosan marine diesel engines. L136, V158TI, and V222TI for commercial marine.'],
    ['Lehman / Ford', 'lehman-ford', 'Remanufactured Lehman Ford marine diesel engines. Classic trawler engines - 80, 120, 135, and 225 HP models.'],
    ['Baudouin', 'baudouin', 'Remanufactured Baudouin marine diesel engines. 6W105M through 12M55 for commercial marine applications.'],
    ['Hino', 'hino', 'Remanufactured Hino marine diesel engines. W04D, W06E, P11C, and E13C for commercial workboats.'],
    ['Isuzu', 'isuzu', 'Remanufactured Isuzu marine diesel engines. 4JH1, 4HK1, 6HK1, and 6WG1 for commercial marine.'],
];

echo "Inserting categories...\n";
$catIds = [];
foreach ($categories as $cat) {
    $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, display_order) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE description = VALUES(description)");
    $stmt->execute([$cat[0], $cat[1], $cat[2], array_search($cat, $categories)]);
    $catIds[$cat[1]] = $pdo->lastInsertId() ?: $pdo->query("SELECT id FROM categories WHERE slug = '{$cat[1]}'")->fetchColumn();
}
echo "  " . count($categories) . " categories inserted.\n\n";

// Products - Complete Marine Diesel Engine Database
$engines = [
    // CUMMINS
    ['CUM-4BTA39-M', 'Cummins 4BTA 3.9', 'Cummins', '4BTA 3.9', '4BTA Series', 'cummins', 'marine_propulsion', '4', 'Inline 4', '3.9L', '80-150', 80, 150, 'Turbocharged', 'Mechanical Injection', 'Heat Exchanger', 'Small vessels, workboats, sailboats', '1800-2800', 750, 'EPA Tier 2'],
    ['CUM-6BTA59-M', 'Cummins 6BTA 5.9', 'Cummins', '6BTA 5.9', '6BTA Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '5.9L', '150-370', 150, 370, 'Turbocharged Aftercooled', 'Mechanical Injection', 'Heat Exchanger', 'Fishing boats, yachts, patrol boats', '2200-3000', 1050, 'EPA Tier 2'],
    ['CUM-QSB59-M', 'Cummins QSB5.9', 'Cummins', 'QSB5.9', 'QSB Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '5.9L', '230-480', 230, 480, 'Turbocharged Aftercooled', 'High Pressure Common Rail', 'Heat Exchanger', 'Sport fishing, cruisers', '2200-3000', 1100, 'EPA Tier 3'],
    ['CUM-QSB67-M', 'Cummins QSB6.7', 'Cummins', 'QSB6.7', 'QSB Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '6.7L', '247-542', 247, 542, 'Turbocharged Aftercooled', 'High Pressure Common Rail', 'Heat Exchanger', 'Recreational, commercial marine', '2200-3000', 1150, 'EPA Tier 3'],
    ['CUM-6CTA83-M', 'Cummins 6CTA 8.3', 'Cummins', '6CTA 8.3', '6CTA Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '8.3L', '260-430', 260, 430, 'Turbocharged Aftercooled', 'Mechanical Injection', 'Heat Exchanger', 'Workboats, towboats', '2100-2600', 1400, 'EPA Tier 2'],
    ['CUM-QSC83-M', 'Cummins QSC8.3', 'Cummins', 'QSC8.3', 'QSC Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '8.3L', '330-600', 330, 600, 'Turbocharged Aftercooled', 'High Pressure Common Rail', 'Heat Exchanger', 'Commercial, recreational', '2100-2800', 1500, 'EPA Tier 3'],
    ['CUM-QSL9-M', 'Cummins QSL9', 'Cummins', 'QSL9', 'QSL Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '8.9L', '250-450', 250, 450, 'Turbocharged Aftercooled', 'High Pressure Common Rail', 'Heat Exchanger', 'Mid-size commercial', '1800-2400', 1600, 'EPA Tier 3'],
    ['CUM-QSM11-M', 'Cummins QSM11', 'Cummins', 'QSM11', 'QSM Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '11.0L', '330-715', 330, 715, 'Turbocharged Aftercooled', 'High Pressure Common Rail', 'Heat Exchanger', 'Offshore, passenger vessels', '1800-2300', 2100, 'EPA Tier 3'],
    ['CUM-X15-M', 'Cummins X15', 'Cummins', 'X15', 'X Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '15.0L', '450-600', 450, 600, 'Turbocharged Aftercooled', 'High Pressure Common Rail', 'Heat Exchanger', 'Large commercial marine', '1600-2100', 3000, 'EPA Tier 4'],
    ['CUM-KTA19-M', 'Cummins KTA19', 'Cummins', 'KTA19', 'KTA Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '19.0L', '450-700', 450, 700, 'Turbocharged Aftercooled', 'PT Fuel System', 'Heat Exchanger', 'Large commercial, tugboats', '1500-2100', 3400, 'EPA Tier 2'],
    ['CUM-QSK19-M', 'Cummins QSK19', 'Cummins', 'QSK19', 'QSK Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '19.0L', '660-750', 660, 750, 'Turbocharged Aftercooled', 'High Pressure Common Rail', 'Heat Exchanger', 'Supply boats, large commercial', '1500-2100', 3600, 'EPA Tier 3'],
    ['CUM-KTA38-M', 'Cummins KTA38', 'Cummins', 'KTA38', 'KTA Series', 'cummins', 'marine_propulsion', '12', 'V12', '38.0L', '850-1350', 850, 1350, 'Turbocharged Aftercooled', 'PT Fuel System', 'Heat Exchanger', 'Heavy commercial, ferries', '1500-1950', 6500, 'EPA Tier 2'],
    ['CUM-KTA50-M', 'Cummins KTA50', 'Cummins', 'KTA50', 'KTA Series', 'cummins', 'marine_propulsion', '16', 'V16', '50.0L', '1000-1800', 1000, 1800, 'Turbocharged Aftercooled', 'PT Fuel System', 'Heat Exchanger', 'Large vessels, offshore', '1500-1900', 9000, 'EPA Tier 2'],
    ['CUM-NT855-M', 'Cummins NT855', 'Cummins', 'NT855', 'NT Series', 'cummins', 'marine_propulsion', '6', 'Inline 6', '14.0L', '270-400', 270, 400, 'Turbocharged', 'PT Fuel System', 'Heat Exchanger', 'Trawlers, tugboats', '1500-2100', 2800, 'EPA Tier 1'],
    ['CUM-B45-M', 'Cummins B4.5', 'Cummins', 'B4.5', 'B Series', 'cummins', 'marine_propulsion', '4', 'Inline 4', '4.5L', '230-250', 230, 250, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Small commercial, auxiliary', '2200-2600', 850, 'EPA Tier 3'],

    // CATERPILLAR
    ['CAT-3116-M', 'Caterpillar 3116', 'Caterpillar', '3116', '3100 Series', 'caterpillar', 'marine_propulsion', '6', 'Inline 6', '6.6L', '205-350', 205, 350, 'Turbocharged Aftercooled', 'Mechanical Unit Injection', 'Heat Exchanger', 'Light commercial, workboats', '2200-2800', 1300, 'EPA Tier 1'],
    ['CAT-3126-M', 'Caterpillar 3126', 'Caterpillar', '3126', '3100 Series', 'caterpillar', 'marine_propulsion', '6', 'Inline 6', '7.2L', '225-420', 225, 420, 'Turbocharged Aftercooled', 'HEUI', 'Heat Exchanger', 'Workboats, fishing', '2200-2800', 1400, 'EPA Tier 2'],
    ['CAT-C7-M', 'Caterpillar C7', 'Caterpillar', 'C7', 'C Series', 'caterpillar', 'marine_propulsion', '6', 'Inline 6', '7.2L', '209-400', 209, 400, 'Turbocharged Aftercooled', 'HEUI', 'Heat Exchanger', 'Recreational, light commercial', '2200-2800', 1350, 'EPA Tier 3'],
    ['CAT-C9-M', 'Caterpillar C9', 'Caterpillar', 'C9', 'C Series', 'caterpillar', 'marine_propulsion', '6', 'Inline 6', '8.8L', '375-575', 375, 575, 'Turbocharged Aftercooled', 'HEUI', 'Heat Exchanger', 'Sport fishing, cruisers', '2000-2600', 1700, 'EPA Tier 3'],
    ['CAT-C12-M', 'Caterpillar C12', 'Caterpillar', 'C12', 'C Series', 'caterpillar', 'marine_propulsion', '6', 'Inline 6', '11.9L', '340-715', 340, 715, 'Turbocharged Aftercooled', 'MEUI', 'Heat Exchanger', 'Workboats, yachts', '1800-2300', 2400, 'EPA Tier 2'],
    ['CAT-C13-M', 'Caterpillar C13', 'Caterpillar', 'C13', 'C Series', 'caterpillar', 'marine_propulsion', '6', 'Inline 6', '12.5L', '520-803', 520, 803, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'High performance marine', '1800-2300', 2500, 'EPA Tier 3'],
    ['CAT-C15-M', 'Caterpillar C15', 'Caterpillar', 'C15', 'C Series', 'caterpillar', 'marine_propulsion', '6', 'Inline 6', '15.2L', '435-925', 435, 925, 'Turbocharged Aftercooled', 'MEUI', 'Heat Exchanger', 'Commercial marine, yachts', '1800-2300', 3100, 'EPA Tier 3'],
    ['CAT-3406-M', 'Caterpillar 3406', 'Caterpillar', '3406', '3400 Series', 'caterpillar', 'marine_propulsion', '6', 'Inline 6', '14.6L', '350-550', 350, 550, 'Turbocharged Aftercooled', 'Mechanical Unit Injection', 'Heat Exchanger', 'Tugboats, commercial fishing', '1800-2100', 2900, 'EPA Tier 1'],
    ['CAT-C18-M', 'Caterpillar C18', 'Caterpillar', 'C18', 'C Series', 'caterpillar', 'marine_propulsion', '6', 'Inline 6', '18.1L', '1015-1150', 1015, 1150, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Sport fishing, luxury yachts', '1800-2300', 3600, 'EPA Tier 3'],
    ['CAT-3412-M', 'Caterpillar 3412', 'Caterpillar', '3412', '3400 Series', 'caterpillar', 'marine_propulsion', '12', 'V12', '27.0L', '600-1350', 600, 1350, 'Turbocharged Aftercooled', 'Mechanical Unit Injection', 'Heat Exchanger', 'Large vessels, yachts', '1800-2300', 4500, 'EPA Tier 2'],
    ['CAT-C32-M', 'Caterpillar C32', 'Caterpillar', 'C32', 'C Series', 'caterpillar', 'marine_propulsion', '12', 'V12', '32.1L', '1450-2433', 1450, 2433, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'High performance yachts', '1800-2300', 5200, 'EPA Tier 3'],
    ['CAT-3508-M', 'Caterpillar 3508', 'Caterpillar', '3508', '3500 Series', 'caterpillar', 'marine_propulsion', '8', 'V8', '34.5L', '750-1300', 750, 1300, 'Turbocharged Aftercooled', 'Mechanical Unit Injection', 'Heat Exchanger', 'Large commercial vessels', '1200-1800', 6800, 'EPA Tier 2'],
    ['CAT-3512-M', 'Caterpillar 3512', 'Caterpillar', '3512', '3500 Series', 'caterpillar', 'marine_propulsion', '12', 'V12', '51.8L', '1100-2250', 1100, 2250, 'Turbocharged Aftercooled', 'Mechanical Unit Injection', 'Heat Exchanger', 'Large commercial, ferries', '1200-1800', 10000, 'EPA Tier 2'],
    ['CAT-3516-M', 'Caterpillar 3516', 'Caterpillar', '3516', '3500 Series', 'caterpillar', 'marine_propulsion', '16', 'V16', '69.0L', '1650-3400', 1650, 3400, 'Turbocharged Aftercooled', 'Mechanical Unit Injection', 'Heat Exchanger', 'Very large vessels', '1200-1800', 14000, 'EPA Tier 2'],

    // DETROIT DIESEL
    ['DD-6V53-M', 'Detroit Diesel 6V53', 'Detroit Diesel', '6V53', '53 Series', 'detroit-diesel', 'marine_propulsion', '6', 'V6', '5.2L', '175-280', 175, 280, 'Naturally Aspirated/Turbo', 'Unit Injection', 'Heat Exchanger', 'Light commercial, workboats', '2100-2800', 1100, ''],
    ['DD-671-M', 'Detroit Diesel 6-71', 'Detroit Diesel', '6-71', '71 Series', 'detroit-diesel', 'marine_propulsion', '6', 'Inline 6', '7.0L', '165-350', 165, 350, 'Naturally Aspirated/Turbo', 'Unit Injection', 'Heat Exchanger', 'Classic marine, workboats', '1800-2300', 2200, ''],
    ['DD-8V71-M', 'Detroit Diesel 8V71', 'Detroit Diesel', '8V71', '71 Series', 'detroit-diesel', 'marine_propulsion', '8', 'V8', '9.3L', '280-475', 280, 475, 'Turbocharged', 'Unit Injection', 'Heat Exchanger', 'Commercial fishing, workboats', '1800-2300', 2800, ''],
    ['DD-12V71-M', 'Detroit Diesel 12V71', 'Detroit Diesel', '12V71', '71 Series', 'detroit-diesel', 'marine_propulsion', '12', 'V12', '14.0L', '420-700', 420, 700, 'Turbocharged', 'Unit Injection', 'Heat Exchanger', 'Large commercial vessels', '1800-2300', 4200, ''],
    ['DD-6V92-M', 'Detroit Diesel 6V92', 'Detroit Diesel', '6V92', '92 Series', 'detroit-diesel', 'marine_propulsion', '6', 'V6', '9.0L', '270-450', 270, 450, 'Turbocharged Aftercooled', 'Unit Injection', 'Heat Exchanger', 'Fishing boats, workboats', '1800-2300', 2400, ''],
    ['DD-8V92-M', 'Detroit Diesel 8V92', 'Detroit Diesel', '8V92', '92 Series', 'detroit-diesel', 'marine_propulsion', '8', 'V8', '12.1L', '350-650', 350, 650, 'Turbocharged Aftercooled', 'Unit Injection', 'Heat Exchanger', 'Yachts, commercial marine', '1800-2300', 3200, ''],
    ['DD-12V92-M', 'Detroit Diesel 12V92', 'Detroit Diesel', '12V92', '92 Series', 'detroit-diesel', 'marine_propulsion', '12', 'V12', '18.1L', '600-1050', 600, 1050, 'Turbocharged Aftercooled', 'Unit Injection', 'Heat Exchanger', 'Large vessels, ferries', '1800-2300', 5000, ''],
    ['DD-16V92-M', 'Detroit Diesel 16V92', 'Detroit Diesel', '16V92', '92 Series', 'detroit-diesel', 'marine_propulsion', '16', 'V16', '24.1L', '800-1500', 800, 1500, 'Turbocharged Aftercooled', 'Unit Injection', 'Heat Exchanger', 'Heavy duty marine', '1800-2100', 7000, ''],
    ['DD-S60-M', 'Detroit Diesel Series 60', 'Detroit Diesel', 'Series 60', 'Series 60', 'detroit-diesel', 'marine_propulsion', '6', 'Inline 6', '12.7L', '350-600', 350, 600, 'Turbocharged Aftercooled', 'Electronic Unit Injection', 'Heat Exchanger', 'Modern commercial marine', '1800-2100', 2800, 'EPA Tier 2'],
    ['DD-DD13-M', 'Detroit Diesel DD13', 'Detroit Diesel', 'DD13', 'DD Series', 'detroit-diesel', 'marine_propulsion', '6', 'Inline 6', '12.8L', '350-525', 350, 525, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Modern commercial marine', '1600-2100', 2600, 'EPA Tier 3'],
    ['DD-DD15-M', 'Detroit Diesel DD15', 'Detroit Diesel', 'DD15', 'DD Series', 'detroit-diesel', 'marine_propulsion', '6', 'Inline 6', '14.8L', '400-600', 400, 600, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Heavy commercial marine', '1600-2100', 3000, 'EPA Tier 3'],
    ['DD-DD16-M', 'Detroit Diesel DD16', 'Detroit Diesel', 'DD16', 'DD Series', 'detroit-diesel', 'marine_propulsion', '6', 'Inline 6', '15.6L', '475-600', 475, 600, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Heavy duty marine', '1600-2100', 3200, 'EPA Tier 3'],

    // VOLVO PENTA
    ['VP-D1-M', 'Volvo Penta D1', 'Volvo Penta', 'D1', 'D Series', 'volvo-penta', 'marine_propulsion', '2', 'Inline 2', '0.5L', '13-30', 13, 30, 'Naturally Aspirated', 'Indirect Injection', 'Heat Exchanger', 'Sailboats, small craft', '2500-3600', 180, 'RCD 2'],
    ['VP-D2-M', 'Volvo Penta D2', 'Volvo Penta', 'D2', 'D Series', 'volvo-penta', 'marine_propulsion', '4', 'Inline 4', '2.2L', '50-75', 50, 75, 'Naturally Aspirated', 'Direct Injection', 'Heat Exchanger', 'Sailboats, small powerboats', '2500-3600', 400, 'RCD 2'],
    ['VP-D3-M', 'Volvo Penta D3', 'Volvo Penta', 'D3', 'D Series', 'volvo-penta', 'marine_propulsion', '5', 'Inline 5', '2.4L', '110-220', 110, 220, 'Turbocharged', 'Common Rail', 'Heat Exchanger', 'Sport boats, cruisers', '3000-4000', 550, 'RCD 2'],
    ['VP-D4-M', 'Volvo Penta D4', 'Volvo Penta', 'D4', 'D Series', 'volvo-penta', 'marine_propulsion', '4', 'Inline 4', '3.7L', '180-320', 180, 320, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Cruisers, sport fishing', '2800-3500', 700, 'EPA Tier 3'],
    ['VP-D6-M', 'Volvo Penta D6', 'Volvo Penta', 'D6', 'D Series', 'volvo-penta', 'marine_propulsion', '6', 'Inline 6', '5.5L', '300-480', 300, 480, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Sport fishing, cruisers', '2800-3500', 900, 'EPA Tier 3'],
    ['VP-D8-M', 'Volvo Penta D8', 'Volvo Penta', 'D8', 'D Series', 'volvo-penta', 'marine_propulsion', '6', 'Inline 6', '7.7L', '350-550', 350, 550, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Yachts, large cruisers', '2200-2800', 1400, 'EPA Tier 3'],
    ['VP-D11-M', 'Volvo Penta D11', 'Volvo Penta', 'D11', 'D Series', 'volvo-penta', 'marine_propulsion', '6', 'Inline 6', '10.8L', '500-725', 500, 725, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Large yachts, commercial', '1800-2300', 2200, 'EPA Tier 3'],
    ['VP-D13-M', 'Volvo Penta D13', 'Volvo Penta', 'D13', 'D Series', 'volvo-penta', 'marine_propulsion', '6', 'Inline 6', '12.8L', '700-1000', 700, 1000, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Yachts, commercial vessels', '1800-2400', 2800, 'EPA Tier 3'],

    // YANMAR
    ['YAN-1GM10-M', 'Yanmar 1GM10', 'Yanmar', '1GM10', 'GM Series', 'yanmar', 'marine_propulsion', '1', 'Single', '0.3L', '10', 10, 10, 'Naturally Aspirated', 'Direct Injection', 'Raw Water', 'Small sailboats', '3400', 88, ''],
    ['YAN-3JH40-M', 'Yanmar 3JH40', 'Yanmar', '3JH40', 'JH Series', 'yanmar', 'marine_propulsion', '3', 'Inline 3', '1.6L', '40', 40, 40, 'Naturally Aspirated', 'Direct Injection', 'Heat Exchanger', 'Sailboats', '3000-3600', 280, 'RCD 2'],
    ['YAN-4JH57-M', 'Yanmar 4JH57', 'Yanmar', '4JH57', 'JH Series', 'yanmar', 'marine_propulsion', '4', 'Inline 4', '2.2L', '57', 57, 57, 'Naturally Aspirated', 'Direct Injection', 'Heat Exchanger', 'Sailboats, small craft', '3000-3600', 370, 'RCD 2'],
    ['YAN-4JH80-M', 'Yanmar 4JH80', 'Yanmar', '4JH80', 'JH Series', 'yanmar', 'marine_propulsion', '4', 'Inline 4', '2.2L', '80', 80, 80, 'Turbocharged', 'Direct Injection', 'Heat Exchanger', 'Sailboats, motorsailers', '3000-3600', 400, 'RCD 2'],
    ['YAN-4JH110-M', 'Yanmar 4JH110', 'Yanmar', '4JH110', 'JH Series', 'yanmar', 'marine_propulsion', '4', 'Inline 4', '2.2L', '110', 110, 110, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Sailboats, small powerboats', '3000-3600', 420, 'RCD 2'],
    ['YAN-4LV150-M', 'Yanmar 4LV150', 'Yanmar', '4LV150', '4LV Series', 'yanmar', 'marine_propulsion', '4', 'Inline 4', '2.8L', '150', 150, 150, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Powerboats, cruisers', '3200-3800', 500, 'EPA Tier 3'],
    ['YAN-4LV250-M', 'Yanmar 4LV250', 'Yanmar', '4LV250', '4LV Series', 'yanmar', 'marine_propulsion', '4', 'Inline 4', '2.8L', '250', 250, 250, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Sport boats, cruisers', '3200-3800', 530, 'EPA Tier 3'],
    ['YAN-8LV370-M', 'Yanmar 8LV370', 'Yanmar', '8LV370', '8LV Series', 'yanmar', 'marine_propulsion', '8', 'V8', '5.8L', '370', 370, 370, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Sport boats, cruisers', '3200-3800', 700, 'EPA Tier 3'],
    ['YAN-6LY400-M', 'Yanmar 6LY400', 'Yanmar', '6LY400', '6LY Series', 'yanmar', 'marine_propulsion', '6', 'Inline 6', '5.8L', '400', 400, 400, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Fishing boats, cruisers', '3000-3300', 750, 'EPA Tier 3'],
    ['YAN-6LY440-M', 'Yanmar 6LY440', 'Yanmar', '6LY440', '6LY Series', 'yanmar', 'marine_propulsion', '6', 'Inline 6', '5.8L', '440', 440, 440, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Sport fishing, cruisers', '3000-3300', 760, 'EPA Tier 3'],

    // MAN
    ['MAN-D2676-M', 'MAN D2676 LE', 'MAN', 'D2676 LE', 'D26 Series', 'man', 'marine_propulsion', '6', 'Inline 6', '12.4L', '730-850', 730, 850, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Sport fishing, yachts', '1800-2300', 2400, 'EPA Tier 3'],
    ['MAN-D2868-M', 'MAN D2868 LE', 'MAN', 'D2868 LE', 'D28 Series', 'man', 'marine_propulsion', '8', 'V8', '16.2L', '1000-1200', 1000, 1200, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Yachts, fast ferries', '1800-2300', 3200, 'EPA Tier 3'],
    ['MAN-D2862-M', 'MAN D2862 LE', 'MAN', 'D2862 LE', 'D28 Series', 'man', 'marine_propulsion', '12', 'V12', '24.2L', '1400-2000', 1400, 2000, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Large yachts, commercial', '1800-2300', 4800, 'EPA Tier 3'],

    // MTU
    ['MTU-S60-M', 'MTU Series 60', 'MTU', 'Series 60', 'Series 60', 'mtu', 'marine_propulsion', '6', 'Inline 6', '7.2L', '240-480', 240, 480, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Light commercial, patrol', '1800-2600', 1400, 'EPA Tier 3'],
    ['MTU-2000-10V-M', 'MTU Series 2000 10V', 'MTU', '10V 2000', 'Series 2000', 'mtu', 'marine_propulsion', '10', 'V10', '21.9L', '1360-1920', 1360, 1920, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Yachts, patrol boats', '1800-2450', 4200, 'EPA Tier 3'],
    ['MTU-2000-12V-M', 'MTU Series 2000 12V', 'MTU', '12V 2000', 'Series 2000', 'mtu', 'marine_propulsion', '12', 'V12', '26.3L', '1600-2400', 1600, 2400, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Yachts, fast ferries', '1800-2450', 5000, 'EPA Tier 3'],
    ['MTU-2000-16V-M', 'MTU Series 2000 16V', 'MTU', '16V 2000', 'Series 2000', 'mtu', 'marine_propulsion', '16', 'V16', '35.0L', '2000-2600', 2000, 2600, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Fast ferries, patrol', '1800-2450', 6500, 'EPA Tier 3'],
    ['MTU-4000-12V-M', 'MTU Series 4000 12V', 'MTU', '12V 4000', 'Series 4000', 'mtu', 'marine_propulsion', '12', 'V12', '57.0L', '1920-3460', 1920, 3460, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Large vessels, naval', '1600-2100', 9500, 'EPA Tier 3'],
    ['MTU-4000-16V-M', 'MTU Series 4000 16V', 'MTU', '16V 4000', 'Series 4000', 'mtu', 'marine_propulsion', '16', 'V16', '76.3L', '2560-4600', 2560, 4600, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Very large vessels, naval', '1600-2100', 13000, 'EPA Tier 3'],

    // JOHN DEERE
    ['JD-4045-M', 'John Deere 4045 PowerTech', 'John Deere', '4045', 'PowerTech', 'john-deere', 'marine_propulsion', '4', 'Inline 4', '4.5L', '80-173', 80, 173, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Small commercial, auxiliary', '1800-2600', 800, 'EPA Tier 3'],
    ['JD-6068-M', 'John Deere 6068 PowerTech', 'John Deere', '6068', 'PowerTech', 'john-deere', 'marine_propulsion', '6', 'Inline 6', '6.8L', '175-325', 175, 325, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Workboats, fishing', '1800-2600', 1200, 'EPA Tier 3'],
    ['JD-6090-M', 'John Deere 6090 PowerTech', 'John Deere', '6090', 'PowerTech', 'john-deere', 'marine_propulsion', '6', 'Inline 6', '9.0L', '325-500', 325, 500, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Commercial marine', '1800-2400', 1800, 'EPA Tier 3'],
    ['JD-6135-M', 'John Deere 6135 PowerTech', 'John Deere', '6135', 'PowerTech', 'john-deere', 'marine_propulsion', '6', 'Inline 6', '13.5L', '500-650', 500, 650, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Large commercial', '1800-2200', 2600, 'EPA Tier 3'],

    // MITSUBISHI
    ['MIT-S6B3-M', 'Mitsubishi S6B3', 'Mitsubishi', 'S6B3', 'S Series', 'mitsubishi', 'marine_propulsion', '6', 'Inline 6', '11.0L', '429-543', 429, 543, 'Turbocharged Aftercooled', 'Direct Injection', 'Heat Exchanger', 'Commercial marine', '1500-1900', 2200, ''],
    ['MIT-S6R-M', 'Mitsubishi S6R', 'Mitsubishi', 'S6R', 'S Series', 'mitsubishi', 'marine_propulsion', '6', 'Inline 6', '15.0L', '630-810', 630, 810, 'Turbocharged Aftercooled', 'Direct Injection', 'Heat Exchanger', 'Large commercial', '1500-1900', 3200, ''],
    ['MIT-S12R-M', 'Mitsubishi S12R', 'Mitsubishi', 'S12R', 'S Series', 'mitsubishi', 'marine_propulsion', '12', 'V12', '30.0L', '1100-1400', 1100, 1400, 'Turbocharged Aftercooled', 'Direct Injection', 'Heat Exchanger', 'Heavy commercial', '1500-1800', 6000, ''],
    ['MIT-S16R-M', 'Mitsubishi S16R', 'Mitsubishi', 'S16R', 'S Series', 'mitsubishi', 'marine_propulsion', '16', 'V16', '40.0L', '1400-2300', 1400, 2300, 'Turbocharged Aftercooled', 'Direct Injection', 'Heat Exchanger', 'Very large vessels', '1500-1800', 8500, ''],

    // SCANIA
    ['SCA-DI13-M', 'Scania DI13', 'Scania', 'DI13', 'DI Series', 'scania', 'marine_propulsion', '6', 'Inline 6', '13.0L', '250-900', 250, 900, 'Turbocharged Aftercooled', 'Common Rail XPI', 'Heat Exchanger', 'Commercial, pleasure craft', '1800-2300', 2400, 'IMO Tier II'],
    ['SCA-DI16-M', 'Scania DI16', 'Scania', 'DI16', 'DI Series', 'scania', 'marine_propulsion', '8', 'V8', '16.0L', '750-1150', 750, 1150, 'Turbocharged Aftercooled', 'Common Rail XPI', 'Heat Exchanger', 'Heavy commercial', '1800-2300', 3200, 'IMO Tier II'],

    // PERKINS
    ['PRK-4108-M', 'Perkins 4.108', 'Perkins', '4.108', '100 Series', 'perkins', 'marine_propulsion', '4', 'Inline 4', '1.8L', '47-50', 47, 50, 'Naturally Aspirated', 'Indirect Injection', 'Raw Water', 'Sailboats, small craft', '2500-3600', 280, ''],
    ['PRK-4236-M', 'Perkins 4.236', 'Perkins', '4.236', '200 Series', 'perkins', 'marine_propulsion', '4', 'Inline 4', '3.9L', '80-85', 80, 85, 'Naturally Aspirated', 'Direct Injection', 'Heat Exchanger', 'Sailboats, small workboats', '2200-2800', 550, ''],
    ['PRK-6354-M', 'Perkins 6.354', 'Perkins', '6.354', '300 Series', 'perkins', 'marine_propulsion', '6', 'Inline 6', '5.8L', '120-185', 120, 185, 'Naturally Aspirated/Turbo', 'Direct Injection', 'Heat Exchanger', 'Workboats, trawlers', '2200-2800', 900, ''],
    ['PRK-1106-M', 'Perkins 1106', 'Perkins', '1106', '1100 Series', 'perkins', 'marine_propulsion', '6', 'Inline 6', '7.0L', '175-300', 175, 300, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Commercial marine', '1800-2400', 1100, 'EPA Tier 3'],

    // FPT / IVECO
    ['FPT-N40-M', 'FPT N40', 'FPT / Iveco', 'N40', 'N Series', 'fpt-iveco', 'marine_propulsion', '4', 'Inline 4', '3.9L', '150-250', 150, 250, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Pleasure, light commercial', '2400-3200', 650, 'EPA Tier 3'],
    ['FPT-N67-M', 'FPT N67', 'FPT / Iveco', 'N67', 'N Series', 'fpt-iveco', 'marine_propulsion', '6', 'Inline 6', '6.7L', '300-570', 300, 570, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Commercial, pleasure craft', '2400-3200', 1100, 'EPA Tier 3'],
    ['FPT-C87-M', 'FPT C87', 'FPT / Iveco', 'C87', 'C Series', 'fpt-iveco', 'marine_propulsion', '6', 'Inline 6', '8.7L', '400-600', 400, 600, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Commercial marine', '2000-2600', 1500, 'EPA Tier 3'],
    ['FPT-C13-M', 'FPT C13', 'FPT / Iveco', 'C13', 'C Series', 'fpt-iveco', 'marine_propulsion', '6', 'Inline 6', '12.9L', '500-750', 500, 750, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Heavy commercial', '1800-2300', 2400, 'EPA Tier 3'],

    // DEUTZ
    ['DTZ-BF4M1013-M', 'Deutz BF4M1013', 'Deutz', 'BF4M1013', 'BF Series', 'deutz', 'marine_auxiliary', '4', 'Inline 4', '4.8L', '100-175', 100, 175, 'Turbocharged', 'Direct Injection', 'Heat Exchanger', 'Marine auxiliary, generators', '1500-2400', 700, ''],
    ['DTZ-BF6M1013-M', 'Deutz BF6M1013', 'Deutz', 'BF6M1013', 'BF Series', 'deutz', 'marine_auxiliary', '6', 'Inline 6', '7.1L', '150-250', 150, 250, 'Turbocharged Aftercooled', 'Direct Injection', 'Heat Exchanger', 'Marine auxiliary, workboats', '1500-2400', 1000, ''],
    ['DTZ-TCD78-M', 'Deutz TCD 7.8', 'Deutz', 'TCD 7.8', 'TCD Series', 'deutz', 'marine_propulsion', '6', 'Inline 6', '7.8L', '200-350', 200, 350, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Commercial marine', '1500-2400', 1100, 'EPA Tier 3'],
    ['DTZ-TCD120-M', 'Deutz TCD 12.0', 'Deutz', 'TCD 12.0', 'TCD Series', 'deutz', 'marine_propulsion', '6', 'Inline 6', '12.0L', '350-520', 350, 520, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Large commercial', '1500-2200', 1800, 'EPA Tier 3'],

    // DOOSAN
    ['DOO-L136-M', 'Doosan L136', 'Doosan', 'L136', 'L Series', 'doosan', 'marine_propulsion', '6', 'Inline 6', '7.6L', '160-240', 160, 240, 'Turbocharged Aftercooled', 'Direct Injection', 'Heat Exchanger', 'Commercial workboats', '1800-2400', 1200, ''],
    ['DOO-V158TI-M', 'Doosan V158TI', 'Doosan', 'V158TI', 'V Series', 'doosan', 'marine_propulsion', '8', 'V8', '14.6L', '400-600', 400, 600, 'Turbocharged Aftercooled', 'Direct Injection', 'Heat Exchanger', 'Heavy commercial', '1800-2200', 2800, ''],
    ['DOO-V222TI-M', 'Doosan V222TI', 'Doosan', 'V222TI', 'V Series', 'doosan', 'marine_propulsion', '12', 'V12', '22.2L', '600-900', 600, 900, 'Turbocharged Aftercooled', 'Direct Injection', 'Heat Exchanger', 'Large commercial vessels', '1600-2000', 4500, ''],

    // LEHMAN / FORD
    ['LEH-80-M', 'Lehman 80 (4D254)', 'Lehman / Ford', '80', 'Lehman', 'lehman-ford', 'marine_propulsion', '4', 'Inline 4', '4.2L', '80', 80, 80, 'Naturally Aspirated', 'Indirect Injection', 'Heat Exchanger', 'Trawlers, sailboats', '2200-2800', 700, ''],
    ['LEH-120-M', 'Lehman 120 (6D380)', 'Lehman / Ford', '120', 'Lehman', 'lehman-ford', 'marine_propulsion', '6', 'Inline 6', '6.2L', '120', 120, 120, 'Naturally Aspirated', 'Indirect Injection', 'Heat Exchanger', 'Trawlers, cruisers', '2200-2800', 1000, ''],
    ['LEH-135-M', 'Lehman 135 (6D380T)', 'Lehman / Ford', '135', 'Lehman', 'lehman-ford', 'marine_propulsion', '6', 'Inline 6', '6.2L', '135', 135, 135, 'Turbocharged', 'Indirect Injection', 'Heat Exchanger', 'Trawlers, workboats', '2200-2800', 1050, ''],

    // BAUDOUIN
    ['BAU-6W105M-M', 'Baudouin 6W105M', 'Baudouin', '6W105M', '6W Series', 'baudouin', 'marine_propulsion', '6', 'Inline 6', '5.9L', '185-228', 185, 228, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Light commercial', '1800-2400', 900, ''],
    ['BAU-6M26-M', 'Baudouin 6M26', 'Baudouin', '6M26', '6M Series', 'baudouin', 'marine_propulsion', '6', 'Inline 6', '15.9L', '500-750', 500, 750, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Heavy commercial', '1500-2100', 2800, ''],
    ['BAU-12M26-M', 'Baudouin 12M26', 'Baudouin', '12M26', '12M Series', 'baudouin', 'marine_propulsion', '12', 'V12', '31.8L', '1000-1500', 1000, 1500, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Large commercial vessels', '1500-2100', 5500, ''],

    // HINO
    ['HIN-W06E-M', 'Hino W06E', 'Hino', 'W06E', 'W Series', 'hino', 'marine_propulsion', '6', 'Inline 6', '6.5L', '175-250', 175, 250, 'Turbocharged', 'Direct Injection', 'Heat Exchanger', 'Workboats, fishing', '1800-2600', 950, ''],
    ['HIN-P11C-M', 'Hino P11C', 'Hino', 'P11C', 'P Series', 'hino', 'marine_propulsion', '6', 'Inline 6', '10.5L', '300-450', 300, 450, 'Turbocharged Aftercooled', 'Direct Injection', 'Heat Exchanger', 'Commercial marine', '1800-2400', 1600, ''],

    // ISUZU
    ['ISZ-6HK1-M', 'Isuzu 6HK1', 'Isuzu', '6HK1', '6HK Series', 'isuzu', 'marine_propulsion', '6', 'Inline 6', '7.8L', '240-350', 240, 350, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Commercial workboats', '1800-2400', 1100, ''],
    ['ISZ-6WG1-M', 'Isuzu 6WG1', 'Isuzu', '6WG1', '6WG Series', 'isuzu', 'marine_propulsion', '6', 'Inline 6', '15.7L', '400-520', 400, 520, 'Turbocharged Aftercooled', 'Common Rail', 'Heat Exchanger', 'Heavy commercial', '1800-2200', 2400, ''],
];

echo "Inserting " . count($engines) . " engine products...\n";
$inserted = 0;
foreach ($engines as $e) {
    $slug = slugify($e[1]);
    $catId = $catIds[$e[5]] ?? null;
    $shortDesc = "Remanufactured {$e[1]} marine diesel engine. {$e[10]} HP, {$e[7]}-cylinder {$e[8]} configuration, {$e[9]} displacement. Built to OEM specifications with full warranty.";
    
    $stmt = $pdo->prepare("INSERT INTO products (sku, name, slug, brand, model, engine_series, category_id, product_type, cylinders, configuration, displacement, horsepower, horsepower_min, horsepower_max, aspiration, fuel_system, cooling_system, application, rpm_range, weight_lbs, emissions_tier, short_description, condition_type, warranty, call_for_price, in_stock, featured, is_active) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE name=VALUES(name)");
    
    try {
        $stmt->execute([
            $e[0], $e[1], $slug, $e[2], $e[3], $e[4], $catId, $e[6],
            $e[7], $e[8], $e[9], $e[10], $e[11], $e[12],
            $e[13], $e[14], $e[15], $e[16], $e[17], $e[18], $e[19],
            $shortDesc, 'remanufactured', '1-Year Unlimited Hours', 1, 1,
            ($inserted < 12 ? 1 : 0), 1
        ]);
        $inserted++;
    } catch (Exception $ex) {
        echo "  Error: {$e[1]} - " . $ex->getMessage() . "\n";
    }
}

echo "  $inserted engines inserted successfully!\n\n";
echo "=== Seeding Complete ===\n";
echo "Total Categories: " . count($categories) . "\n";
echo "Total Engines: $inserted\n";
echo "Admin Login: admin / admin123\n";
echo "Website URL: " . SITE_URL . "\n";
