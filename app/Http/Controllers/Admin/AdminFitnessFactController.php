<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FitnessFact;


class AdminFitnessFactController extends Controller
{
   public function index(Request $request)
    {
        $search = $request->input('search');

        $fitnessFacts = FitnessFact::when($search, function ($query, $search) {
                return $query->where('fact_text', 'like', "%{$search}%")
                             ->orWhere('category', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.fitness-facts.index', compact('fitnessFacts', 'search'));
    }

    public function create()
    {
        return view('admin.fitness-facts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fact_text' => 'required|string',
            'category' => 'nullable|string',
        ]);

        FitnessFact::create($request->only('fact_text', 'category'));

        return redirect()->route('fitness-facts.index')->with('success', 'Fitness Fact created successfully.');
    }

    public function edit(FitnessFact $fitnessFact)
    {
        return view('admin.fitness-facts.edit', compact('fitnessFact'));
    }

    public function update(Request $request, FitnessFact $fitnessFact)
    {
        $request->validate([
            'fact_text' => 'required|string',
            'category' => 'nullable|string',
        ]);

        $fitnessFact->update($request->only('fact_text', 'category'));

        return redirect()->route('fitness-facts.index')->with('success', 'Fitness Fact updated successfully.');
    }

    public function destroy(FitnessFact $fitnessFact)
    {
        $fitnessFact->delete();

        return redirect()->route('fitness-facts.index')->with('success', 'Fitness Fact deleted successfully.');
    }
}
