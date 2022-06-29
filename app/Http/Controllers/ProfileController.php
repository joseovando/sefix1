<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\UsersSpecific;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $paises = DB::table('paises')
            ->where('estado', '=', 1)
            ->orderBy('nombre_pais', 'ASC')
            ->get();

        $vistaUsersSpecific = DB::table('vista_users_specific')
            ->where('id', '=', auth()->id())
            ->where('estado', '=', 1)
            ->orderBy('name', 'ASC')
            ->first();

        return view('profile.edit', compact(
            'paises',
            'vistaUsersSpecific'
        ));
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        $id_user_specific = request('id_user_specific') + 0;
        $fecha_nacimiento = request('fecha_nacimiento');
        $fecha_nacimiento = explode('/', request('fecha_nacimiento'));
        $fecha_nacimiento_convert = $fecha_nacimiento[2] . "-" . $fecha_nacimiento[1] . "-" . $fecha_nacimiento[0];

        if ($id_user_specific == 0) {
            $usersSpecific = new UsersSpecific();
            $usersSpecific->id_user = auth()->id();
            $usersSpecific->fecha_nacimiento = $fecha_nacimiento_convert;
            $usersSpecific->id_pais = request('pais');
            $usersSpecific->estado = 1;
            $usersSpecific->save();
        } else {
            $usersSpecific = UsersSpecific::where([
                ['id', $id_user_specific],
                ['id_user', auth()->id()],
            ])->first();

            $usersSpecific->fecha_nacimiento = $fecha_nacimiento_convert;
            $usersSpecific->id_pais = request('pais');
            $usersSpecific->update();
        }

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withStatusPassword(__('Password successfully updated.'));
    }
}
