<?php

namespace Database\Seeders;

use App\Enums\SourceEnum;
use App\Models\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
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
            Source::updateOrCreate(['source_uuid' => $source['source_uuid']], $source);
        }
    }
}
