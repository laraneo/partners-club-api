<?php

use App\Widget;
use App\Role;
use App\WidgetRole;
use Illuminate\Database\Seeder;

class WidgetTableSeeder extends Seeder
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
                'name' => 'PARTNERPORTAL_saldo', 
                'slug' => 'PARTNERPORTAL_saldo',
                'description' => 'Widget Saldo',
                'role' => ['administrador','socio']
            ],
            [ 
                'name' => 'PARTNERCONTROL_socios', 
                'slug' => 'PARTNERCONTROL_socios',
                'description' => 'Widget Socios',
                'role' => ['administrador', 'gerente']
            ],
            [ 
                'name' => 'PARTNERCONTROL_familiares', 
                'slug' => 'PARTNERCONTROL_familiares',
                'description' => 'Widget Familiares',
                'role' => ['administrador']
            ],
            [ 
                'name' => 'PARTNERCONTROL_invitados', 
                'slug' => 'PARTNERCONTROL_invitados',
                'description' => 'Widget Invitados',
                'role' => ['administrador']
            ],
            [ 
                'name' => 'PARTNERCONTROL_totales', 
                'slug' => 'PARTNERCONTROL_totales',
                'description' => 'Widget Totales',
                'role' => ['administrador']
            ],
            [ 
                'name' => 'PARTNERCONTROL_bloqueo-expediente', 
                'slug' => 'PARTNERCONTROL_bloqueo-expediente',
                'description' => 'Widget Bloqueo Expedientes',
                'role' => ['administrador']
            ],
            [ 
                'name' => 'PARTNERCONTROL_lista-excepcion', 
                'slug' => 'PARTNERCONTROL_lista-excepcion',
                'description' => 'Widget Bloqueo Expedientes',
                'role' => ['administrador']
            ],
            [ 
                'name' => 'PARTNERCONTROL_tdc-por-vencer', 
                'slug' => 'PARTNERCONTROL_tdc-por-vencer',
                'description' => 'Widget Tarjetas de Credito por Vencer',
                'role' => ['administrador']
            ],
            [ 
                'name' => 'PARTNERCONTROL_cumpleanos', 
                'slug' => 'PARTNERCONTROL_cumpleanos',
                'description' => 'Widget Cumpleanos',
                'role' => ['administrador', 'gerente']
            ],
            [ 
                'name' => 'PARTNERCONTROL_ingreso-socios-familiares', 
                'slug' => 'PARTNERCONTROL_ingreso-socios-familiares',
                'description' => 'Grafico de Ingresos de Socios/Familiares por mes',
                'role' => ['administrador', 'gerente']
            ],
            [ 
                'name' => 'PARTNERCONTROL_ingreso-invitados', 
                'slug' => 'PARTNERCONTROL_ingreso-invitados',
                'description' => 'Grafico de Ingresos de Invitados por mes',
                'role' => ['administrador', 'gerente']
            ],
        ];
        foreach ($data as $element) {
            $widget = Widget::create([
                'name' => $element['name'],
                'slug' => $element['slug'],
                'description' => $element['description'],
            ]);
            foreach ($element['role'] as $key => $value) {
                $role = Role::where('slug', $value)->first();
                WidgetRole::create([
                    'widget_id' => $widget->id,
                    'role_id' => $role->id,
                ]);
            }
        }
    }
}
