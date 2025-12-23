<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meeting;

class MeetingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['physical', 'video', 'audio', 'chats'];

        // Update all existing meetings with a random type
        $meetings = Meeting::all();
        foreach ($meetings as $meeting) {
            $meeting->type = $types[array_rand($types)];
            $meeting->save();
        }
    }
}
