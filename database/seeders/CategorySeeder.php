<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "name" => "Electronics",
                "description" => "Electronic items",
                "image" => "categories/electronic.jpg",
            ],
            [
                "name" => "Mobile Phone",
                "description" => "All kind of mobile phones",
                "image" => "categories/mobile.jpg",
            ],
            [
                "name" => "Jewelry & Accessories ",
                "description" => "Jewelry & Accessories items",
                "image" => "categories/jewelry.jpg",
            ],
            [
                "name" => "Computers",
                "description" => "Computer items",
                "image" => "categories/computer.jpg",
            ],
            [
                "name" => "Home Appliance",
                "description" => "Home Appliance items",
                "image" => "categories/home_appliance.jpg",
            ],
            [
                "name" => "Clothing",
                "description" => "Clothing items",
                "image" => "categories/clothing.jpg",
            ],
            [
                "name" => "Furniture",
                "description" => "Furniture items",
                "image" => "categories/furniture.jpg",
            ],
            [
                "name" => "Artworks",
                "description" => "Artworks items",
                "image" => "categories/artwork.jpg",
            ],
            [
                "name" => "Shoes",
                "description" => "Shoes items",
                "image" => "categories/shoe.jpg",
            ],
            [
                "name" => "Automotive",
                "description" => "Automotive items",
                "image" => "categories/automotive.jpg",
            ],
            [
                "name" => "Grocery",
                "description" => "Grocery items",
                "image" => "categories/grocery.jpg",
            ],
            [
                "name" => "Other",
                "description" => "Other items",
                "image" => "categories/other.jpg",
            ],
        ];

        Category::insert($data);
    }
}
