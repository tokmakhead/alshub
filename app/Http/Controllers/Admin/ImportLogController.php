<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImportLogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $logs = \App\Models\ImportLog::with('source')->latest()->paginate(20);
        return view('admin.logs.index', compact('logs'));
    }
}
