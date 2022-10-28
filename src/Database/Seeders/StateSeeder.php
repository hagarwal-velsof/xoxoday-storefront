<?php

namespace Xoxoday\Storefront\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Xoxoday\Storefront\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $indian_all_states  = array (
            'AP' => 'Andhra Pradesh',
            'AR' => 'Arunachal Pradesh',
            'AS' => 'Assam',
            'BR' => 'Bihar',
            'CT' => 'Chhattisgarh',
            'GA' => 'Goa',
            'GJ' => 'Gujarat',
            'HR' => 'Haryana',
            'HP' => 'Himachal Pradesh',
            'JK' => 'Jammu & Kashmir',
            'JH' => 'Jharkhand',
            'KA' => 'Karnataka',
            'KL' => 'Kerala',
            'MP' => 'Madhya Pradesh',
            'MH' => 'Maharashtra',
            'MN' => 'Manipur',
            'ML' => 'Meghalaya',
            'MZ' => 'Mizoram',
            'NL' => 'Nagaland',
            'OR' => 'Odisha',
            'PB' => 'Punjab',
            'RJ' => 'Rajasthan',
            'SK' => 'Sikkim',
            'TN' => 'Tamil Nadu',
            'TR' => 'Tripura',
            'UK' => 'Uttarakhand',
            'UP' => 'Uttar Pradesh',
            'WB' => 'West Bengal',
            'AN' => 'Andaman & Nicobar',
            'CH' => 'Chandigarh',
            'DN' => 'Dadra and Nagar Haveli',
            'DD' => 'Daman & Diu',
            'DL' => 'Delhi',
            'LD' => 'Lakshadweep',
            'PY' => 'Puducherry',
        );
        foreach($indian_all_states as $key => $value){
            State::create([
                'name' => $value,
                'status' => 1,
            ]);
        }
    }
}
