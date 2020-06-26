<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Info;

class InfoController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'age' => 'required|integer',
            'city' => 'required',
            'address' => 'required',
            'phoneNum' => 'required|integer'
        ]);
 
        $info = new Info();
        $info->age = $request->age;
        $info->city = $request->city;
        $info->address = $request->address;
        $info->phoneNum = $request->phoneNum;
 
        if (auth()->user()->infos()->save($info))
            return response()->json([
                'success' => true,
                'data' => $info->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'User Information could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $info = auth()->user()->infos()->find($id);

        if (!$info) {
            return response()->json([
                'success' => false,
                'message' => 'User with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $info->fill($request->all())->save();

        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'User Information could not be updated'
            ], 500);
    }
}
