<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking Form</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding: 30px 0;
        }

        .glass-card {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.35);
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: 0.4s;
        }

        .glass-card:hover {
            transform: translateY(-6px);
        }

        h2 {
            font-weight: 700;
            color: #3b3b3b;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
        }

        .btn-submit {
            background: linear-gradient(120deg, #6c5ce7, #9f8eff);
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-size: 16px;
            color: #fff;
            transition: .3s;
        }

        .btn-submit:hover {
            transform: scale(1.03);
        }

        /* Scrollable table fix */
        .scroll-table {
            max-height: 350px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(10px);
        }

        thead {
            position: sticky;
            top: 0;
            background: #6c5ce7;
            color: #fff;
            z-index: 10;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Form Section -->
        <div class="glass-card mb-5">
            <h2 class="text-center mb-4"><i class="fa-solid fa-door-open"></i> Room Booking</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('booking.submit') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Room Name</label>
                        <input type="text" class="form-control" name="room_name" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Booked From</label>
                        <input type="datetime-local" class="form-control" name="booked_from" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Booked To</label>
                        <input type="datetime-local" class="form-control" name="booked_to" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Booking Created On</label>
                        <input type="datetime-local" class="form-control" name="booking_created_on" required>
                    </div>
                </div>

                <button class="btn-submit w-100 mt-4">
                    <i class="fa-solid fa-paper-plane"></i> Submit Booking
                </button>
            </form>
        </div>

        <!-- Scrollable Table Section -->
        <div class="glass-card">
            <h2 class="text-center mb-4"><i class="fa-solid fa-table"></i> Booked Room</h2>

            <div class="scroll-table">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Room Name</th>
                            <th>Booked From</th>
                            <th>Booked To</th>
                            <th>Created On</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $booking['room_name'] }}</td>
                                <td>
                                    <span
                                        class="date-time">{{ \Carbon\Carbon::parse($booking['booked_from'])->format('Y-m-d') }}</span>
                                    <span
                                        class="date-time">{{ \Carbon\Carbon::parse($booking['booked_from'])->format('H:i') }}</span>
                                </td>

                                <td>
                                    <span
                                        class="date-time">{{ \Carbon\Carbon::parse($booking['booked_to'])->format('Y-m-d') }}</span>
                                    <span
                                        class="date-time">{{ \Carbon\Carbon::parse($booking['booked_to'])->format('H:i') }}</span>
                                </td>

                                <td>
                                    <span
                                        class="date-time">{{ \Carbon\Carbon::parse($booking['booking_created_on'])->format('Y-m-d') }}</span>
                                    <span
                                        class="date-time">{{ \Carbon\Carbon::parse($booking['booking_created_on'])->format('H:i') }}</span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
