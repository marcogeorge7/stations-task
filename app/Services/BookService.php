<?php

namespace App\Services;

use App\Models\Book;
use App\Models\TripStation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class BookService
{

    public function tripsList($request): array
    {
        $startPoint = $request['from_id'] ?? 0;
        $endPoint = $request['end_id'] ?? 0;
        $travelDay = $request['date'] ?? date('d-m-Y');


        // get all trips from and to
        $trips = TripStation::with('destination', 'trip')->whereDate('reach_time', Carbon::parse($travelDay))->where('station_id', $startPoint)->get()
            ->filter(function ($trip) use ($endPoint) {
                $trip->destination = $trip->destination->where('stage', ">", $trip->stage)->where('station_id', $endPoint)->first();
                return !empty($trip->destination);
            });

        $availableSeats = [];

        foreach ($trips as $trip) {

            $availability = $this->checkBook($trip, $trip->destination);
            $availableSeats[$trip->trip_id]['seats'] = $availability;
            $availableSeats[$trip->trip_id]['trip'] = $trip->trip;
            $availableSeats[$trip->trip_id]['start'] = $trip;
            $availableSeats[$trip->trip_id]['end'] = $trip->destination;

        }

        return $availableSeats;
    }


    public function store($data): JsonResponse
    {
        $check = Book::query()->where($data)->exists();

        if ($check) return response()->json(['status' => 'failed', 'message' => 'seat already booked'], 409);

        $availability = TripStation::query()->where('trip_id', $data['trip_id'])->whereIn('station_id', [$data['start'], $data['end']])->get();

        $start = TripStation::with('trip')->find($data['start']);
        $end = TripStation::query()->find($data['end']);
        $availableSeats = $this->checkBook($start, $end);

        if (!$availability || !in_array($data['seat_number'], $availableSeats)) return response()->json(['status' => 'failed', 'message' => 'seat cant be booked'], 406);


        $book = Book::query()->create($data);

        return response()->json(['status' => 'success', 'data' => $book], 201);

    }

    public function checkBook($start, $end): array
    {
        if ($end->stage < $start->stage) return [];

        $getBookedSeats = Book::query()->whereHas('startStation', function ($q) use ($start, $end) {
            $q->whereBetween('trip_stations.stage', [$start->stage, $end->stage]);
        })->whereHas('endStation', function ($q) use ($start, $end) {
            $q->whereBetween('trip_stations.stage', [$start->stage, $end->stage]);
        })->where('books.trip_id', $start->trip_id)->pluck('seat_number')->toArray();

        $allSeats = range(1, $start->trip->seats);

        return array_diff($allSeats, $getBookedSeats);
    }

}
