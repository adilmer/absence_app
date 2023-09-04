<?php

namespace App\Http\Controllers;

use App\Exports\classesExport;
use App\Models\Classe;
use App\Models\Document;
use App\Models\Seance;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Summary of classeController
 */
class ClasseController extends Controller
{


    public function index()
    {
        $classes = Classe::all();

        return view('pages.classes.index',compact('classes'));
    }


    public function filter(Request $request)
    {
        //dd($request);
        $classes = Classe::orderby('nom_classe_ar')->orderby('id_classe');

        if ($request->text != '') {

            $classes = $classes
                ->where(function ($query) use ($request) {
                    $query->where('nom_classe_fr', 'like', '%' . $request->text . '%')
                          ->orWhere('nom_classe_ar', 'like', '%' . $request->text . '%');
                });
        }


        $classes = $classes->get();
       // dd($classes->first());
        $data = '';

        foreach ($classes as $key => $classes) {

            $route_delete = route('classe.delete',$classes->id_classe);

            $data .="<tr>
            <td class='border-bottom-0'>
                        <h6 class='fw-semibold mb-0'>$classes->id_classe</h6>
                      </td>
                      <td class='border-bottom-0'>
                          <h6 class='fw-semibold mb-1 '>$classes->nom_classe_ar</h6>
                      </td>
                      <td class='border-bottom-0'>
                        <h6 class='fw-semibold mb-1'>$classes->nom_classe_fr</h6>
                      </td>";

            $data .="<td class='border-bottom-0'>
              <div class='d-flex  align-items-center gap-2'>
                <a href='$route_delete' onclick='return confirm(`هل تريد إزالة هذا القسم من قاعدة البيانات ؟`)' class='badge bg-danger rounded-3 fw-semibold'><i class='ti ti-trash'></i></a>
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
        $classes = Classe::orderby('mat');

        if ($request->text != '0') {

            $classes = $classes
                ->where('id_classe', $request->text);
        }


        $classes = $classes->get();
       // dd($classes->first());
        $data = '';

        foreach ($classes as $key => $classes) {


            $data .="<tr>
            <td class='border-bottom-0'>
              <div class='img' >
                  <img class='rounded-circle' width='50px' height='50px' src='../assets/images/profile/user-1.jpg' alt='' srcset=''>
              </div>
            </td>
            <td class='border-bottom-0'>
              <h6 class='fw-semibold mb-0'>$classes->mat</h6>
            </td>
            <td class='border-bottom-0'>
                <h6 class='fw-semibold mb-1 '>$classes->nom_ar $classes->prenom_ar</h6>
                <span class='fw-normal text-uppercase'>$classes->nom_fr $classes->prenom_fr</span>
            </td>
            <td class='border-bottom-0'>
              <h6 class='fw-semibold mb-1'>{$classes->classe->nom_classe_ar}</h6>
                <span class='fw-normal'>{$classes->classe->nom_classe_fr}</span>
            </td>
            <td class='border-bottom-0'>
              <h6 class='mb-0 fw-normal'>{$classes->date_naiss->format('Y-m-d')}</h6>
            </td>";
            $route_details = route('classe.details',$classes->id_classe);
            $route_edit = route('classe.edit',$classes->id_classe);
            $route_delete = route('classe.delete',$classes->id_classe);
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
        $classes = Classe::orderby('nom_classe_fr')->get();
       // $fonctions = Fonction::all();
        return \view('pages.classes.create',compact(['classes']));
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

       $classe = Classe::create(
            $requestData);
            for ($i=0; $i <= 6; $i++) {
                Seance::create([
                    'id_classe'=>$classe->id_classe,
                    'code_jours'=>$i
                ]
                );
            }


        return redirect(route('classe.index'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $classes = Classe::orderby('nom_classe_fr')->get();
        $classe = Classe::findOrFail($request->id_classe);

        return \view('pages.classes.edit',compact(['classes','classe']));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      //dd($request->all());
        $classe = Classe::findOrFail($request->id_classe);
        //dd($classe);
        $requestData = $request->all();

		$classe->update($requestData);

        return redirect(route('classe.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $classe = Classe::findOrFail($request->id_classe);
        $classe->delete();

        return redirect(route('classe.index'));
    }
}
