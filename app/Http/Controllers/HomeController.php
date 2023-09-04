<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Parente;
use App\Models\Seance;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect(route('home.index'));
    }

    public function save(Request $request)
    {
       // dd($request->all());
        $setting =  Setting::where('id_user',Auth::user()->id)->first();

       // dd($requestData);
        $requestData = $request->all();
        $requestData['colors'] = implode(",", $request->color);
        //dd( $requestData );
        $setting->update($requestData);

        return redirect(route('home.index'));
    }

    public function reset(Request $request)
    {
        if($request->ok){

            $absence = Absence::all();
            $absence->delete();

            DB::update('ALTER TABLE absences AUTO_INCREMENT = 100');

            $seance = Seance::all();
            $seance->delete();

            DB::update('ALTER TABLE seances AUTO_INCREMENT = 1');

            //$eleve = Eleve::where('id_user', Auth::id());
            $eleve = Eleve::all();
            $eleve->delete();
            DB::update('ALTER TABLE eleves AUTO_INCREMENT = 100');

            $parent = Parente::all();
            $parent->delete();
            DB::update('ALTER TABLE parentes AUTO_INCREMENT = 100');

            $classe = Classe::all();
            $classe->delete();

            DB::update('ALTER TABLE classes AUTO_INCREMENT = 1');




            return redirect()->back();
        }

        return redirect(route('home.index'));
    }



}
