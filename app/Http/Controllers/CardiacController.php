<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cardiac;

class CardiacController extends Controller
{
    public function list()
    {
        return Inertia::render('contentPage/cardiacListPage');
    }

    public function getAll()
    {
        return response()->json(Cardiac::all());
    }

    public function getLinkItem($id)
    {
        $cardiac = Cardiac::with('cardiacItem')->FindOrFail($id);
        return response()->json($cardiac);
    }

    public function form()
    {
        return Inertia::render('contentPage/cardiacFormPage');
    }

    public function exercice()
    {
        return Inertia::render('contentPage/cardiacExercicePage');
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['required','string'],
            'difficulty' => ['required','in:First,Beginner,Advanced,Expert,Master'],
            ]);


        $cardiac = Cardiac::create($data);

        return redirect('/cardiac/formulaireEtape');
    }

    public function getLast()
    {
        $last = Cardiac::latest()->first();
        return response()->json($last);
    }
}