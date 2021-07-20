<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TypeAnalogicalInput;
use App\Models\TypeAnalogicalOutput;
use App\Models\TypeDigitalInput;
use App\Models\TypeDigitalOutput;

class OutputInputController extends Controller
{
    /**
     * Display all analogicalInput
     * 
     * @return \Illuminate\Http\Response
     */
    public function getAnalogicalInput()
    {
    
        return TypeAnalogicalInput::all();
    }

    /**
     * Display all analogicalOutput
     * 
     * @return \Illuminate\Http\Response
     */
    public function getAnalogicalOutput()
    {
        return TypeAnalogicalOutput::all();
    }

    /**
     * Display all dialogicalInput
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDigitalInput()
    {
        return TypeDigitalInput::all();
    }

    /**
     * Display all dialogicalOutput
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDigitalOutput()
    {
        return TypeDigitalOutput::all();
    }
}
