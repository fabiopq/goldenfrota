<?php

use Illuminate\Database\Seeder;

class GroupSettingAutomacaoSeeder extends Seeder
{
    /**
     * 
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = \App\GroupSetting::create([
            'group_name' => 'Automação'
        ]);

        $group->settings()->createMany([
            [
                'description' => 'Utiliza Preço Cadastro Combustivel',
                'key' => 'automacao_valor_combustivel',
                'data_type' => 'boolean',
                'value' => false
            ]
        ]);

        DB::table('settings')->insert([
            [
                'description' => 'Utiliza Preço Cadastro Combustivel',
                'key' => 'automacao_valor_combustivel',
                'value' => true,
                'data_type' => 'boolean',
                'group_setting_id' => 3
            ],
            [
                'description' => 'Utiliza Tag Cadastro',
                'key' => 'automacao_valor_combustivel',
                'value' => true,
                'data_type' => 'boolean',
                'group_setting_id' => 3
            ]
         
        ]);

    }
}
