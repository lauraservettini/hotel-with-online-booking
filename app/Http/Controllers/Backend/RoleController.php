<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Maatwebsite\Excel\Facades\Excel;

class RoleController extends Controller
{
    public function permissions()
    {
        $permissions = Permission::latest()->get();

        return view('backend.permissions.permissions', compact('permissions'));
    }

    public function addPermission()
    {
        return view('backend.permissions.add_permission');
    }

    public function storePermission(Request $request)
    {
        //Validation
        $request->validate([
            "name" => "required",
            "group_name" => "required"
        ]);

        // salva i dati nel database 
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name
        ]);

        // invia notifica
        $notification = array(
            'message' => 'Permision Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('permissions')->with($notification);
    }

    public function editPermission(int $id)
    {
        $permission = Permission::find($id);

        return view('backend.permissions.update_permission', compact('permission'));
    }

    public function updatePermission(Request $request, int $id)
    {
        //Validation
        $request->validate([
            "name" => "required",
            "group_name" => "required"
        ]);

        $permission = Permission::find($id);

        // aggiorna i dati nel database 
        $permission->update([
            'name' => $request->name,
            'group_name' => $request->group_name
        ]);

        // invia notifica
        $notification = array(
            'message' => 'Permision Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('permissions')->with($notification);
    }

    public function deletePermission(int $id)
    {
        $permission = Permission::find($id)->delete();

        // invia notifica
        $notification = array(
            'message' => 'Permision Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('permissions')->with($notification);
    }

    public function importPermission()
    {
        return view('backend.permissions.import_permission');
    }

    public function exportPermission()
    {
        return Excel::download(new PermissionExport, 'permissions.xlsx');
    }

    public function storeImportPermission(Request $request)
    {
        Excel::import(new PermissionImport, $request->file('import_file'));

        // invia notifica
        $notification = array(
            'message' => 'Permision Imported Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('permissions')->with($notification);
    }
}
