<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $setting =  Setting::where('id_user', Auth::user()->id)->first();

        // dd($requestData);
        $requestData = $request->all();
        $requestData['colors'] = implode(",", $request->color);
        //dd( $requestData );
        $setting->update($requestData);

        return redirect(route('home.index'));
    }

    /**
     * Summary of reset
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function reset(Request $request)
    {
        if ($request->ok) {


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

    public function read_notification(Request $request)
    {

        $notif = Notification::findOrFail($request->id_notif);
        $notif->update([
            "status_notif"=>1,
        ]);
        return redirect(route('home.index'));
    }
    public function change_password()
    {

        return view('auth.change_password');
    }

    /**
     * Summary of App\Http\Controllers\update_password
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update_password(Request $request)
    {
        $pass0 = $request->password;
        $pass1 = $request->password1;
        $pass2 = $request->password2;

        if (!Hash::check($pass0, auth::user()->password)) {
            return redirect()->back()->withErrors(['password' => 'كلمة السر غير صحيحة']);
        }

        if (strlen($pass1) < 8) {
            return redirect()->back()->withErrors(['password' => 'كلمة السر ضعيفة']);
        }

        if ($pass1 !== $pass2) {
            return redirect()->back()->withErrors(['password' => 'كلمتي السر غير متطابقتين']);
        }

        // Hash the new password securely
        $hashedPassword = Hash::make($pass1);

        // Update the user's password in the database
        $user = Auth::user();
        $user->update([
            "password" => $hashedPassword,
            "status_user" => 1
        ]);

        return redirect(route('home.index'))->with('success', 'Password updated successfully.');
    }
}
