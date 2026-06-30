 <?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GraveSeeder extends Seeder
{
    public function run(): void
{

    $rows = 20;   // adjust as needed
    $cols = 60;   // 20 * 60 = 1200 graves

    // boundary corners
    $FR = [24.937069180177446, 66.94162743458993];
    $FL = [24.936704357071687, 66.94090860264023];
    $BL = [24.93598930065126, 66.94138067138331];
    $BR = [24.936334668556064, 66.94210486775054];

    for ($r = 0; $r < $rows; $r++) {
        for ($c = 0; $c < $cols; $c++) {
            $id = $r * $cols + $c + 1;
            if ($id > 1200) break;

            // interpolate lat/lng inside boundary
            $latTop = $FL[0] + ($FR[0] - $FL[0]) * ($c / $cols);
            $lngTop = $FL[1] + ($FR[1] - $FL[1]) * ($c / $cols);
            $latBottom = $BL[0] + ($BR[0] - $BL[0]) * ($c / $cols);
            $lngBottom = $BL[1] + ($BR[1] - $BL[1]) * ($c / $cols);

            $lat = $latTop + ($latBottom - $latTop) * ($r / $rows);
            $lng = $lngTop + ($lngBottom - $lngTop) * ($r / $rows);

            DB::table('graves')->updateOrInsert(
                ['id' => $id],
                [
                    'registration_id' => null,
                    'user_id' => null,
                    'location' => null,
                    'status' => 'available',
                    'lat' => $lat,
                    'lng' => $lng,
                    'block' => $id <= 200 ? 'A' :
                               ($id <= 400 ? 'B' :
                               ($id <= 600 ? 'C' :
                               ($id <= 800 ? 'D' :
                               ($id <= 1000 ? 'E' : 'F'))))
                ]
            );
        }
    }
}

} 
