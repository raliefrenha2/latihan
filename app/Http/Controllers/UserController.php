<?php

namespace App\Http\Controllers;

use App\User;
use Yajra\DataTables\Contracts\DataTable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
// use App\Http\Controllers\Controller;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new User();
        return view('pages.user.form', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>   'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email'
        ]);

        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = User::findOrFail($id);
        return view('pages.user.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::findOrFail($id);
        return view('pages.user.form', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' =>   'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $id
        ]);

        $model = User::findOrFail($id);
        $model->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = User::findOrFail($id);
        $model->delete();

        // User::destroy($id);
    }

    public function userExport()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function dataTable()
    {
        $model = User::query();
        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                return view('layouts._action', [
                    'model' => $model,
                    'url_show' => route('user.show', $model->id),
                    'url_edit' => route('user.edit', $model->id),
                    'url_destroy' => route('user.destroy', $model->id),
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make('true');
    }
}
