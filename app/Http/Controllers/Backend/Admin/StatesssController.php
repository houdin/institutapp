<?php

namespace App\Http\Controllers\Backend\Admin;


class StatesssController extends AbstractAdminController
{
    /**
     * Display a table of all states
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index', [
            'table' => 'admin._includes._tables._states'
        ]);
    }
}
