<?php

namespace Modules\WebResources\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\WebResources\Models\WebResource;

class WebResourceTableSeeder extends Seeder
{
    public function run(): void
    {
        $resources = [
            [
                'address_site_1' => 'https://www.google.com',
                'address_site_2' => 'https://yandex.by',
                'address_site_3' => 'https://www.youtube.com',
                'address_video' => 'EJr3uAQwGek',
                'active' => false
            ],
            [
                'address_site_1' => 'https://old.belgie.by/test_ETSI_kepler/mob/index.html',
                'address_site_2' => 'http://onliner.by',
                'address_site_3' => 'https://www.mpt.gov.by/',
                'address_video' => '2E93KHqU2s4',
                'active' => true
            ],
        ];

        foreach ($resources as $resource) {
            WebResource::create($resource);
        }
    }
}
