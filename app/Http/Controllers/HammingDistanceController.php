<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HammingDistanceController extends Controller
{
    public function index()
    {
        return view('hamming_distance.index');
    }

    public function compute(Request $request)
    {
        $data = [];

        $max_value = pow(2,31);

        $this->validate($request, [
            'xVal' => 'required|integer|min:0|max:' . $max_value,
            'yVal' => 'required|integer|min:0|max:' . $max_value,
        ]);

        //notes x <= 0, and y < 2 raise 31
        $xVal = $request->xVal;
        $yVal = $request->yVal;
        $xValBin = decbin($xVal);
        $yValBin = decbin($yVal);
        $counter = $xVal < $yVal ? strlen($yValBin) : strlen($xValBin);
        $xValBin = str_pad($xValBin, $counter,0,STR_PAD_LEFT);
        $yValBin = str_pad($yValBin, $counter,0,STR_PAD_LEFT);

        $hamming_distance = 0;
        for($i = 0; $i < $counter; $i++) {
            $x = $xValBin[$i];
            $y = $yValBin[$i];
            if($x != $y) {$hamming_distance++;}
        }
        $data['answer'] = $hamming_distance;
        $data['xValBin'] = $xValBin;
        $data['yValBin'] = $yValBin;
        $request->flash();
        return view('hamming_distance.index',$data);
    }
}
