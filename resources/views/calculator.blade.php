<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequency to Wavelength Calculator</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; background-color: #f4f4f4; }
        .container { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h1 { text-align: center; color: #333; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; color: #555; }
        input, select { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 0.75rem; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        .results { margin-top: 2rem; text-align: center; }
        .results h2 { color: #333; }
        .results p { background: #e9e9e9; padding: 1rem; border-radius: 4px; font-size: 1.2rem; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Frequency &rightleftarrows; Wavelength</h1>
        <form action="/calculator" method="POST">
            @csrf
            <div class="form-group">
                <label for="calculation_type">Calculation</label>
                <select id="calculation_type" name="calculation_type">
                    <option value="freq_to_wave">Frequency to Wavelength</option>
                    <option value="wave_to_freq">Wavelength to Frequency</option>
                </select>
            </div>
            <div class="form-group">
                <label for="value">Value</label>
                <input type="number" step="any" id="value" name="value" required>
            </div>
            <div class="form-group" id="freq_units_group">
                <label for="frequency_unit">Frequency Unit</label>
                <select id="frequency_unit" name="frequency_unit">
                    <option value="hz">Hz</option>
                    <option value="khz">kHz</option>
                    <option value="mhz">MHz</option>
                    <option value="ghz">GHz</option>
                </select>
            </div>
            <div class="form-group" id="wave_units_group" style="display: none;">
                <label for="wavelength_unit">Wavelength Unit</label>
                <select id="wavelength_unit" name="wavelength_unit">
                    <option value="m">m</option>
                    <option value="cm">cm</option>
                    <option value="mm">mm</option>
                </select>
            </div>
            <button type="submit">Calculate</button>
        </form>
        @if(isset($result))
        <div class="results">
            <h2>Result</h2>
            <p>{{ $result }}</p>
        </div>
        @endif
    </div>
    <script>
        document.getElementById('calculation_type').addEventListener('change', function() {
            if (this.value === 'freq_to_wave') {
                document.getElementById('freq_units_group').style.display = 'block';
                document.getElementById('wave_units_group').style.display = 'none';
            } else {
                document.getElementById('freq_units_group').style.display = 'none';
                document.getElementById('wave_units_group').style.display = 'block';
            }
        });
    </script>
</body>
</html>
