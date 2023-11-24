<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class TeamController extends Controller
{
    public function allTeam()
    {
        $team = Team::latest()->get();
        return view(
            'backend.team.all_team',
            compact('team')
        );
    }

    public function getAddTeam()
    {
        return view(
            'backend.team.add_team'
        );
    }

    public function postAddTeam(Request $request)
    {
        //Validation
        $request->validate([
            "name" => "required",
            "position" => "required",
            "facebook" => "required",
            "image" => "required"
        ]);

        $image = $request->file('image');
        if ($image) {
            // Crea il nome per l'immagine
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // resize image
            Image::make($image)->resize(550, 670)->save('upload/team_images/' . $name_gen);
            $save_url = 'upload/team_images/' . $name_gen;

            // salva i dati nel database con l'immagine
            Team::insert([
                'name' => $request->name,
                'position' => $request->position,
                'image' => $save_url,
                'facebook' => $request->facebook,
                'created_at' => Carbon::now()
            ]);
        } else {
            // salva i dati nel database senza immagine
            Team::insert([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'created_at' => Carbon::now()
            ]);
        }

        // invia notifica
        $notification = array(
            'message' => 'Team Data Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.team')->with($notification);
    }

    public function getEdit($id)
    {
        $team = Team::findOrFail($id);

        return view('backend.team.edit_team', compact('team'));
    }

    public function postEdit(int $id, Request $request)
    {
        //Validation
        $request->validate([
            "name" => "required",
            "position" => "required",
            "facebook" => "required"
        ]);

        if ($request->file('image')) {
            // Crea il nome per l'immagine
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $team = Team::findOrFail($id);
            $oldImage = $team->image;


            // resize image
            Image::make($image)->resize(550, 670)->save('upload/team_images/' . $name_gen);
            $save_url = 'upload/team_images/' . $name_gen;

            // aggiorna i dati nel database con l'immagine
            $team->update([
                'name' => $request->name,
                'position' => $request->position,
                'image' => $save_url,
                'facebook' => $request->facebook,
                'created_at' => Carbon::now()
            ]);

            // cancella la vecchia immagine da upload/admin_images
            @unlink(public_path($oldImage));

            // invia notifica
            $notification = array(
                'message' => 'Team Updated With Image Successfully',
                'alert-type' => 'success'
            );
        } else {
            // salva i dati nel database
            Team::findOrFail($id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'created_at' => Carbon::now()
            ]);

            // invia notifica
            $notification = array(
                'message' => 'Team Updated Without Image Successfully',
                'alert-type' => 'success'
            );
        }

        return redirect()->route('all.team')->with($notification);
    }

    public function delete($id)
    {
        $team = Team::findOrFail($id);

        // cancella i dati nel database 
        $team->delete();

        if ($team->image) {
            // Salva il nome per l'immagine
            $image = $team->image;


            // cancella la vecchia immagine da upload/admin_images
            @unlink(public_path($image));
        }

        // invia notifica
        $notification = array(
            'message' => 'Team Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
