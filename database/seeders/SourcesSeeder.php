<?php

namespace Database\Seeders;

use App\Models\Sources;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            [
                'name' => 'The Guardian News',
                'source_uuid' => 'guardian-news',
            ],
            [
                'name' => 'New York Times',
                'source_uuid' => 'new-york-times',
            ]
        ];

        foreach ($sources as $source) {
            Sources::createOrUpdate(['source_uuid' => $source['source_uuid']],$source);
        }
    }
}
