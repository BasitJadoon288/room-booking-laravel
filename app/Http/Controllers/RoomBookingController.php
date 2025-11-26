<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class RoomBookingController extends Controller
{
    private $apiBaseUrl = 'https://cts02.cremsenplayer.com:351/api/RoomBooking';

public function index()
{
    try {

        // GET API
        $response = Http::withOptions(['verify' => false])
                        ->get($this->apiBaseUrl . '/get');

        // Agar API 200 return kare
        if ($response->successful()) {
            $rawBookings = $response->json();  // Response array mil jayega
        } else {
            $rawBookings = [];
        }

        // Normalize keys (Laravel blade me room_name use hoga)
        $bookings = collect($rawBookings)->map(function($b) {
            return [
                'room_name' => $b['room_Name'] ?? null, // API key ko correct name me map
                'booked_from' => $b['booked_from'] ?? null,
                'booked_to' => $b['booked_to'] ?? null,
                'booking_created_on' => $b['booking_created_on'] ?? null,
            ];
        })->toArray();

    } catch (\Exception $e) {
        $bookings = [];
    }

    return view('roombooking', compact('bookings'));
}


    // Handle form submission
    public function submit(Request $request)
    {
        // Validate form data
        $request->validate([
            'room_name' => 'required|string',
            'booked_from' => 'required|date',
            'booked_to' => 'required|date',
            'booking_created_on' => 'required|date'
        ]);

        $data = $request->only(['room_name', 'booked_from', 'booked_to', 'booking_created_on']);

        try {
            // POST API call
            $postData = [
                'room_Name' => $data['room_name'], // API expects capital N
                'booked_from' => $data['booked_from'],
                'booked_to' => $data['booked_to'],
                'booking_created_on' => $data['booking_created_on']
            ];

            $response = Http::withOptions(['verify' => false])->post($this->apiBaseUrl . '/add', $postData);

            if ($response->successful()) {
                return redirect()->route('booking.index')->with('success', 'Room booked successfully!');
            } else {
                return redirect()->route('booking.index')->with('error', 'API Error: ' . $response->body());
            }

        } catch (\Exception $e) {
            return redirect()->route('booking.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
