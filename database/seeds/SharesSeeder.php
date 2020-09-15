<?php

use App\Share;
use App\Person;
use App\ShareType;
use Illuminate\Database\Seeder;

class SharesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 
                'share_number' => '120610',
                'father_share_id' => 0,
                'status' => 1,
                'payment_method_id' => 2,
                'person' => '18934599',
                'owner' => '21106197',
                'invoice' => '6138049',
                'fiador' => '7998168',
                'share_type' => 'Propietario',
            ],
            [ 
                'share_number' => '120611',
                'father_share_id' => 1,
                'status' => 1,
                'payment_method_id' => 1,
                'person' => '18934599',
                'owner' => '21106197',
                'invoice' => '6138049',
                'fiador' => '7998168',
                'share_type' => 'Propietario',
            ],
            [ 
                'share_number' => '120612',
                'father_share_id' => 1,
                'status' => 1,
                'payment_method_id' => 2,
                'person' => '18934576',
                'owner' => '21106197',
                'invoice' => '6138049',
                'fiador' => '7998168',
                'share_type' => 'Propietario',
            ],
        ];
        foreach ($data as $element) {
            $person = Person::where('rif_ci',$element['person'])->first();
            $owner = Person::where('rif_ci',$element['owner'])->first();
            $invoice = Person::where('rif_ci',$element['invoice'])->first();
            $fiador = Person::where('rif_ci',$element['fiador'])->first();
            $share = ShareType::where('description', $element['share_type'])->first();
            Share::create([
                'share_number' => $element['share_number'],
                'father_share_id' => $element['father_share_id'],
                'status' => $element['status'],
                'payment_method_id' => $element['payment_method_id'],
                'id_persona' => $person->id,
                'id_titular_persona' => $owner->id,
                'id_factura_persona' => $invoice->id,
                'id_fiador_persona' => $fiador->id,
                'share_type_id' => $share ? $share->id : null,
            ]);
        }
    }
}
