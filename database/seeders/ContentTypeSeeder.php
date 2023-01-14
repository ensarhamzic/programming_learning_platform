<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContentType;

class ContentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contentTypes = [
            [
                'name' => 'video',
            ],
            [
                'name' => 'pdf',
            ],
            [
                'name' => 'document',
            ],
            [
                'name' => 'presentation',
            ],
            [
                'name' => 'zip',
            ]
        ];

        foreach ($contentTypes as $contentType) {
            ContentType::create($contentType);
        }
    }
}
