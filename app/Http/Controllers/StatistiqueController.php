<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function index()
    {

        $settings = DB::table('settings')->where('id_user',Auth::id())->first();
        $color = explode(",",$settings->colors);
        //dd($color);
        $chart_options1 = [
        'chart_title' => 'التلاميذ حسب المستوى',
        'report_type' => 'group_by_relationship',
        'model' => 'App\Models\Eleve',
        'relationship_name' => 'classe', // Name of the relationship method in Eleve model
        'group_by_field' => 'nom_classe_ar', // Field in the related Classe model to group by
        'chart_type' => 'pie',
        'chart_color' => $color,
        'where_raw' => 'status_eleve=1',


    ];

    $chart1 = new LaravelChart($chart_options1);

    $classe_ar = [];
    for ($i=1; $i <= 3 ; $i++) {
    $classe = Classe::where('nom_classe_fr','like',"$i%")->get();
    $text = "(";
    foreach ($classe as $key => $value) {
        $text .= $value->id_classe.',';
    }
    $text = substr($text, 0, -1);
    $text .= ")";
        array_push($classe_ar,$text);
    }

   foreach ($classe_ar as $key => $value) {
    $chart_options2 = [
        'chart_title' => ' التلاميذ حسب المستوى'.' '.$key+1,
        'report_type' => 'group_by_relationship',
        'model' => 'App\Models\Eleve',
        'relationship_name' => 'classe', // Name of the relationship method in Eleve model
        'group_by_field' => 'nom_classe_fr', // Concatenate the fields with a dot (.) separator
        'chart_type' => 'bar',
        'chart_color' => $color[$key],
        'where_raw' => 'status_eleve=1 AND id_classe IN '.$value,

    ];
    $chart2[] = new LaravelChart($chart_options2);
   }




   $color= array_reverse(explode(",",$settings->colors));
 //  dd($color);
    $chart_options3 = [
        'chart_title' => 'الغياب حسب المبرر',
        'report_type' => 'group_by_relationship',
        'model' => 'App\Models\Absence',
        'relationship_name' => 'motif_absence', // Name of the relationship method in Eleve model
        'group_by_field' => 'nom_motif', // Field in the related Classe model to group by
        'chart_type' => 'pie',
        'chart_color' => $color,
    ];

    $chart3 = new LaravelChart($chart_options3);
   // dd( $chart3);
    $chart_options4 = [
        'chart_title' => 'الغياب  غير المبرر',
        'report_type' => 'group_by_date',
        'model' => 'App\Models\Absence',
        'group_by_field' => 'date',
        'group_by_period' => 'day',
        'chart_type' => 'line',
        'filter_field' => 'date',
        'filter_days' => $settings->periode_jours, // show only last 30 days
        'where_raw' => 'status_absence=1'

    ];
    $chart_options5 = [
        'chart_title' => 'الغياب  المبرر',
        'report_type' => 'group_by_date',
        'model' => 'App\Models\Absence',
        'group_by_field' => 'date',
        'group_by_period' => 'day',
        'chart_type' => 'line',
        'filter_field' => 'date',
        'filter_days' => $settings->periode_jours, // show only last 30 days
        'where_raw' => 'status_absence>1'

    ];

    $chart4 = new LaravelChart($chart_options4,$chart_options5);

   // dd($chart4);

    $top_absent_eleves = Absence::join('eleves', 'absences.id_eleve', '=', 'eleves.id_eleve')
    ->where('absences.status_absence', '=', '1')
    ->selectRaw('eleves.id_eleve,eleves.id_classe,eleves.nom_fr,eleves.nom_ar,eleves.prenom_fr,eleves.prenom_ar,SUM(absences.total_jours) as total_days')
    ->groupBy('eleves.id_eleve','eleves.id_classe','eleves.nom_fr','eleves.nom_ar','eleves.prenom_fr','eleves.prenom_ar','eleves.id_eleve')
    ->havingRaw('SUM(absences.total_jours) >= '.$settings->nbr_jour_limit)
    ->orderbyDesc('total_days')
    ->paginate(5);

    $top_absent_eleves_seance = Absence::join('eleves', 'absences.id_eleve', '=', 'eleves.id_eleve')
    ->where('absences.status_absence', '=', '1')
    ->selectRaw('eleves.id_eleve,eleves.id_classe,eleves.nom_fr,eleves.nom_ar,eleves.prenom_fr,eleves.prenom_ar,SUM(absences.h1 + absences.h2 + absences.h3 + absences.h4 + absences.h5 + absences.h6 + absences.h7 + absences.h8) as total_seances')
    ->groupBy('eleves.id_eleve','eleves.id_classe','eleves.nom_fr','eleves.nom_ar','eleves.prenom_fr','eleves.prenom_ar','eleves.id_eleve')
    ->havingRaw('SUM(absences.h1 + absences.h2 + absences.h3 + absences.h4 + absences.h5 + absences.h6 + absences.h7 + absences.h8) >= '.$settings->nbr_seance_limit)
    ->orderbyDesc('total_seances')
    ->paginate(5);

    $absence_by_classes = DB::table('classes')
    ->select('classes.id_classe','classes.nom_classe_ar', 'classes.nom_classe_fr', DB::raw('SUM(absences.h1 + absences.h2 + absences.h3 + absences.h4 + absences.h5 + absences.h6 + absences.h7 + absences.h8) as nombre_seances'))
    ->join('eleves', 'classes.id_classe', '=', 'eleves.id_classe')
    ->join('absences', 'eleves.id_eleve', '=', 'absences.id_eleve')
    ->groupBy('classes.id_classe', 'classes.nom_classe_ar', 'classes.nom_classe_fr')->orderbyDesc('nombre_seances');


    $absence_data_array = [];

    foreach ($absence_by_classes->get() as $absence_data) {
        $nom_classe_ar = $absence_data->nom_classe_ar;
        $nom_classe_fr = $absence_data->nom_classe_fr;
        $nombre_seances = $absence_data->nombre_seances;

        if (!isset($absence_data_array[$nom_classe_ar])) {
            $absence_data_array[$nom_classe_ar] = [];
        }

        $absence_data_array[$nom_classe_ar][] = [
            'nom_classe_ar' => $nom_classe_ar,
            'nom_classe_fr' => $nom_classe_fr,
            'nombre_seances' => $nombre_seances,
        ];
    }
//dd( $absence_data_array);
    return view('homepage.index', compact('chart1', 'chart2','chart3','chart4','top_absent_eleves','top_absent_eleves_seance','absence_data_array'));

    }
}
