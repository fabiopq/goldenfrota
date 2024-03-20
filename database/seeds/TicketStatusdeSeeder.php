<?php

use Illuminate\Database\Seeder;

class TicketStatusdeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Criando Ticket Status ');

        DB::table('ticket_status')->insert(
            [
                [
                    'id' => 1,
                    'descricao' => 'Aberto',
                    'ativo' => true
                ],
                [
                    'id' => 2,
                    'descricao' => 'Fechado',
                    'ativo' => false
                ],
                [
                    'id' => 3,
                    'descricao' => 'Aguardando',
                    'ativo' => false
                ]
            ]
        );
    }
}
