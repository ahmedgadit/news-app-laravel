<?php

namespace Database\Seeders;

use App\Enums\SourceEnum;
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
                'name' => SourceEnum::GuardianNews,
                'source_uuid' => SourceEnum::GuardianUUID,
            ],
            [
                'name' => SourceEnum::NewYourTimes,
                'source_uuid' => SourceEnum::NewYorkTimesUUID,
            ]
        ];

        foreach ($sources as $source) {
            Sources::updateOrCreate(['source_uuid' => $source['source_uuid']],$source);
        }
    }
}
