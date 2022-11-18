<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createListing([
            'name' => 'apartment',
            'location' => 'pangani',
            'price' => 10500,
        ]);

        $this->createListing([
            'name' => 'studio apartment',
            'location' => 'ngara',
            'price' => 11500,
        ]);
    }


    private function createListing($listing){
        Listing::create($listing);
    }
}
