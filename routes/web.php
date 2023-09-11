<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */
Route::prefix('/')->namespace('App\\Http\\Controllers\\')->middleware('auth')->group(function () {
     Route::get('/abs', function () {
        return view('pages.attestations.allocationfamiliale');
    });
    #Home
    Route::get('/','StatistiqueController@index')->name('home.index');
    Route::any('/save','HomeController@save')->name('home.save');
    Route::any('/reset','HomeController@reset')->name('home.reset');
    Route::any('/change_password','HomeController@change_password')->name('home.change_password');
    Route::any('/update_password','HomeController@update_password')->name('home.update_password');
    Route::post('/read_notification','HomeController@read_notification')->name('home.read_notification');

    #eleves
Route::prefix('eleves')->group(function () {
    Route::get('/','EleveController@index')->name('eleve.index');
    Route::get('/create','EleveController@create')->name('eleve.create');
    Route::get('/export','EleveController@export')->name('eleve.export');
    Route::get('/edit/{id_eleve}','EleveController@edit')->name('eleve.edit');
    Route::get("/details/{id_eleve}","EleveController@show")->name("eleve.details");
    Route::get("/filter/{name?}","EleveController@filter")->name("eleve.filter");
    Route::get("/filterByclasse/{name?}","EleveController@filterByclasse")->name("eleve.filterByclasse");
    Route::post("/save","EleveController@store")->name("eleve.save");
    Route::post("/update","EleveController@update")->name("eleve.update");
    Route::post("/uploadDocuments","EleveController@uploadDocuments")->name("eleve.uploadDocuments");
    Route::get("/delete/{id_eleve}","EleveController@destroy")->name("eleve.delete");

    Route::any("/importElevesData","ImportController@importElevesData")->name("eleve.importElevesData");
    Route::any("/importparentsData","ImportController@importparentsData")->name("eleve.importparentsData");

});

 #classes
 Route::prefix('classes')->group(function () {
    Route::get('/','ClasseController@index')->name('classe.index');
    Route::get("/filter/{name?}","ClasseController@filter")->name("classe.filter");
    Route::post("/save","ClasseController@store")->name("classe.save");
    Route::get("/delete/{id_classe}","ClasseController@destroy")->name("classe.delete");
});



#Absences
Route::prefix('absences')->group(function () {
    Route::get('/','AbsenceController@index')->name('absence.index');
    Route::get('/filter_collective','AbsenceController@filter_collective')->name('absence.filter_collective');
    Route::any('/saveSelected','AbsenceController@saveSelected')->name('absence.saveSelected');
    Route::any('/generateAll','AbsenceController@generateAll')->name('absence.generateAll');
    Route::get("/liste_absence","AbsenceController@liste_absence")->name("absence.liste_absence");
    Route::any('/generateListes/{id_classe}','AbsenceController@generateListes')->name('absence.generateListes');
    Route::get('/absence_collective','AbsenceController@absence_collective')->name('absence.absence_collective');
    Route::get('/filter','AbsenceController@filter')->name('absence.filter');
    Route::any('/pdf', 'AbsenceController@generatePdf')->name('absence.generate');
    Route::get('/create','AbsenceController@create')->name('absence.create');
    Route::get('/edit/{id_eleve?}','AbsenceController@edit')->name('absence.edit');
    Route::get("/details/{id_absence}","AbsenceController@show")->name("absence.details");
    Route::get("/change_statut/{name?}","AbsenceController@change_statut")->name("absence.change_statut");
    Route::get("/filterHistory/{name?}","AbsenceController@filterHistory")->name("absence.filterHistory");
    Route::any("/save","AbsenceController@store")->name("absence.save");
    Route::any("/update","AbsenceController@update")->name("absence.update");
    Route::post("/uploadDocuments","AbsenceController@uploadDocuments")->name("absence.uploadDocuments");
    Route::get("/delete/{id_absence}","AbsenceController@destroy")->name("absence.delete");
    Route::get('/export_word_demandeabsence', 'AbsenceController@export_word_demandeabsence')->name('attestation.export_word_demandeConge');
});

#motifAbsences
Route::prefix('motifAbsences')->group(function () {
    Route::get('/','MotifAbsenceController@index')->name('motifAbsence.index');
    Route::get("/filter/{name?}","MotifAbsenceController@filter")->name("motifAbsence.filter");
    Route::get("/filterBymotifAbsence/{name?}","MotifAbsenceController@filterBymotifAbsence")->name("motifAbsence.filterBymotifAbsence");
    Route::any("/save","MotifAbsenceController@store")->name("motifAbsence.save");
    Route::get("/delete/{id_motif}","MotifAbsenceController@destroy")->name("motifAbsence.delete");
});

 #seances
 Route::prefix('seances')->group(function () {
    Route::get('/','SeanceController@index')->name('seance.index');
    Route::get("/filter/{name?}","SeanceController@filter")->name("seance.filter");
    Route::post("/save","SeanceController@store")->name("seance.save");
    Route::any("/update","SeanceController@update")->name("seance.update");
    Route::get("/delete/{id_seance}","SeanceController@destroy")->name("seance.delete");
});

});

Auth::routes();
//Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
