<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Xoxoday\Storefront\Models\Xoproduct;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Xoproduct::all()->toArray();
        if (empty($products)) {
            $products = array(
                array(
                    'name' => 'Wildcraft Messenger Bag',
                    'description' => 'This is a Wildcraft Messenger Bag.',
                    'points' => 1000,
                    'image' => 'https://golfersshot.xoxoday.xyz/theme/assets/img/products/bag.png'
                ),
                array(
                    'name' => 'boAt Rockerz 370 Bluetooth Headphones',
                    'description' => 'This is a boAt Rockerz 370 Bluetooth Headphones.',
                    'points' => 1000,
                    'image' => 'https://golfersshot.xoxoday.xyz/theme/assets/img/products/headphone.png'
                ),
                array(
                    'name' => 'HEROZ Hammer 45 L Travel Bag',
                    'description' => 'This is a HEROZ Hammer 45 L Travel Bag.',
                    'points' => 1500,
                    'image' => 'https://golfersshot.xoxoday.xyz/theme/assets/img/products/bag2.png'
                ),
                array(
                    'name' => 'Verve Bassbox Bluetooth Speaker',
                    'description' => 'This is a Verve Bassbox Bluetooth SpeakerVerve Bassbox Bluetooth Speaker',
                    'points' => 1500,
                    'image' => 'https://golfersshot.xoxoday.xyz/theme/assets/img/products/speaker.png'
                ),
                array(
                    'name' => 'Rover Wildcraft',
                    'description' => 'This is a Rover Wildcraft bag.',
                    'points' => 2000,
                    'image' => 'https://golfersshot.xoxoday.xyz/theme/assets/img/products/bag3.png'
                ),
                array(
                    'name' => 'Noise ColorFit Pro 2',
                    'description' => 'This is Noise ColorFit Pro 2.',
                    'points' => 2000,
                    'image' => 'https://golfersshot.xoxoday.xyz/theme/assets/img/products/watch.png'
                ),
            );
            foreach ($products as $product) {
                Xoproduct::create([
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'points' => $product['points'],
                    'image' => $product['image'],
                ]);
            }
        }
    }
}
