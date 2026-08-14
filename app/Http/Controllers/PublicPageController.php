<?php

namespace App\Http\Controllers;

use App\Models\Room;

class PublicPageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'rooms' => Room::query()->latest()->take(3)->get(),
            'currentTab' => 'home',
        ]);
    }

    public function catalog()
    {
        return view('pages.catalog', [
            'rooms' => Room::query()->latest()->get(),
            'currentTab' => 'catalog',
        ]);
    }

    public function about()
    {
        return view('pages.about', ['currentTab' => 'about']);
    }

    public function show(Room $room)
    {
        $room->increment('views');

        return view('pages.room_detail', [
            'room' => $room->fresh(),
            'currentTab' => 'catalog',
        ]);
    }
}
