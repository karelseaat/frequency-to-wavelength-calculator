<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    const SPEED_OF_LIGHT = 299792458; // meters per second

    public function index()
    {
        return view('calculator');
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'calculation_type' => 'required|in:freq_to_wave,wave_to_freq',
            'value' => 'required|numeric|min:0',
            'frequency_unit' => 'sometimes|in:hz,khz,mhz,ghz',
            'wavelength_unit' => 'sometimes|in:m,cm,mm',
        ]);

        $calculationType = $validated['calculation_type'];
        $value = $validated['value'];
        $result = 0;

        if ($calculationType == 'freq_to_wave') {
            $frequency_unit = $validated['frequency_unit'];
            $frequency = $this->toHz($value, $frequency_unit);
            $wavelength = self::SPEED_OF_LIGHT / $frequency;
            $result = "Wavelength: " . round($wavelength, 4) . " meters";
        } else {
            $wavelength_unit = $validated['wavelength_unit'];
            $wavelength = $this->toMeters($value, $wavelength_unit);
            $frequency = self::SPEED_OF_LIGHT / $wavelength;
            $result = "Frequency: " . round($this->fromHz($frequency), 4) . " MHz";
        }

        return view('calculator', ['result' => $result]);
    }

    private function toHz($value, $unit)
    {
        return match ($unit) {
            'khz' => $value * 1e3,
            'mhz' => $value * 1e6,
            'ghz' => $value * 1e9,
            default => $value,
        };
    }

    private function fromHz($value)
    {
        return $value / 1e6; // Return in MHz for simplicity
    }

    private function toMeters($value, $unit)
    {
        return match ($unit) {
            'cm' => $value / 100,
            'mm' => $value / 1000,
            default => $value,
        };
    }
}
