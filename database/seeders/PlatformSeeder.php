<?php

namespace Database\Seeders;

use App\Enums\SourceEnum;
use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            [
                'name' => SourceEnum::GuardianNews,
                'platform_uuid' => SourceEnum::GuardianUUID,
            ],
            [
                'name' => SourceEnum::NewYourTimes,
                'platform_uuid' => SourceEnum::NewYorkTimesUUID,
            ],
            [
                'name' => SourceEnum::NewsOrg,
                'platform_uuid' => SourceEnum::NewsOrgUUID,
            ],
        ];

        foreach ($platforms as $platform) {
            Platform::updateOrCreate(['platform_uuid' => $platform['platform_uuid']], $platform);
        }
    }
}
