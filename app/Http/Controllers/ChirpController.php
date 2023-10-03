<?php

namespace App\Http\Controllers;

use App\Models\chirp;
use App\Models\User;
use App\Notifications\NewChirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(User::all());
        return view("chirps.index", [
            'chirps' => Chirp::orderBy('created_at', 'DESC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:225',
        ]);

        // envoyer les données en BDD
        $request->user()->chirps()->create($validated);

        // $createdChirp->notify(new NewChirp($createdChirp));  envoi de la notification

        //rediriger sur chirps.index 
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(chirp $chirp)
    {
        return view('chirps.edit', ['chirp' => $chirp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, chirp $chirp)
    {
        // Vérifier si l'utilisateur à l'authorisation de modifier le commentaire
        $this->authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]); // Validation des données

        $chirp->update($validated); // mise à jour
        return redirect(route('chirps.index')); // redirection
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chirp $chirp)
    {
        //vérifier l'authorisation de l'utilisateur 
        $this->authorize('delete', $chirp);

        // supprimer la ressource 
        $chirp->delete();

        // Rediriger vers la page des commentaires
        return redirect(route('chirps.index'));
    }
}
