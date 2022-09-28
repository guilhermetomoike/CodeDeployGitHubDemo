<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdemServico extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $os_base = DB::table('os_base')->insertGetId([
            'nome' => 'Desbugar tudo',
            'descricao' => 'lorem ipsum teste dos testes masters testados',
            'preco' => 40,
            'procedimento_interno' => false,
            'pagamento_antecipado' => false,
            'role_id' => 1,
            'notificacao' => true
        ]);
        $os_base = DB::table('os_base')->insertGetId([
            'nome' => 'Gerar relatorio de teste da empresa',
            'descricao' => 'Gerar relatório para que o cliente possa conferir os dados escrito nele',
            'preco' => 40,
            'procedimento_interno' => false,
            'pagamento_antecipado' => false,
            'role_id' => 1,
            'notificacao' => true
        ]);

        $atividade1 = DB::table('os_atividade_base')->insertGetId([
            'os_base_id' => $os_base,
            'nome' => 'baixar relatorio',
            'descricao' => 'acessar o site do uol e gerar relatorio em xls clicando no menu text text',
            'sla_hora' => 10,
            'input' => json_encode([
                [
                    'nome' => 'descricao',
                    'tipo' => 'string',
                    'valor' => ''
                ]
            ]),
        ]);

        $atividade2 = DB::table('os_atividade_base')->insertGetId([
            'os_base_id' => $os_base,
            'nome' => 'anexar relaorio na solicitação',
            'descricao' => 'realizar upload do relatorio para futuramente ser enviado ao cliente',
            'sla_hora' => 10,
            'input' => json_encode([
                [
                    'nome' => 'relatorio',
                    'tipo' => 'file',
                    'valor' => ''
                ]
            ]),
        ]);

        $os = DB::table('ordem_servico')->insertGetId([
            'empresa_id' => 74,
            'cliente_id' => 78,
            'created_at' => now(),
            'descricao' => 'Este é um texto que o cliente ou o atendente escreve quando cria uma solicitação.',
        ]);

        $is_item = DB::table('os_item')->insertGetId([
            'os_base_id' => $os_base,
            'ordem_servico_id' => $os,
            'data_limite' => today()->addWeek()->addDays(3),
            'preco' => 42
        ]);

        DB::table('os_atividade')->insertGetId([
            'ordem_servico_id' => $os,
            'os_atividade_base_id' => $atividade2,
            'os_item_id' => $is_item,
            'input' => json_encode([
                [
                    'nome' => 'relatorio',
                    'tipo' => 'file',
                    'valor' => ''
                ]
            ]),
        ]);

        DB::table('os_atividade')->insertGetId([
            'ordem_servico_id' => $os,
            'os_atividade_base_id' => $atividade1,
            'os_item_id' => $is_item,
            'input' => json_encode([
                [
                    'nome' => 'descricao',
                    'tipo' => 'string',
                    'valor' => ''
                ]
            ]),
        ]);


    }
}

