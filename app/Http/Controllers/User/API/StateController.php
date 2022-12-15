<?php

namespace App\Http\Controllers\User\API;


use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class StateController extends AbstractUserAPIController
{
    /**
     * gets all states
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $states = State::all()->pluck('name', 'id')->toArray();
        } catch (\Exception $exception) {
            return $this->hasError('Sorry there was an issue processing your request', 422);
        }

        return response()->json([
            'states' => $states
        ], 200);
    }
}
