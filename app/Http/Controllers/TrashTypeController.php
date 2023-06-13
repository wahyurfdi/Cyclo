<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrashType;

class TrashTypeController extends Controller
{
    public function index()
    {
        $trashTypes = TrashType::get();

        return view('cms.master.trash-type', compact('trashTypes'));
    }
}
