<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request){
        return ActivityLog::with('user')
            ->latest()
            ->take(50)
            ->get();
    }
}
