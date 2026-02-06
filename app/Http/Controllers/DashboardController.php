<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMember;
use App\Models\LabEquipment;
use App\Models\Product;
use App\Models\ProcessFlow;
use App\Models\Document;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'team' => TeamMember::count(),
            'equipment' => LabEquipment::count(),
            'products' => Product::count(),
            'flows' => ProcessFlow::count(),
            'documents' => Document::count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
