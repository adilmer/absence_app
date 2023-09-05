<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Information;
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
        $requestData = $request->truncate();
        $requestData['colors'] = implode(",", $request->color);
        //dd( $requestData );
        $setting->update($requestData);

        return redirect(route('home.index'));
    }

    public function reset(Request $request)
    {
        if($request->ok){


            DB::table('absences')->delete();


            DB::update('ALTER TABLE absences AUTO_INCREMENT = 100');



            DB::table('seances')->delete();

            DB::update('ALTER TABLE seances AUTO_INCREMENT = 1');



            DB::table('parentes')->delete();

            DB::update('ALTER TABLE parentes AUTO_INCREMENT = 100');



            DB::table('classes')->delete();


            DB::update('ALTER TABLE classes AUTO_INCREMENT = 1');



            DB::table('informations')->delete();


            DB::update('ALTER TABLE informations AUTO_INCREMENT = 1');

            DB::table('eleves')->delete();

            DB::update('ALTER TABLE eleves AUTO_INCREMENT = 100');

            return redirect(route('home.index'));
        }


    }



}
