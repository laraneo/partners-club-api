<?php

use App\Locker;
use App\LockerLocation;
use Illuminate\Database\Seeder;

class LockerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $data = [
                [ 
                    'description' => 'Locker #1',
                    'location' => 'Ubicacion 1',
                ],
                [ 
                    'description' => 'Locker #2',
                    'location' => 'Ubicacion 1',
                ],
                [ 
                    'description' => 'Locker #3',
                    'location' => 'Ubicacion 2',
                ],
                [ 
                    'description' => 'Locker #4',
                    'location' => 'Ubicacion 2',
                ],
            ];
            foreach ($data as $element) {
                $location = LockerLocation::where('description',$element['location'])->first();
                Locker::create([
                    'description' => $element['description'],
                    'locker_location_id' => $location->id,
                ]);
            }
        }
    }
}
