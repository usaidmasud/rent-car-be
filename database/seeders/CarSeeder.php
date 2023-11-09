<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                "merk" => "toyota",
                "model" => "avanza",
                "photo" => "mobil-toyota-avanza.jpg",
                "plat_number" => "DR1010DK",
                "rental_fee" => 150000,
                "is_rent" => 0,
            ],
            [
                "merk" => "toyota",
                "model" => "calya",
                "photo" => "mobil-toyota-calya.jpg",
                "plat_number" => "DR1020DK",
                "rental_fee" => 125000,
                "is_rent" => 0,
            ],
            [
                "merk" => "toyota",
                "model" => "corolla",
                "photo" => "mobil-toyota-corolla.jpg",
                "plat_number" => "DR1030DK",
                "rental_fee" => 135000,
                "is_rent" => 0,
            ],
            [
                "merk" => "toyota",
                "model" => "fortuner",
                "photo" => "mobil-toyota-fortuner.jpg",
                "plat_number" => "DR1040DK",
                "rental_fee" => 170000,
                "is_rent" => 0,
            ],
            [
                "merk" => "toyota",
                "model" => "innova",
                "photo" => "mobil-toyota-innova.jpg",
                "plat_number" => "DR1050DK",
                "rental_fee" => 180000,
                "is_rent" => 0,
            ],
            [
                "merk" => "toyota",
                "model" => "raize",
                "photo" => "mobil-toyota-raize.jpg",
                "plat_number" => "DR1060DK",
                "rental_fee" => 150000,
                "is_rent" => 0,
            ],
            [
                "merk" => "toyota",
                "model" => "rush",
                "photo" => "mobil-toyota-rush.jpg",
                "plat_number" => "DR1070DK",
                "rental_fee" => 200000,
                "is_rent" => 0,
            ],
            [
                "merk" => "toyota",
                "model" => "sienta",
                "photo" => "mobil-toyota-sienta.jpg",
                "plat_number" => "DR1090DK",
                "rental_fee" => 150000,
                "is_rent" => 0,
            ],
            [
                "merk" => "toyota",
                "model" => "voxy",
                "photo" => "mobil-toyota-voxy.jpg",
                "plat_number" => "DR1080DK",
                "rental_fee" => 2550000,
                "is_rent" => 0,
            ],
            [
                "merk" => "toyota",
                "model" => "yaris",
                "photo" => "mobil-toyota-yaris.jpg",
                "plat_number" => "DR2010DK",
                "rental_fee" => 275000,
                "is_rent" => 0,
            ],
        ];
        foreach ($cars as $key) {
            Car::create($key);
        }
    }
}
