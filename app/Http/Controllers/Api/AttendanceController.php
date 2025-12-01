<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Date;

class AttendanceController extends Controller
{
    //checkin
    public function checkin(Request $request)
    {
    //validate latitude & longitude
    $request->validate([
    'latitude' => 'required',
    'longitude' => 'required',
    ]);

    //save attendance
    $attendance = new Attendance;
    $attendance->user_id = $request->user()->id;
    $attendance->date = Carbon::now('Asia/Makassar')->format('Y-m-d');
    $attendance->time_in = Carbon::now('Asia/Makassar')->format('H:i:s');
    $attendance->latlon_in = $request->latitude . ',' . $request->longitude;
    $attendance->save();

    return response(['message' => 'Checkin success', 'attendance' => $attendance], 200);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $attendance = Attendance::where('user_id', $request->user()->id)->where('date', date('Y-m-d'))->first();

        if(!$attendance) {
            return response(['message' => 'Checkin First'], 400);
        }

        //save checkout
        $attendance->time_out = Carbon::now('Asia/Makassar')->format('H:i:s');
        $attendance->latlon_out = $request->latitude . ',' . $request->longitude;
        $attendance->save();

        return response(['message' => 'Checkout Success', 'attendance' => $attendance], 200);
    }

    // check is-checked in
    public function isCheckedin(Request $request)
    {
        $attendance = Attendance::where('user_id', $request->user()->id)->where('date', date('Y-m-d'))->first();

        return response([
            'checkedin' => $attendance ? true : false,
            'attendance' => $attendance
        ], 200);
    }
}
