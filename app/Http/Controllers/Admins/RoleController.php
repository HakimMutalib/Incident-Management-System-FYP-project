<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware(['role:super-admin|admin|moderator']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return inertia::render('Admins/Roles/Index',[
        'roles' => Role::with('permissions')->paginate(5),
        'permissions' => Permission::all(), 
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if (auth()->user()->hasAnyRole(['super-admin','admin'])){
            $this->validate($request,[
                'name' =>['required','max:25','unique:roles'],
                'permissions' => 'required'
            ]);
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            if ($request->has('permissions')){
                $role->givePermissionTo(collect($request->permissions)->pluck('id')->toArray());
            }
            return back();
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Role $role)
    {   if (auth()->user()->hasAnyRole(['super-admin','admin'])){
            $this->validate($request,[
                'name' =>['required','max:25'],
                'permissions' => 'required'
            ]);
            if ($request->has('permissions')){
                $role->givePermissionTo(collect($request->permissions)->pluck('id')->toArray());
            }
            $role->syncPermissions(collect($request->permissions)->pluck('id')->toArray());
                $role->update(['name' => $request->name]);
                return back();
        }
        return back();
    }

   /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {   if (auth()->user()->hasAnyRole(['super-admin','admin'])){
            $role->delete();
            return back();
        }
    return back();
    }
}
