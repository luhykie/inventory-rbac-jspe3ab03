<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use Illuminate\Database\Seeder;

class InventoryItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Cisco Catalyst 2960 Switch', 'sku' => 'NET-SW-001', 'description' => '24-port managed network switch.', 'quantity' => 8,  'unit_price' => 14500.00],
            ['name' => 'TP-Link Archer AX55 Router',  'sku' => 'NET-RT-002', 'description' => 'Dual-band Wi-Fi 6 router.',        'quantity' => 12, 'unit_price' => 4200.00],
            ['name' => 'Kingston 16GB DDR4 RAM',      'sku' => 'CMP-RM-003', 'description' => 'DDR4-3200 desktop memory module.', 'quantity' => 40, 'unit_price' => 2100.00],
            ['name' => 'Samsung 870 EVO 500GB SSD',   'sku' => 'CMP-SD-004', 'description' => '2.5-inch SATA solid state drive.', 'quantity' => 25, 'unit_price' => 3100.00],
            ['name' => 'Logitech K120 Keyboard',      'sku' => 'PER-KB-005', 'description' => 'Wired USB keyboard.',              'quantity' => 60, 'unit_price' => 550.00],
            ['name' => 'Logitech B100 Mouse',         'sku' => 'PER-MS-006', 'description' => 'Wired optical USB mouse.',         'quantity' => 60, 'unit_price' => 350.00],
            ['name' => 'AOC 24B2XH Monitor',          'sku' => 'PER-MN-007', 'description' => '23.8-inch IPS LED monitor.',       'quantity' => 18, 'unit_price' => 6500.00],
            ['name' => 'Epson L3210 Printer',         'sku' => 'PRT-PR-008', 'description' => 'All-in-one ink tank printer.',     'quantity' => 5,  'unit_price' => 9500.00],
            ['name' => 'APC 650VA UPS',               'sku' => 'PWR-UP-009', 'description' => 'Uninterruptible power supply.',    'quantity' => 15, 'unit_price' => 3800.00],
            ['name' => 'Cat6 UTP Cable (305m box)',   'sku' => 'NET-CB-010', 'description' => 'Bulk Cat6 UTP cable, one box.',    'quantity' => 6,  'unit_price' => 5200.00],
            ['name' => 'RJ45 Connectors (100 pcs)',   'sku' => 'NET-CN-011', 'description' => 'Cat6 modular plugs, pack of 100.', 'quantity' => 20, 'unit_price' => 450.00],
            ['name' => 'HDMI Cable 1.8m',             'sku' => 'PER-CB-012', 'description' => 'High-speed HDMI 2.0 cable.',       'quantity' => 35, 'unit_price' => 250.00],
        ];

        foreach ($items as $item) {
            InventoryItem::firstOrCreate(['sku' => $item['sku']], $item);
        }
    }
}
