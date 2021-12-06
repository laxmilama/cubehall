<?php

namespace App\Http\Controllers;

use App\Models\ParlorSection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParlorSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ParlorSection::with('categories')
            ->get();
    }

    public function available()
    {        
        return ParlorSection::with(['categories' => function ($query) {
            $query->with(['subcategories' => function ($q) {
                $q->whereHas('parlor', function ($p) {
                    $p->where('status', 1)
                        ->whereHas('tickets', function ($t) {
                            $t->where('time', '>', Carbon::now());
                        });
                });
            }]);
            $query->whereHas('parlor', function ($p) {
                $p->where('status', 1)
                    ->whereHas('tickets', function ($t) {
                        $t->where('time', '>', Carbon::now());
                    });
            })
            ->orWhereHas('subcategories', function ($q) {
                $q->whereHas('parlor', function ($p) {
                    $p->where('status', 1)
                        ->whereHas('tickets', function ($t) {
                            $t->where('time', '>', Carbon::now());
                        });
                });
            });
        }])
            ->whereHas('categories')
            ->get();
    }
}
