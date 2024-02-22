<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Events\BookingCreated;
use App\Events\BookingCanceled;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index()
    {
        return Booking::with(['room', 'customer'])->get();
    }

    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'customer_id' => 'required|exists:customers,id',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date|after:check_in_date',
                'total_price' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            throw $e;
        }


        if (!$this->isRoomAvailable($validated['room_id'], $validated['check_in_date'], $validated['check_out_date'])) {

            return response()->json(['message' => 'The room is not available for the selected dates.'], 422);
        }

        $booking = Booking::create($validated);
        BookingCreated::dispatch($booking);

        return response()->json($booking, 201);
    }


    private function isRoomAvailable($roomId, $checkInDate, $checkOutDate): bool
    {
        $existingBookings = Booking::where('room_id', $roomId)
                            ->where(function (Builder $query) use ($checkInDate, $checkOutDate) {

                                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                                      ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                                      ->orWhere(function (Builder $query) use ($checkInDate, $checkOutDate) {
                                          $query->where('check_in_date', '<', $checkInDate)
                                                ->where('check_out_date', '>', $checkOutDate);
                                      });
                            })->exists();

        return !$existingBookings;
    }

    public function cancelBooking(Request $request, $bookingId)
    {
        try {
            $booking = Booking::findOrFail($bookingId);
            $booking->update(['status' => 'canceled']);
            BookingCanceled::dispatch($booking);

            return response()->json(['message' => 'Booking canceled successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error canceling booking: ' . $e->getMessage());
            return response()->json(['message' => 'Error canceling booking.'], 500);
        }
    }

    public function deleteBooking(Request $request, $bookingId)
    {
        try {
            $booking = Booking::findOrFail($bookingId);
            $booking->delete();

            return response()->json(['message' => 'Booking deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting booking: ' . $e->getMessage());
            return response()->json(['message' => 'Error deleting booking.'], 500);
        }
    }
}
