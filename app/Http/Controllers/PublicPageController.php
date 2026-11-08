<?php

namespace App\Http\Controllers;

use App\Models\Room;

class PublicPageController extends Controller
{
    public function home()
    {
        $rooms = Room::query()->select(Room::SUMMARY_COLUMNS)->orderBy('id')->take(3)->get();
        if (Room::normalizeIfGapped($rooms)) {
            $rooms = Room::query()->select(Room::SUMMARY_COLUMNS)->orderBy('id')->take(3)->get();
        }

        return view('pages.home', [
            'rooms' => $rooms,
            'currentTab' => 'home',
        ]);
    }

    public function catalog()
    {
        $rooms = Room::query()->select(Room::SUMMARY_COLUMNS)->orderBy('id')->get();
        if (Room::normalizeIfGapped($rooms)) {
            $rooms = Room::query()->select(Room::SUMMARY_COLUMNS)->orderBy('id')->get();
        }

        return view('pages.catalog', [
            'rooms' => $rooms,
            'currentTab' => 'catalog',
        ]);
    }

    public function about()
    {
        return view('pages.about', ['currentTab' => 'about']);
    }

    public function show(string $room)
    {
        $resolvedRoom = null;

        if (ctype_digit($room)) {
            $roomId = (int) $room;
            $resolvedRoom = Room::query()->find($roomId);

            // Fallback resolution & normalization only when a room ID is missing/skipped
            if (! $resolvedRoom && $roomId > 0) {
                Room::normalizeSequentialIds();
                $resolvedRoom = Room::query()->find($roomId);

                if (! $resolvedRoom) {
                    $allRooms = Room::query()->orderBy('id')->get()->values();
                    if ($roomId <= $allRooms->count()) {
                        $resolvedRoom = $allRooms->get($roomId - 1);
                    } elseif ($allRooms->count() >= 2 && $roomId === $allRooms->count() + 1) {
                        $resolvedRoom = $allRooms->last();
                    }
                }
            }
        }

        if (! $resolvedRoom) {
            abort(404);
        }

        $sessionKey = 'viewed_room_' . $resolvedRoom->id;
        $lastViewed = session($sessionKey);

        // Prevent view-spamming & DB write flooding: only increment once per 30 minutes per session
        if (! $lastViewed || (now()->timestamp - (int) $lastViewed) > 1800) {
            $resolvedRoom->increment('views');
            session([$sessionKey => now()->timestamp]);
        }

        return view('pages.room_detail', [
            'room' => $resolvedRoom,
            'currentTab' => 'catalog',
        ]);
    }

    public function trackWaClick(string $room)
    {
        $resolvedRoom = null;
        if (ctype_digit($room)) {
            $roomId = (int) $room;
            $resolvedRoom = Room::query()->select(['id', 'wa_clicks'])->find($roomId);

            if (! $resolvedRoom && $roomId > 0) {
                Room::normalizeSequentialIds();
                $resolvedRoom = Room::query()->select(['id', 'wa_clicks'])->find($roomId);

                if (! $resolvedRoom) {
                    $allRooms = Room::query()->select(['id', 'wa_clicks'])->orderBy('id')->get()->values();
                    if ($roomId <= $allRooms->count()) {
                        $resolvedRoom = $allRooms->get($roomId - 1);
                    } elseif ($allRooms->count() >= 2 && $roomId === $allRooms->count() + 1) {
                        $resolvedRoom = $allRooms->last();
                    }
                }
            }
        }

        if (! $resolvedRoom) {
            return response()->json(['ok' => false], 404);
        }

        $sessionKey = 'wa_clicked_room_' . $resolvedRoom->id;
        $lastClicked = session($sessionKey);

        // Anti-spam: count at most 1 WA click per 10 minutes per session per room
        if (! $lastClicked || (now()->timestamp - (int) $lastClicked) > 600) {
            $resolvedRoom->increment('wa_clicks');
            session([$sessionKey => now()->timestamp]);
        }

        return response()->json([
            'ok' => true,
            'wa_clicks' => (int) $resolvedRoom->wa_clicks,
        ]);
    }

    public function sitemap()
    {
        $rooms = Room::query()->select(['id', 'updated_at'])->orderBy('id')->get();
        $baseUrl = rtrim(url('/'), '/');
        $nowAtom = now()->toAtomString();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $staticPages = [
            ['loc' => $baseUrl . '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => $baseUrl . '/catalog', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => $baseUrl . '/about', 'priority' => '0.8', 'changefreq' => 'weekly'],
        ];

        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($page['loc'], ENT_XML1) . "</loc>\n";
            $xml .= "    <lastmod>{$nowAtom}</lastmod>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        foreach ($rooms as $room) {
            $lastmod = $room->updated_at ? $room->updated_at->toAtomString() : $nowAtom;
            $roomUrl = $baseUrl . '/room/' . $room->id;
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($roomUrl, ENT_XML1) . "</loc>\n";
            $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "    <changefreq>daily</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
