<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Station;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\Trip::query()->insert([
            [
                'title' => "VIP",
                'seats' => 12,
                'start_at' => Carbon::parse('today 1pm'),
            ], [
                'title' => "VIP",
                'seats' => 12,
                'start_at' => Carbon::now()->addDay(),
            ], [
                'title' => "Fast",
                'seats' => 12,
                'start_at' => Carbon::now()->addHours(2),
            ],
        ]);

        \App\Models\Station::query()->insert([
            ['title' => "Cairo"],
            ['title' => "Giza"],
            ['title' => "AlFayyum"],
            ['title' => "AlMinya"],
            ['title' => "Asyut"],
            ['title' => "Luxor"],
            ['title' => "Aswan"],
            ['title' => "Shalateen"],
            ['title' => "Halayeb"],
        ]);

        $x = 1;
        foreach (Station::all() ?? [] as $station) {
            $trip = Trip::query()->find(1);
            $trip->tripStations()->updateOrCreate([
                'station_id' => $station->id,
                'stage' => $x,
                'reach_time' => $trip->start_at->addHours($x - 1)
            ]);
            $x++;
        }

        $time = Carbon::parse('tomorrow 1pm');
        $x = 1;
        foreach (Station::all()->sortByDesc('id') ?? [] as $station) {
            $trip = Trip::query()->find(2);
            $trip->tripStations()->updateOrCreate([
                'station_id' => $station->id,
                'stage' => $x,
                'reach_time' => $time->addHours($x - 1)
            ]);
            $x++;
        }
    }
}
