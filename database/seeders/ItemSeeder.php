<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('items')->insert([
            ['id' => (string) Str::ulid(),'name' => 'Loveseats', 'image' => '1243345615.png', 'width' => 167.64, 'height' => 96.52, 'type' => 'Living Room', 'created_at' => '2024-10-06 06:50:29', 'updated_at' => '2024-10-06 06:50:29'],
            ['id' => (string) Str::ulid(),'name' => 'Reclining Sofas', 'image' => '1174906435.png', 'width' => 241.30, 'height' => 101.60, 'type' => 'Living Room', 'created_at' => '2024-10-06 06:51:15', 'updated_at' => '2024-10-06 06:51:15'],
            ['id' => (string) Str::ulid(),'name' => 'Rocker Recliner', 'image' => '1745177693.png', 'width' => 99.06, 'height' => 99.06, 'type' => 'Living Room', 'created_at' => '2024-10-06 06:51:57', 'updated_at' => '2024-10-06 06:51:57'],
            ['id' => (string) Str::ulid(),'name' => 'Sofas', 'image' => '1132423705.png', 'width' => 228.60, 'height' => 99.06, 'type' => 'Living Room', 'created_at' => '2024-10-06 06:48:10', 'updated_at' => '2024-10-06 06:48:10'],
            ['id' => (string) Str::ulid(),'name' => 'Wing Chairs', 'image' => '2124960037.png', 'width' => 81.28, 'height' => 88.90, 'type' => 'Living Room', 'created_at' => '2024-10-06 06:52:47', 'updated_at' => '2024-10-06 06:52:47'],

            // Bedroom type
            ['id' => (string) Str::ulid(),'name' => 'Bunk Beds', 'image' => '9486650.png', 'width' => 193.04, 'height' => 142.24, 'type' => 'Bedroom', 'created_at' => '2024-10-06 06:54:46', 'updated_at' => '2024-10-06 06:54:46'],
            ['id' => (string) Str::ulid(),'name' => 'Nightstands', 'image' => '215817956.png', 'width' => 66.04, 'height' => 45.72, 'type' => 'Bedroom', 'created_at' => '2024-10-06 06:55:57', 'updated_at' => '2024-10-06 06:55:57'],
            ['id' => (string) Str::ulid(),'name' => 'Panel Beds', 'image' => '771289725.png', 'width' => 160.02, 'height' => 210.82, 'type' => 'Bedroom', 'created_at' => '2024-10-06 06:57:21', 'updated_at' => '2024-10-06 06:57:21'],
            ['id' => (string) Str::ulid(),'name' => 'Poster Beds', 'image' => '1980902233.png', 'width' => 182.88, 'height' => 218.44, 'type' => 'Bedroom', 'created_at' => '2024-10-06 06:58:19', 'updated_at' => '2024-10-06 06:58:19'],
            ['id' => (string) Str::ulid(),'name' => 'Sleigh Beds', 'image' => '1337412148.png', 'width' => 170.18, 'height' => 228.60, 'type' => 'Bedroom', 'created_at' => '2024-10-06 06:59:04', 'updated_at' => '2024-10-06 06:59:04'],
            
            ['id' => (string) Str::ulid(),'name' => 'Dining Arm Chairs', 'image' => '1595380367.png', 'width' => 63.50, 'height' => 60.96, 'type' => 'Dining Room', 'created_at' => '2024-10-06 07:03:19', 'updated_at' => '2024-10-06 07:03:19'],
            ['id' => (string) Str::ulid(),'name' => 'Dining Side Chairs', 'image' => '396017649.png', 'width' => 50.80, 'height' => 55.80, 'type' => 'Dining Room', 'created_at' => '2024-10-06 07:04:10', 'updated_at' => '2024-10-06 08:06:22'],
            ['id' => (string) Str::ulid(),'name' => 'Dining Tables', 'image' => '1781466465.png', 'width' => 134.62, 'height' => 147.32, 'type' => 'Dining Room', 'created_at' => '2024-10-06 07:05:08', 'updated_at' => '2024-10-06 07:05:08'],
            ['id' => (string) Str::ulid(),'name' => 'Pub Tables', 'image' => '2126708219.png', 'width' => 114.30, 'height' => 119.38, 'type' => 'Dining Room', 'created_at' => '2024-10-06 07:05:50', 'updated_at' => '2024-10-06 07:05:50'],
            ['id' => (string) Str::ulid(),'name' => 'Servers', 'image' => '202785245.png', 'width' => 307.34, 'height' => 50.80, 'type' => 'Dining Room', 'created_at' => '2024-10-06 07:06:26', 'updated_at' => '2024-10-06 07:06:26'],
            
            ['id' => (string) Str::ulid(),'name' => 'Closed Bookcases', 'image' => '1202722276.png', 'width' => 101.60, 'height' => 40.64, 'type' => 'Home Office', 'created_at' => '2024-10-06 07:07:48', 'updated_at' => '2024-10-06 07:07:48'],
            ['id' => (string) Str::ulid(),'name' => 'Desk Hutch Sets', 'image' => '116396946.png', 'width' => 139.70, 'height' => 63.50, 'type' => 'Home Office', 'created_at' => '2024-10-06 07:09:01', 'updated_at' => '2024-10-06 07:09:01'],
            ['id' => (string) Str::ulid(),'name' => 'Open Bookcases', 'image' => '362099337.png', 'width' => 86.36, 'height' => 35.56, 'type' => 'Home Office', 'created_at' => '2024-10-06 07:09:43', 'updated_at' => '2024-10-06 07:09:43'],
            ['id' => (string) Str::ulid(),'name' => 'Single Pedestal Desks', 'image' => '530986763.png', 'width' => 124.46, 'height' => 55.88, 'type' => 'Home Office', 'created_at' => '2024-10-06 07:10:50', 'updated_at' => '2024-10-06 07:10:50'],
            ['id' => (string) Str::ulid(),'name' => 'Table Desks', 'image' => '847214268.png', 'width' => 127.00, 'height' => 66.04, 'type' => 'Home Office', 'created_at' => '2024-10-06 07:11:28', 'updated_at' => '2024-10-06 07:11:28'],
            
            ['id' => (string) Str::ulid(),'name' => 'Rugs', 'image' => '263639812.png', 'width' => 228.60, 'height' => 154.94, 'type' => 'Miscellaneous', 'created_at' => '2024-10-06 07:12:04', 'updated_at' => '2024-10-06 07:12:04'],
            ['id' => (string) Str::ulid(),'name' => 'Door Opens Left', 'image' => '2062599889.png', 'width' => 91.44, 'height' => 70.00, 'type' => 'Structural', 'created_at' => '2024-10-06 07:13:43', 'updated_at' => '2024-10-06 08:03:37'],
            ['id' => (string) Str::ulid(),'name' => 'Door Opens Right', 'image' => '366401021.png', 'width' => 91.44, 'height' => 70.00, 'type' => 'Structural', 'created_at' => '2024-10-06 07:13:58', 'updated_at' => '2024-10-06 08:03:56'],
            ['id' => (string) Str::ulid(),'name' => 'French Doors', 'image' => '1861061313.png', 'width' => 203.20, 'height' => 91.44, 'type' => 'Structural', 'created_at' => '2024-10-06 07:15:03', 'updated_at' => '2024-10-06 07:15:03'],
            ['id' => (string) Str::ulid(),'name' => 'Fireplace', 'image' => '23175773.png', 'width' => 132.08, 'height' => 22.86, 'type' => 'Structural', 'created_at' => '2024-10-06 07:15:48', 'updated_at' => '2024-10-06 07:15:48'],
            
            ['id' => (string) Str::ulid(),'name' => 'Sliding Doors', 'image' => '652179417.png', 'width' => 203.20, 'height' => 12.70, 'type' => 'Structural', 'created_at' => '2024-10-06 07:16:36', 'updated_at' => '2024-10-06 07:16:36'],
            ['id' => (string) Str::ulid(),'name' => 'Window', 'image' => '1210572537.png', 'width' => 139.70, 'height' => 7.62, 'type' => 'Structural', 'created_at' => '2024-10-06 07:17:14', 'updated_at' => '2024-10-06 07:17:14'],
            ['id' => (string) Str::ulid(),'name' => 'Toilets', 'image' => '596380351.png', 'width' => 30.50, 'height' => 73.50, 'type' => 'Bathroom', 'created_at' => '2024-10-06 07:36:02', 'updated_at' => '2024-10-06 07:36:02'],
            ['id' => (string) Str::ulid(),'name' => 'Pedestal Sinks', 'image' => '178413739.png', 'width' => 55.80, 'height' => 87.00, 'type' => 'Bathroom', 'created_at' => '2024-10-06 07:42:14', 'updated_at' => '2024-10-06 07:42:14'],
            ['id' => (string) Str::ulid(),'name' => 'Bathtubs', 'image' => '1375049375.png', 'width' => 170.00, 'height' => 75.00, 'type' => 'Bathroom', 'created_at' => '2024-10-06 07:44:11', 'updated_at' => '2024-10-06 07:44:11'],
            
            ['id' => (string) Str::ulid(),'name' => 'Ovens', 'image' => '768782455.png', 'width' => 91.40, 'height' => 95.30, 'type' => 'Kitchen', 'created_at' => '2024-10-06 07:49:13', 'updated_at' => '2024-10-06 07:52:56'],
            ['id' => (string) Str::ulid(),'name' => 'Sinks', 'image' => '674100858.png', 'width' => 106.30, 'height' => 50.80, 'type' => 'Kitchen', 'created_at' => '2024-10-06 07:54:11', 'updated_at' => '2024-10-06 07:54:11'],
            ['id' => (string) Str::ulid(),'name' => 'Refrigerators', 'image' => '540764304.png', 'width' => 60.96, 'height' => 152.40, 'type' => 'Kitchen', 'created_at' => '2024-10-06 07:55:33', 'updated_at' => '2024-10-06 07:58:10'],
            ['id' => (string) Str::ulid(),'name' => 'Partitions', 'image' => '141703244.png', 'width' => 100.00, 'height' => 7.62, 'type' => 'Structural', 'created_at' => '2024-10-06 08:00:35', 'updated_at' => '2024-10-06 08:01:51'],
            ['id' => (string) Str::ulid(),'name' => 'Queen Beds', 'image' => '254019203.jpg', 'width' => 152.00, 'height' => 190.00, 'type' => 'Bedroom', 'created_at' => '2024-10-06 09:12:38', 'updated_at' => '2024-10-06 09:27:28'],
            ['id' => (string) Str::ulid(),'name' => 'King Beds', 'image' => '633048086.jpg', 'width' => 182.00, 'height' => 198.00, 'type' => 'Bedroom', 'created_at' => '2024-10-06 09:14:53', 'updated_at' => '2024-10-06 09:28:08'],
            ['id' => (string) Str::ulid(),'name' => 'Double Beds', 'image' => '122449278.jpg', 'width' => 120.00, 'height' => 190.00, 'type' => 'Bedroom', 'created_at' => '2024-10-06 09:16:30', 'updated_at' => '2024-10-06 09:28:31'],
            ['id' => (string) Str::ulid(),'name' => 'Single Beds', 'image' => '840872244.jpg', 'width' => 91.00, 'height' => 190.00, 'type' => 'Bedroom', 'created_at' => '2024-10-06 09:19:51', 'updated_at' => '2024-10-06 09:27:43'],
            ['id' => (string) Str::ulid(),'name' => 'Twin Beds', 'image' => '428510373.jpg', 'width' => 96.52, 'height' => 190.00, 'type' => 'Bedroom', 'created_at' => '2024-10-06 09:24:12', 'updated_at' => '2024-10-06 09:30:21'],
        ]);
    }
}
