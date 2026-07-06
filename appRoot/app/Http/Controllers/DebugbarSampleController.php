<?php

namespace App\Http\Controllers;

use App\Models\DebugbarSampleItem;
use Fruitcake\LaravelDebugbar\Facades\Debugbar;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

class DebugbarSampleController extends Controller
{
    public function index(): View
    {
        if (DebugbarSampleItem::count() === 0) {
            for ($i = 1; $i <= 5; $i++) {
                DebugbarSampleItem::create([
                    'title' => "Sample item {$i}",
                    'body' => "This is the body text of sample item {$i}.",
                ]);
            }
        }

        Debugbar::startMeasure('fetch_items', 'Fetch debugbar sample items');
        $items = DebugbarSampleItem::orderBy('id')->get();

        // Intentionally re-query per item (N+1 pattern) so the Queries tab
        // shows multiple queries instead of a single one.
        foreach ($items as $item) {
            DebugbarSampleItem::find($item->id);
        }
        Debugbar::stopMeasure('fetch_items');

        Debugbar::info('Loaded '.$items->count().' debugbar sample items');
        Log::info('DebugbarSampleController: rendered sample page', ['item_count' => $items->count()]);

        return view('debugbar-sample', compact('items'));
    }
}
