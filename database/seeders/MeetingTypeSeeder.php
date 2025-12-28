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
        $today = now()->startOfDay();
        $meetings = Meeting::all();
        $i = 0;
        foreach ($meetings as $meeting) {
            $meeting->type = $types[$i % count($types)];
            $meeting->scheduled_at = $today->copy()->addDays($i % 5)->setHour(10 + ($i % 6))->setMinute(0);
            $meeting->save();
            $i++;
        }
    }
}
