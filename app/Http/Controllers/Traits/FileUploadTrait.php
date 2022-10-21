<?php

namespace App\Http\Controllers\Traits;

use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait as FileUploadTraitMaster;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{

    use FileUploadTraitMaster {
        FileUploadTraitMaster::saveFiles as parentSaveFiles;
        FileUploadTraitMaster::saveAllFiles as parentSaveAllFiles;
        FileUploadTraitMaster::saveLogos as parentSaveLogos;
    }

    /**
     * File upload trait used in controllers to upload files
     */
    public function saveFiles(Request $request)
    {
        $finalRequest = $this->parentSaveFiles($request);

        return $finalRequest;
    }


    public function saveAllFiles(Request $request, $downloadable_file_input = null, $model_type = null, $model = null)
    {
        $finalRequest = $this->parentSaveAllFiles($request, $downloadable_file_input, $model_type, $model);

        return $finalRequest;
    }

    public function saveLogos(Request $request)
    {
        $finalRequest = $this->parentSaveLogos($request);

        return $finalRequest;
    }
}
