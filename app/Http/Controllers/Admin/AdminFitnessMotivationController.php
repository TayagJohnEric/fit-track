<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FitnessMotivation;


class AdminFitnessMotivationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $motivations = FitnessMotivation::when($search, function ($query, $search) {
                return $query->where('quote', 'like', "%{$search}%")
                             ->orWhere('author', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(5);

        return view('admin.fitness-motivations.index', compact('motivations', 'search'));
    }

    public function create()
{
    return view('admin.fitness-motivations.create');
}

    public function store(Request $request)
    {
        $request->validate([
            'quote' => 'required',
            'author' => 'nullable|string|max:255',
        ]);

        FitnessMotivation::create($request->only('quote', 'author'));

        return redirect()->route('fitness-motivations.index')->with('success', 'Motivation added!');
    }

    public function edit(FitnessMotivation $fitnessMotivation)
{
    return view('admin.fitness-motivations.edit', compact('fitnessMotivation'));
}

    public function update(Request $request, FitnessMotivation $fitnessMotivation)
    {
        $request->validate([
            'quote' => 'required',
            'author' => 'nullable|string|max:255',
        ]);

        $fitnessMotivation->update($request->only('quote', 'author'));

       return redirect()->route('fitness-motivations.index')->with('success', 'Motivation updated!');
    }

    public function destroy(FitnessMotivation $fitnessMotivation)
    {
        $fitnessMotivation->delete();
        return redirect()->back()->with('success', 'Motivation deleted!');
    }
}
