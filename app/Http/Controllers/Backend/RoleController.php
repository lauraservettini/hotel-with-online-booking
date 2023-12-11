<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use DB;

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

    public function roles()
    {
        $roles = Role::latest()->get();

        return view('backend.roles.roles', compact('roles'));
    }

    public function addRole()
    {
        return view('backend.roles.add_role');
    }

    public function storeRole(Request $request)
    {
        //Validation
        $request->validate([
            "name" => "required"
        ]);

        // salva i dati nel database 
        Role::create([
            'name' => $request->name
        ]);

        // invia notifica
        $notification = array(
            'message' => 'Role Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('roles')->with($notification);
    }

    public function editRole(int $id)
    {
        $role = Role::find($id);

        return view('backend.roles.update_role', compact('role'));
    }

    public function updateRole(Request $request, int $id)
    {
        //Validation
        $request->validate([
            "name" => "required"
        ]);

        $role = Role::find($id);

        // aggiorna i dati nel database 
        $role->update([
            'name' => $request->name
        ]);

        // invia notifica
        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('roles')->with($notification);
    }

    public function deleteRole(int $id)
    {
        Role::find($id)->delete();

        // invia notifica
        $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('roles')->with($notification);
    }

    public function addRolesPermission()
    {
        $roles = Role::all();
        // $permissions = Permission::all();
        $permissionGroups = User::getPermissionGroups();

        return view('backend.roles.add_roles_permission', compact('roles', 'permissionGroups'));
    }

    public function storeRolePermissions(Request $request)
    {
        //Validation
        $request->validate([
            "role_id" => "required",
            "permission" => "required"
        ]);

        $data = array();
        $permissions = $request->permission;

        foreach ($permissions as $key => $permission) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $permission;

            DB::table('role_has_permissions')->insert($data);
        } // end foreach

        $notification = array(
            'message' => 'Role Permissions Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('roles.permission')->with($notification);
    }

    public function rolesPermission()
    {
        $roles = Role::all();
        return view('backend.roles.all_roles_permission', compact('roles'));
    }

    public function adminRolesPermission(int $id)
    {

        $role = Role::find($id);
        // $permissions = Permission::all();
        $permissionGroups = User::getPermissionGroups();
        return view('backend.roles.edit_roles_permission', compact('role', 'permissionGroups'));
    }

    public function updateRolePermissions(Request $request, int $id)
    {
        //Validation
        $request->validate([
            "permission" => "required"
        ]);

        $role = Role::find($id);
        $permissions = $request->permission;

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        $notification = array(
            'message' => 'Role Permissions Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('roles.permission')->with($notification);
    }

    public function deleteRolePermissions(int $id)
    {
        $role = Role::find($id);

        if (!is_null($role)) {
            $role->delete();
        }

        // invia notifica
        $notification = array(
            'message' => 'Role and Role Permissions Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('roles')->with($notification);
    }
}
