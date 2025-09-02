<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CardiacItem;

class CardiacItemController extends Controller
{
    public function create(Request $request)
    {
        $stillSteps = true;
        $counter = 0;
        while($stillSteps == true)
        {
            if($request[$counter] != null)
            {
                $cardiac = CardiacItem::create($request[$counter]);
                $counter += 1;
            }
            else
            {
                $stillSteps = false;
            }
        }
    }

    public function form()
    {
        return Inertia::render('contentPage/cardiacItemFormPage');
    }
}
