<?php

namespace App\Http\Controllers;

use App\Exports\elevesExport;
use App\Models\Absence;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Parente;
use App\Models\Session;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Summary of eleveController
 */
class EleveController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if(auth()->user()->status_user==0){
        return redirect(route('home.change_password'));
       }
        $id_session = Session::where('status_session', 1)->first()->id_session;
        $classes = Classe::orderby('nom_classe_ar')->orderby('id_classe')->get();
        $id_classe = Classe::orderby('nom_classe_ar')->orderby('id_classe')->first()->id_classe ?? null;
        $eleves = Eleve::where('id_session', $id_session)->where('id_classe', $id_classe)->orderby('id_classe')->paginate(50);


        return view('pages.eleves.index', compact('eleves', 'classes'));
    }

    public function export(Request $request)
    {
        // dd($request->names);
        $names = $request->names;
        $names1 = [];
        $names2 = [];

        foreach ($names as $value) {
            $splitValues = explode(' as ', $value);

            $names1[] =
                trim($splitValues[0]);
            // dd($names1);
            $names2[] =
                trim($splitValues[1]);
        }
        session()->put('column_eleves', $names1);
        session()->put('header_eleves', $names2);

        return Excel::download(new elevesExport, 'eleves.xlsx');
    }

    public function filter(Request $request)
    {
        //dd($request);
        $id_session = Session::where('status_session', 1)->first()->id_session;
        $eleves = Eleve::where('id_session', $id_session)->orderby('id_classe')->orderby('num_eleve');
        $id_classe = Classe::orderby('nom_classe_ar')->orderby('id_classe')->first()->id_classe ?? null;
        if ($request->text != '0') {

            $eleves = $eleves
                ->where('id_eleve', $request->text)->get();
        } else {
            $eleves = $eleves->where('id_classe', $id_classe)->get();
        }




        // dd($eleves->first());
        $data = '';

        foreach ($eleves as $key => $eleves) {

            $status = $eleves->status_eleve == 1 ? 'متمدرس' : ($eleves->status_eleve == 2 ? 'مغادر' : 'منقطع');
            $data .= "<tr>
            <td class='border-bottom-0'>
              <div class='img' >
                  <h6 class='fw-semibold mb-0'>$eleves->num_eleve</h6>
              </div>
            </td>
            <td class='border-bottom-0'>
              <h6 class='fw-semibold mb-0'>$eleves->mat</h6>
            </td>
            <td class='border-bottom-0'>
                <h6 class='fw-semibold mb-1 '>$eleves->nom_ar $eleves->prenom_ar</h6>
                <span class='fw-normal text-uppercase'>$eleves->nom_fr $eleves->prenom_fr</span>
            </td>
            <td class='border-bottom-0'>
              <h6 class='fw-semibold mb-1'>{$eleves->classe->nom_classe_ar}</h6>
                <span class='fw-normal'>{$eleves->classe->nom_classe_fr}</span>
            </td>
            <td class='border-bottom-0'>
              <h6 class='mb-0 fw-normal'>$status</h6>
            </td>";
            $route_details = route('eleve.details', $eleves->id_eleve);
            $route_edit = route('eleve.edit', $eleves->id_eleve);
            $route_delete = route('eleve.delete', $eleves->id_eleve);
            $data .= "<td class='border-bottom-0'>
              <div class=' gap-2'>
                <a href='$route_details' class='badge bg-primary rounded-3 fw-semibold'><i class='ti ti-eye'></i></a>
                <a href='$route_edit' class='badge bg-success rounded-3 fw-semibold'><i class='ti ti-edit'></i></a>
                <a href='$route_delete' onclick='return confirm(`هل تريد إزالة هذا التلميذ من قاعدة البيانات ؟`)' class='badge bg-danger rounded-3 fw-semibold'><i class='ti ti-trash'></i></a>
              </div>
            </td>
          </tr>";
        }
        //dd($data);
        return Response(['data' => $data]);
    }

    public function filterByclasse(Request $request)
    {
        //dd($request);
        $id_session = Session::where('status_session', 1)->first()->id_session;
        $eleves = Eleve::where('id_session', $id_session)->orderby('id_classe')->orderby('num_eleve');

        if ($request->text != '0') {

            $eleves = $eleves
                ->where('id_classe', $request->text);
        }


        $eleves = $eleves->orderby('id_classe')->get();
        // dd($eleves->first());
        $data = '';

        foreach ($eleves as $key => $eleves) {

            $status = $eleves->status_eleve == 1 ? 'متمدرس' : ($eleves->status_eleve == 2 ? 'مغادر' : 'منقطع');
            $data .= "<tr>
            <td class='border-bottom-0'>
              <div class='img' >
                  <h6 class='fw-semibold mb-0'>$eleves->num_eleve</h6>
              </div>
            </td>
            <td class='border-bottom-0'>
              <h6 class='fw-semibold mb-0'>$eleves->mat</h6>
            </td>
            <td class='border-bottom-0'>
                <h6 class='fw-semibold mb-1 '>$eleves->nom_ar $eleves->prenom_ar</h6>
                <span class='fw-normal text-uppercase'>$eleves->nom_fr $eleves->prenom_fr</span>
            </td>
            <td class='border-bottom-0'>
              <h6 class='fw-semibold mb-1'>{$eleves->classe->nom_classe_ar}</h6>
                <span class='fw-normal'>{$eleves->classe->nom_classe_fr}</span>
            </td>
            <td class='border-bottom-0'>
              <h6 class='mb-0 fw-normal'>$status</h6>
            </td>";
            $route_details = route('eleve.details', $eleves->id_eleve);
            $route_edit = route('eleve.edit', $eleves->id_eleve);
            $route_delete = route('eleve.delete', $eleves->id_eleve);
            $data .= "<td class='border-bottom-0'>
              <div class=' gap-2'>
                <a href='$route_details' class='badge bg-primary rounded-3 fw-semibold'><i class='ti ti-eye'></i></a>
                <a href='$route_edit' class='badge bg-success rounded-3 fw-semibold'><i class='ti ti-edit'></i></a>
                <a href='$route_delete' onclick='return confirm(`هل تريد إزالة هذا التلميذ من قاعدة البيانات ؟`)' class='badge bg-danger rounded-3 fw-semibold'><i class='ti ti-trash'></i></a>
              </div>
            </td>
          </tr>";
        }
        //dd($data);
        return Response(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $departements = Departement::all();
        $classes = Classe::orderby('nom_classe_ar')->orderby('id_classe')->get();
        // $fonctions = Fonction::all();
        return \view('pages.eleves.create', compact(['classes']));
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

        $id_session = Session::where('status_session', 1)->first()->id_session;
        $requestData['id_session'] = $id_session;

        Eleve::create(
            $requestData
        );

        return redirect(route('eleve.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\eleve  $eleve
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $eleve = Eleve::findOrFail($request->id_eleve);
        $parents = Parente::where('id_eleve', $request->id_eleve)->get();
        $absences = Absence::where('id_eleve', $request->id_eleve)->get();

        return \view('pages.eleves.details', compact('eleve', 'parents', 'absences'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\eleve  $eleve
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $classes = Classe::orderby('nom_classe_ar')->orderby('id_classe')->get();
        $id_session = Session::where('status_session', 1)->first()->id_session;
        $eleve = Eleve::findOrFail($request->id_eleve);

        return \view('pages.eleves.edit', compact(['classes', 'eleve']));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\eleve  $eleve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request->all());
        $eleve = Eleve::findOrFail($request->id_eleve);
        //dd($eleve);
        $requestData = $request->all();
        //dd($requestData);
        $id_session = Session::where('status_session', 1)->first()->id_session;
        $requestData['id_session'] = $id_session;


        //dd($requestData);
        $eleve->update($requestData);
        $parentData = [];
        $parents = Parente::where('id_eleve', $request->id_eleve)->get();
        for ($id = 0; $id < $parents->count(); $id++) {
            $parent = Parente::findOrFail($requestData['id_parent'][$id]);
            $parentData['nom_parent_ar'] = $requestData['nom_parent_ar'][$id];
            $parentData['prenom_parent_ar'] = $requestData['prenom_parent_ar'][$id];
            $parentData['nom_parent_fr'] = $requestData['nom_parent_fr'][$id];
            $parentData['prenom_parent_fr'] = $requestData['prenom_parent_fr'][$id];
            $parentData['type_parent'] = $requestData['type_parent'][$id];
            $parentData['cin'] = $requestData['cin'][$id];
            $parentData['profession'] = $requestData['profession'][$id];
            $parentData['tel'] = $requestData['tel'][$id];
            $parentData['adresse'] = $requestData['adresse'][$id];
            $parentData['id_eleve'] = $requestData['id_eleve'];
            $parent->update($parentData);
            // dd($requestData,$parentData);
        }
        //$parent->update($requestData);
        //dd($requestData,$parentData);

        return redirect(route('eleve.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\eleve  $eleve
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $eleve = Eleve::findOrFail($request->id_eleve);
        $eleve->delete();

        return redirect(route('eleve.index'));
    }
}
