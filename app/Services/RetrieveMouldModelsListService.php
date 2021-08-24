<?php

namespace App\Services;

use App\Models\MouldModel;

class RetrieveMouldModelsListService
{
    public function RetrieveMouldModelsList()
    {
        $mould_models_list = [];

        $mould_models = MouldModel::select('mould_mdl_tbl_id', 'mould_mdl_id')
            ->get();

        foreach ($mould_models as $mould_model) {
            $mould_models_list[$mould_model->mould_mdl_tbl_id] = $mould_model->mould_mdl_id;
        }

        return $mould_models_list;
    }
}
