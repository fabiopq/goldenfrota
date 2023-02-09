<?php

use Illuminate\Database\Seeder;



class TipoMovimentacaoCreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Limpando tabela tipo_movimentacao_credito');
        $this->truncateTipoMovimentacaoCreditoTable();

        $this->command->info('Criando Tipos de Movimentação de Credito');

        DB::table('tipo_movimentacao_credito')->insert(
            [
                [
                    'id' => 1,
                    'tipo_movimentacao_credito' => 'Entrada',
                    
                ],
                [
                    'id' => 2,
                    'tipo_movimentacao_credito' => 'Saida',
                    
                ],
                
            ]
        );
    }

    public function truncateTipoMovimentacaoCreditoTable() {
        Schema::disableForeignKeyConstraints();
        DB::table('tipo_movimentacao_credito')->truncate();
        \App\TipoMovimentacaoCredito::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
