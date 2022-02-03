<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patient = Patient::all();
        return Inertia::render('Patient/Index', ['patient' => $patient]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Patient/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if(!$validated) {
            return Redirect::route('patient.create');
        }

        $patient = New Patient();
        $slug = $this->setSlug($request->name);

        $patient->name = $request->name;
        $patient->slug = $slug;
        $patient->email = $request->email;
        $patient->password = $request->password;
        $patient->save();

        return Redirect::route('patient.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        if($patient->id) {
            $patient = Patient::where('id', $patient->id)->get();
            return Inertia::render('Patient/Show', [
                'patient' => $patient,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        if($patient->id) {
            $patient = Patient::find($patient->id);
            return Inertia::render('Patient/Edit', [
                'patient' => $patient,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        if($patient->id) {
            Patient::find($patient->id)->update($request->all());
        }
        return Inertia::render('Patient/Index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return Redirect::route('patient.index');
    }

        private function setSlug($patient) {
            $titleSlug = Str::slug($patient);

            $query = Patient::all();

            $t = 0;
            foreach ($query as $patient) {
                if (Str::slug($patient->name) === $titleSlug) {
                    $t++;
                }
            }

            if ($t > 0) {
                $titleSlug = $titleSlug . '-' . $t;
            }

            return $titleSlug;
        }
}