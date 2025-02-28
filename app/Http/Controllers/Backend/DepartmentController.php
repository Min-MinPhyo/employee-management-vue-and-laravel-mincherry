<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStoreRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments=Department::all();

        if($request->has('search')){
            $departments=Department::where('name','like',"%{$request->search}%")->get();
        }
        return view('departments.index',compact('departments'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentStoreRequest $request)
    {
    Department::create($request->validated());

    return redirect()->route('departments.index')->with('message','Department Created Successfully !')
;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('departments.edit',compact('department'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentStoreRequest $request,Department $department)
    {
        $department->update([
            'name'=>$request->name
        ]);

        return redirect()->route('departments.index')->with('message','Department update Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('message','Department delete successfully!');
    }

}
