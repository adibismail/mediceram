<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\MouldModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class MouldModelsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $mould_models = MouldModel::get();
        
        return Inertia::render('MouldModels/Index', [
            'mould_models' => $mould_models,
        ]);
    }

    public function store(Request $request, MouldModel $mould_model) {
        //Log::channel('post_mould_models_data_logger')->info($request->all());
        
        $mould_model->create(
            $this->validate($request, [
                'mould_mdl_id' => ['required', 'unique:mould_models,mould_mdl_id', 'max:10'],
                'description' => ['max:200'],
            ])
        );

        return Redirect::route('mould-models')->with('success_msg', 'Mould model created.');
    }

    public function update(Request $request) {
        //Log::channel('post_mould_models_data_logger')->info($request->all());

        $mould_model = MouldModel::find($request->mould_mdl_tbl_id);
        
        $mould_model->update(
            $this->validate($request, [
                'mould_mdl_id' => ['required', 'unique:mould_models,mould_mdl_id,' . $request->mould_mdl_tbl_id . ',mould_mdl_tbl_id', 'max:10'],
                'description' => ['max:200'],
            ])
        );

        return Redirect::route('mould-models')->with('success_msg', 'Mould model updated.');
    }

    public function delete(Request $request) {
        //Log::channel('post_mould_models_data_logger')->info($request);

        try {
            MouldModel::destroy($request->mould_mdl_tbl_id);
            return redirect()->back()->with('success_msg', 'Mould model deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_msg', 'Mould model could not be deleted as it is already tied with some plaster moulds and/or orders.');
        }
    }
}
