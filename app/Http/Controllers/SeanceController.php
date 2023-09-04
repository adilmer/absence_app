<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Seance;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Summary of SeanceController
 */
class SeanceController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $classes = Classe::orderby('nom_classe_ar')->orderby('id_classe')->get();
        $id_classe = 1;
        if ($classes->first())
        $id_classe =$classes->first()->id_classe;

        $seances = Seance::where('id_classe',$id_classe)->get();

        return view('pages.seances.index',compact('seances','classes'));
    }


    public function filter(Request $request)
    {
        //dd($request);
        $seances = Seance::orderby('code_jours');



            $seances = $seances
                ->where('id_classe', $request->text);




        $seances = $seances->get();
       // dd($seances->first());
        $data = '';

        foreach ($seances as $key => $seances) {
            $s1 = $seances->s1==1 ? 'checked' : '';
            $s2 = $seances->s2==1 ? 'checked' : '';
            $s3 = $seances->s3==1 ? 'checked' : '';
            $s4 = $seances->s4==1 ? 'checked' : '';
            $s5 = $seances->s5==1 ? 'checked' : '';
            $s6 = $seances->s6==1 ? 'checked' : '';
            $s7 = $seances->s7==1 ? 'checked' : '';
            $s8 = $seances->s8==1 ? 'checked' : '';
            $weekdayNames = [
                'الأحد',
                'الاثنين',
                'الثلاثاء',
                'الأربعاء',
                'الخميس',
                'الجمعة',
                'السبت',
            ];
            $route_delete = route('seance.delete',$seances->id_seance);

            $data .="<tr>

            <td class='border-bottom-0 text-center'>
              <h6 class='fw-semibold mb-0 '>{$weekdayNames[$seances->code_jours]}</h6>
            </td>
            <td class='border-bottom-0'>
                <h6 class='fw-semibold mb-1 '>{$seances->classe->nom_classe_fr}</h6>
            </td>
            <td>
              <input class='checkbox_seance'  data-id_seance='$seances->id_seance' type='checkbox' name='s1' id='$seances->s1' $s1 >
              </td>
              <td>
              <input class='checkbox_seance'  data-id_seance='$seances->id_seance' type='checkbox' name='s2' id='$seances->s2' $s2 >
              </td>
              <td>
              <input class='checkbox_seance'  data-id_seance='$seances->id_seance' type='checkbox' name='s3' id='$seances->s3' $s3 >
              </td>
              <td>
              <input class='checkbox_seance'  data-id_seance='$seances->id_seance' type='checkbox' name='s4' id='$seances->s4' $s4 >
              </td>
              <td></td>
              <td>
              <input class='checkbox_seance'  data-id_seance='$seances->id_seance' type='checkbox' name='s5' id='$seances->s5' $s5 >
              </td>
              <td>
              <input class='checkbox_seance'  data-id_seance='$seances->id_seance' type='checkbox' name='s6' id='$seances->s6' $s6 >
              </td>
              <td>
              <input class='checkbox_seance'  data-id_seance='$seances->id_seance' type='checkbox' name='s7' id='$seances->s7' $s7 >
              </td>
              <td>
              <input class='checkbox_seance'  data-id_seance='$seances->id_seance' type='checkbox' name='s8' id='$seances->s8' $s8 >
              </td>
          </div>
          </tr>";
        }
        //dd($data);
        return Response(['data' => $data]);

    }

    public function filterByseance(Request $request)
    {
        //dd($request);
        $seances = Seance::orderby('mat');

        if ($request->text != '0') {

            $seances = $seances
                ->where('id_seance', $request->text);
        }


        $seances = $seances->get();
       // dd($seances->first());
        $data = '';

        foreach ($seances as $key => $seances) {


            $data .="<tr>
            <td class='border-bottom-0'>
              <div class='img' >
                  <img class='rounded-circle' width='50px' height='50px' src='../assets/images/profile/user-1.jpg' alt='' srcset=''>
              </div>
            </td>
            <td class='border-bottom-0'>
              <h6 class='fw-semibold mb-0'>$seances->mat</h6>
            </td>
            <td class='border-bottom-0'>
                <h6 class='fw-semibold mb-1 '>$seances->nom_ar $seances->prenom_ar</h6>
                <span class='fw-normal text-uppercase'>$seances->nom_fr $seances->prenom_fr</span>
            </td>
            <td class='border-bottom-0'>
              <h6 class='fw-semibold mb-1'>{$seances->seance->nom_seance_ar}</h6>
                <span class='fw-normal'>{$seances->seance->nom_seance_fr}</span>
            </td>
            <td class='border-bottom-0'>
              <h6 class='mb-0 fw-normal'>{$seances->date_naiss->format('Y-m-d')}</h6>
            </td>";
            $route_details = route('seance.details',$seances->id_seance);
            $route_edit = route('seance.edit',$seances->id_seance);
            $route_delete = route('seance.delete',$seances->id_seance);
            $data .="<td class='border-bottom-0'>
              <div class='d-flex  align-items-center gap-2'>
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
        $seances = Seance::all();
       // $fonctions = Fonction::all();
        return \view('pages.seances.create',compact(['seances']));
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

        Seance::create(
            $requestData);

        return redirect(route('seance.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\seance  $seance
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $seance = Seance::findOrFail($request->id_seance);
        //dd($documents);
        return \view('pages.seances.details',compact('seance','documents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\seance  $seance
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $seances = Seance::all();
        $seance = Seance::findOrFail($request->id_seance);

        return \view('pages.seances.edit',compact(['seances','seance']));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\seance  $seance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      //dd($request->all());
        $seance = Seance::findOrFail($request->id_seance);
        //dd($seance);

        $requestData = $request->all();
        $requestData["nbr_seance"]= $seance->nbr_seance;

        if($requestData["$request->seance_nom"] == "0"){
            $requestData["$request->seance_nom"] = 1;
            $requestData["nbr_seance"] = $requestData["nbr_seance"] +1;
        }
        else{
            $requestData["$request->seance_nom"] = 0;
            $requestData["nbr_seance"] = $requestData["nbr_seance"] -1;
        }

        //dd($request->all(), $requestData);
		$seance->update($requestData);

        return redirect(route('seance.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\seance  $seance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $seance = Seance::findOrFail($request->id_seance);
        $seance->delete();

        return redirect(route('seance.index'));
    }
}
