<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GraveSeeder extends Seeder
{
    public function run(): void
    {
        // Block boundaries (each block polygon: TR, TL, BL, BR)
        $blocks = [
            'A' => [
                [24.936846796868508, 66.94132833460642], // top right
                [24.93667776199227, 66.94093807320208],  // top left
                [24.936520887690858, 66.94103999714241], // bottom left
                [24.9366716815965, 66.94141282418855],   // bottom right
            ],
            'B' => [
                [24.936651008248518, 66.94144769290406], // top right
                [24.936506294721397, 66.94105609039644], // top left
                [24.9362861839029, 66.94119288305399],   // bottom left
                [24.936429681607247, 66.9415469346362],  // bottom right
            ],
            'C' => [
                [24.936394415235096, 66.94156839230892], // top right
                [24.936264294405436, 66.94121434072669], // top left
                [24.93600770059107, 66.94137661436855],  // bottom left
                [24.93615849512491, 66.94167970398061],  // bottom right
            ],
            'D' => [
                [24.93686412582197, 66.94137393307061],  // top left
                [24.936989380905622, 66.94165958648023], // top right
                [24.93681183464252, 66.94178565123627],  // bottom right
                [24.936685362490714, 66.94147317389287], // bottom left
            ],
            'E' => [
                [24.93678629700278, 66.94178699234577],  // top right
                [24.936664689141715, 66.94148390273371], // top left
                [24.936434849956036, 66.94159387330092], // bottom left
                [24.936567402766425, 66.94191573837567], // bottom right
            ],
            'F' => [
                [24.9365406489956, 66.94194256046657],   // top right
                [24.936408096156892, 66.94160191992911], // top left
                [24.936164879568278, 66.9417199371232],  // bottom left
                [24.936342427725283, 66.94208471754126], // bottom right
            ],
        ];

        $id = 1;

        foreach ($blocks as $blockName => $boundary) {
            [$TR, $TL, $BL, $BR] = $boundary;

            $rows = 10; // adjust per block
            $cols = 20; // adjust per block

            for ($r = 0; $r < $rows; $r++) {
                for ($c = 0; $c < $cols; $c++) {
                    // interpolate inside polygon
                    $latTop = $TL[0] + ($TR[0] - $TL[0]) * ($c / $cols);
                    $lngTop = $TL[1] + ($TR[1] - $TL[1]) * ($c / $cols);
                    $latBottom = $BL[0] + ($BR[0] - $BL[0]) * ($c / $cols);
                    $lngBottom = $BL[1] + ($BR[1] - $BL[1]) * ($c / $cols);

                    $lat = $latTop + ($latBottom - $latTop) * ($r / $rows);
                    $lng = $lngTop + ($lngBottom - $lngTop) * ($r / $rows);

                    // update or insert (safe with foreign keys)
                    DB::table('graves')->updateOrInsert(
                        ['id' => $id],
                        [
                            'registration_id' => null,
                            'user_id' => null,
                            'location' => null,
                            // only reset status if grave is not booked
                            'status' => DB::raw("IF(status='booked', status, 'available')"),
                            'lat' => $lat,
                            'lng' => $lng,
                            'block' => $blockName,
                            'updated_at' => now(),
                        ]
                    );

                    $id++;
                }
            }
        }
    }
}
