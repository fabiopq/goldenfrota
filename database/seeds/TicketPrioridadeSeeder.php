<?php

use Illuminate\Database\Seeder;

class TicketPrioridadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // $this->command->info('Limpando tabela ordem_servico_status');
       // $this->truncateOrdemServicoStatusTable();

        $this->command->info('Criando Ticket Prioridade ');

        DB::table('ticket_prioridade')->insert(
            [
                [
                    'id' => 1,
                    'descricao' => 'Normal',
                    'ativo' => true
                ],
                [
                    'id' => 2,
                    'descricao' => 'Alta',
                    'ativo' => false
                ],
                [
                    'id' => 3,
                    'descricao' => 'Urgente',
                    'ativo' => false
                ]
            ]
        );
    }
}
