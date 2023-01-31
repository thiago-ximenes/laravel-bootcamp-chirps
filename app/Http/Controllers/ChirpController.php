<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateChirpMessage;
use App\Models\Chirp;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Inertia\Inertia;
use Inertia\Response;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Chirps/Index', [
            'chirps' => Chirp::with('user:id,name')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValidateChirpMessage $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ValidateChirpMessage $request): Redirector|RedirectResponse|Application
    {
        $validate = $request->validate([
            'message' => 'required|max:255|string',
        ]);

        $request->user()->chirps()->create($validate);

        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Chirp $chirp
     * @return \Illuminate\Http\Response
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Chirp $chirp
     * @return \Illuminate\Http\Response
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ValidateChirpMessage $request
     * @param Chirp $chirp
     * @return Application|Redirector|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(ValidateChirpMessage $request, Chirp $chirp): Redirector|RedirectResponse|Application
    {
        $this->authorize('update', $chirp);

        $validated = $request->validated();

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Chirp $chirp
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
