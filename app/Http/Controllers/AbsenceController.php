<?php

namespace App\Http\Controllers;;

use App\Models\Absence;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Information;
use App\Models\MotifAbsence;
use App\Models\Seance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $date = date('Y-m-d');
        $dayOfWeek = Carbon::now()->dayOfWeek;
        $eleves = Eleve::join('classes', 'classes.id_classe', '=', 'eleves.id_classe')
            ->join('seances', 'classes.id_classe', '=', 'seances.id_classe')
            ->select('eleves.*', 'eleves.id_eleve as code_eleve')
            ->with(['absences' => function ($query) use ($date) {
                $query->where('date', $date);
            }])
            ->where('classes.id_classe', Classe::orderby('nom_classe_ar')->orderby('id_classe')->first()->id_classe)
            ->distinct()
            ->get();


        $classes = Classe::orderby('nom_classe_ar')->orderby('id_classe')->get();


        return view('pages.absences.index', compact('classes', 'eleves'));
    }

    public function absence_collective()
    {
        $classes = Classe::orderby('nom_classe_ar')->orderby('id_classe')->get();
        $eleves = Eleve::join('classes', 'classes.id_classe', '=', 'eleves.id_classe')
            ->join('seances', 'classes.id_classe', '=', 'seances.id_classe')
            ->select('eleves.*', 'eleves.id_eleve as code_eleve')
            ->where('classes.id_classe', '=', $classes->first()->id_classe)
            ->distinct()
            ->get();



        return view('pages.absences.absence_collective', compact('classes', 'eleves'));
    }



    public function saveSelected(Request $request)
    {
        // dd($request->all());
        $selectedIds = $request->input('selectedIds');
        Session::put('selectedIds', $selectedIds);

        return response()->json(['message' => 'Selected IDs saved to session.']);
    }

    public function generateAll(Request $request)
    {

        // $selectedIds = $request->input('selectedIds');
        $selectedIds = Session('selectedIds');
        if ($selectedIds) {
            $eleves = Eleve::whereIn('id_eleve', $selectedIds)->get();
            $dateB = $request->dateB;
            $timeB = $request->timeB;
            $id_classe = Eleve::whereIn('id_eleve', $selectedIds)->first()->id_classe;
            $classe = Classe::findOrFail($id_classe);
            $information = Information::where('status_info', 1)->first();
            /// dd($eleves,compact('eleves', 'dateB', 'timeB','classe'));

            // Session::forget('selectedIds');
            return view('pdf.document_all', compact('eleves', 'dateB', 'timeB', 'classe', 'information'));
        }

        return redirect()->back();
    }

    public function edit(Request $request)
    {

        $date = date('Y-m-d');
        $dayOfWeek = Carbon::now()->dayOfWeek;
        $eleve = Eleve::where('id_eleve', $request->id_eleve)->get();
        $absences = Absence::where('id_eleve', $request->id_eleve)->orderbyDesc('date')->get();
        $classes = Classe::orderby('nom_classe_ar')->orderby('id_classe')->get();
        $motif_absences = MotifAbsence::all();
        $absence = Absence::where('id_eleve', $request->id_eleve);

        return view('pages.absences.edit', compact('eleve', 'motif_absences', 'absences', 'absence'));
    }



    public function generatePdf(Request $request)
    {

        $absences = Absence::where('id_eleve', $request->id_eleve)->orderbyDesc('date')->get();
        $eleve = Eleve::findOrFail($request->id_eleve);
        $dateB = $request->dateB;
        $timeB = $request->timeB;
        $motif = $request->motif;
        $information = Information::where('status_info', 1)->first();
        $print = $request->print;
        return view('pdf.document', compact('eleve', 'dateB', 'timeB', 'motif', 'absences', 'information', 'print'));
    }

    public function liste_absence(Request $request)
    {
        $classes = Classe::orderby('nom_classe_fr')->orderby('id_classe')->get();

        $absence_data_array = [];

        foreach ($classes as $classe) {
            $nom_classe_ar = $classe->nom_classe_ar;
            $nom_classe_fr = $classe->nom_classe_fr;
            $id_classe = $classe->id_classe;
            if (!isset($absence_data_array[$nom_classe_ar])) {
                $absence_data_array[$nom_classe_ar] = [];
            }

            $absence_data_array[$nom_classe_ar][] = [
                'id_classe' => $id_classe,
                'nom_classe_fr' => $nom_classe_fr,
            ];
                }
              //  dd($absence_data_array);
            return view('pages.classes.liste_absence', compact('classes', 'absence_data_array'));

    }
    public function generateListes(Request $request)
    {
        $classe = Classe::where('id_classe', $request->id_classe)->first();
        $eleves = Eleve::where('id_classe', $classe->id_classe)->get();
        $seances = Seance::where('id_classe', $classe->id_classe)->get();
        $information = Information::where('status_info', 1)->first();
        $print = $request->print;
        return view('pdf.document_absence', compact('eleves', 'classe', 'seances', 'information', 'print'));
    }


    public function filter(Request $request)
    {
        return $this->show_data($request);
    }

    public function filter_collective(Request $request)
    {
        return $this->show_data_collective($request);
    }

    function show_data_collective(Request $request)
    {
        $date = date('Y-m-d');
        $date = Carbon::parse($request->date_absence);
        $dayOfWeek = $date->dayOfWeek;
        $selectedIds = Session('selectedIds');


        $eleves = Eleve::join('classes', 'classes.id_classe', '=', 'eleves.id_classe')
            ->join('seances', 'classes.id_classe', '=', 'seances.id_classe')
            ->select('eleves.*', 'eleves.id_eleve as code_eleve')
            ->with(['absences' => function ($query) use ($date) {
                $query->where('date', $date);
            }]);

        if ($request->id_classe != '0') {

            $eleves = $eleves
                ->where('classes.id_classe', $request->id_classe);
        }

        $eleves = $eleves->where(function ($query) use ($request) {
            $query->where('mat', 'like', '%' . $request->texte . '%')
                ->orWhere('nom_ar', 'like', '%' . $request->texte . '%')
                ->orWhere('prenom_ar', 'like', '%' . $request->texte . '%');
        });

        $eleves = $eleves->distinct()->get();

        $data = '';

        foreach ($eleves as $key => $eleves) {

            $route_details = route('eleve.details', $eleves->id_eleve);

            $selected = !is_null($selectedIds) && in_array($eleves->id_eleve, $selectedIds) ? 'checked' : '';


            $data .= "<tr class='text-center'>
            <td><div class='form-check  form-check-inline'>
            <input class='form-check-input border-info' data-id-eleve='$eleves->id_eleve' type='checkbox' $selected name='id_eleve[]' id='' value='$eleves->id_eleve' >
            <label class='form-check-label' for=''></label>
        </div></td>
            <td>$eleves->num_eleve</td>
            <td><a href='$route_details'>$eleves->nom_ar $eleves->prenom_ar</a></td>
            <td>{$eleves->classe->nom_classe_fr}</td>";

            $total_seances_eleve = str_pad(0, 2, '0', STR_PAD_LEFT);
            $total_jours_eleve = str_pad(0, 2, '0', STR_PAD_LEFT);

            $total_jours_ele = DB::table('absences')->where('id_eleve', $eleves->code_eleve)->sum('total_jours');
            $total_seances_ele = DB::table('absences')->where('id_eleve', $eleves->code_eleve)->sum('total_seances');

            $total_seances_eleve = str_pad($total_seances_ele, 2, '0', STR_PAD_LEFT);
            $total_jours_eleve = str_pad($total_jours_ele, 2, '0', STR_PAD_LEFT);

            $data .= "<td><span class=' text-bold'>$total_seances_eleve</span> </td>
            <td><span class=' text-bold'>$total_jours_eleve</span></td>
        </tr>";
        }

        return Response(['data' => $data]);
    }

    function show_data(Request $request)
    {
        $date = date('Y-m-d');
        $date = Carbon::parse($request->date_absence);
        $dayOfWeek = $date->dayOfWeek;

        $eleves = Eleve::join('classes', 'classes.id_classe', '=', 'eleves.id_classe')
            ->join('seances', 'classes.id_classe', '=', 'seances.id_classe')
            ->select('eleves.*', 'eleves.id_eleve as code_eleve')
            ->with(['absences' => function ($query) use ($date) {
                $query->where('date', $date);
            }]);

        if ($request->texte == '') {

            $eleves = $eleves
                ->where('classes.id_classe', $request->id_classe);
        } else {
            $eleves = $eleves->where(function ($query) use ($request) {
                $query->where('mat', 'like', '%' . $request->texte . '%')
                    ->orWhere('nom_ar', 'like', '%' . $request->texte . '%')
                    ->orWhere('prenom_ar', 'like', '%' . $request->texte . '%');
            });
        }


        $eleves = $eleves->distinct()->get();

        $data = '';

        foreach ($eleves as $key => $eleves) {
            $seance = DB::table('seances')->where('id_classe', $eleves->id_classe)->where('code_jours', $dayOfWeek)->first();
            $route_details = route('eleve.details', $eleves->id_eleve);

            $s1 = $seance->s1 == 0 ? 'disabled' : '';
            $s2 = $seance->s2 == 0 ? 'disabled' : '';
            $s3 = $seance->s3 == 0 ? 'disabled' : '';
            $s4 = $seance->s4 == 0 ? 'disabled' : '';
            $s5 = $seance->s5 == 0 ? 'disabled' : '';
            $s6 = $seance->s6 == 0 ? 'disabled' : '';
            $s7 = $seance->s7 == 0 ? 'disabled' : '';
            $s8 = $seance->s8 == 0 ? 'disabled' : '';

            $absence = $eleves->absences->where('id_eleve', $eleves->id_eleve)->first();

            $data .= "<tr class='text-center'>
            <td>$eleves->id_eleve</td>
            <td><a href='$route_details'>$eleves->nom_ar $eleves->prenom_ar</a></td>
            <td>{$eleves->classe->nom_classe_fr}</td>";
            $total_seances = str_pad(0, 2, '0', STR_PAD_LEFT);
            $total_jours = str_pad(0, 2, '0', STR_PAD_LEFT);
            $total_seances_eleve = str_pad(0, 2, '0', STR_PAD_LEFT);
            $total_jours_eleve = str_pad(0, 2, '0', STR_PAD_LEFT);
            $routeEdit = route('absence.edit') . "?id_eleve=" . $eleves->id_eleve;
            $motif_absence = 'بدون مبرر';
            if ($absence) {
                $h1 = $absence->h1 == 1 ? 'checked' : '';
                $h2 = $absence->h2 == 1 ? 'checked' : '';
                $h3 = $absence->h3 == 1 ? 'checked' : '';
                $h4 = $absence->h4 == 1 ? 'checked' : '';
                $h5 = $absence->h5 == 1 ? 'checked' : '';
                $h6 = $absence->h6 == 1 ? 'checked' : '';
                $h7 = $absence->h7 == 1 ? 'checked' : '';
                $h8 = $absence->h8 == 1 ? 'checked' : '';

                $total_jours_ele = DB::table('absences')->where('id_eleve', $eleves->code_eleve)->sum('total_jours');
                $total_seances_ele = DB::table('absences')->where('id_eleve', $eleves->code_eleve)->sum('total_seances');

                $total_seances = str_pad($absence->total_seances, 2, '0', STR_PAD_LEFT);
                $total_jours = str_pad($absence->total_jours, 2, '0', STR_PAD_LEFT);
                $total_seances_eleve = str_pad($total_seances_ele, 2, '0', STR_PAD_LEFT);
                $total_jours_eleve = str_pad($total_jours_ele, 2, '0', STR_PAD_LEFT);
                $motif_absence = $absence->motif_absence->nom_motif;

                $data .= "<td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h1' id='$absence->h1' $h1 ?? '' $s1 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h2' id='$absence->h2'  $h2 ?? ''  $s2 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h3' id='$absence->h3'  $h3 ?? ''  $s3 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h4' id='$absence->h4'  $h4 ?? ''  $s4 >
                </td>
                <td></td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h5' id='$absence->h5'  $h5 ?? ''  $s5 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h6' id='$absence->h6'  $h6 ?? ''  $s6 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h7' id='$absence->h7'  $h7 ?? ''  $s7 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h8' id='$absence->h8'  $h8 ?? ''  $s8 >
                </td>";
            } else {
                $data .= "<td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h1' id='0' $s1 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h2' id='0' $s2 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h3' id='0'  $s3 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h4' id='0' $s4 >
                </td>
                <td></td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h5' id='0'  $s5 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h6' id='0'  $s6 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h7' id='0'  $s7 >
                </td>
                <td>
                <input class='checkbox_eleve'  data-id_eleve='$eleves->code_eleve' type='checkbox' name='h8' id='0' $s8 >
                </td>";
            }

            $data .= "<td>$total_seances (<span class='text-danger text-bold'>$total_seances_eleve</span>) </td>
            <td>$total_jours (<span class='text-danger text-bold'>$total_jours_eleve</span>)</td>

            <td>
                                <a href='$routeEdit' class='btn btn-sm btn-outline-secondary w-100'><i class='ti ti-'></i> $motif_absence</a>
                              </td>
                            <td>
                                <button data-id_eleve='$eleves->code_eleve'  data-bs-toggle='modal' data-bs-target='#billetModal' class='btn btn-sm btn-warning'><i class='ti ti-printer'></i></button>
                            </td>
        </tr>";
        }

        return Response(['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        // dd($requestData);
        $absence = Absence::findOrFail($request->id_absence);
        $absence->update($requestData);

        return redirect(route('absence.edit') . "/?id_eleve=" . $absence->id_eleve);
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $absence = Absence::where('date', $request->date)->where('id_eleve', $request->id_eleve)->first();
        $date = Carbon::parse($request->date);
        $requestData = $request->all();

        $eleve = Eleve::findOrFail($request->id_eleve);
        $seance = Seance::where('code_jours', $date->dayOfWeek)->where('id_classe', $eleve->id_classe)->first();
        $requestData["total_seances"] = 0;
        $requestData["total_jours"] = 0;
        if ($absence) {
            $requestData["total_seances"] = $absence->total_seances;
            $requestData["total_jours"] = $absence->total_jours;
        }

        if ($requestData["$request->eleve_nom"] == "0") {
            $requestData["$request->eleve_nom"] = 1;

            if ($requestData["total_seances"] < $seance->nbr_seance - 1) {

                $requestData["total_seances"] = $requestData["total_seances"] + 1;
            } else {

                $requestData["total_seances"] = $requestData["total_seances"] -  $seance->nbr_seance + 1;
                $requestData["total_jours"] = $requestData["total_jours"] + 1;
            }
        } else {
            $requestData["$request->eleve_nom"] = 0;
            if ($requestData["total_seances"] != 0) {

                $requestData["total_seances"] = $requestData["total_seances"] - 1;
            } else {

                $requestData["total_seances"] = $seance->nbr_seance - 1;
                $requestData["total_jours"] = $requestData["total_jours"] - 1;
            }
        }

        // dd($request->all(),$requestData,$absence);
        // dd($request->all(),$requestData);
        unset($requestData["eleve_nom"]);
        unset($requestData["text"]);
        unset($requestData["texte"]);
        unset($requestData["date_absence"]);
        unset($requestData["id_classe"]);


        if (!$absence) {
            $absence = Absence::create($requestData);
        } else {
            $absence->update($requestData);
        }

        return $this->show_data($request);
    }
}
