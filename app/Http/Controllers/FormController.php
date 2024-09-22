<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{

    public function showArtifactForm() {

        return view('admin.pages.addData');
    }

    public function submitArtifactForm(Request $request) {

        $request->session()->flash('message', 'Success!');

        return redirect()->route('Eserler');
    }

    public function showMemberForm() {
        return view('admin.pages.addMember');
    }

    public function submitMemberForm(Request $request, int $id)
    {
        dd($request->email, $request->name, $id);
        dd($request->get('name'));
    }
}
