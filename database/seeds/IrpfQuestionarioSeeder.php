<?php

use Illuminate\Database\Seeder;

class IrpfQuestionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $q1 = \App\Models\Irpf\IrpfQuestionario::query()->create(['pergunta' => 'Trabalhou como Pessoa Fisica em 2019?',]);
        $pendencia1 = $q1->pendencia()->create([
            'nome' => 'Trabalho como Pessoa Fisica',
            'descricao' => 'Providenciar o informe de rendimentos anual',
        ]);
        $pendencia1->inputs()->create([
            'type' => 'file',
            'label' => 'Informe de rendimento',
            'name' => 'informe_rendimento_pf',
        ]);


        $q2 = \App\Models\Irpf\IrpfQuestionario::query()->create(['pergunta' => 'Possui dependentes?']);
        $pendencia2 = $q2->pendencia()->create([
            'nome' => 'Dependentes',
            'descricao' => 'Enviar documentos com CPF e data de nascimento',
        ]);
        $pendencia2->inputs()->create([
            'type' => 'file',
            'label' => 'Cpf',
            'name' => 'cpf_dependente',
        ]);


        $q3 = \App\Models\Irpf\IrpfQuestionario::query()->create(['pergunta' => 'Recebeu rendimentos isentos superior há R$ 40.000,00?']);
        $pendencia3 = $q3->pendencia()->create([
            'nome' => 'Rendimentos isentos superior há R$ 40.000,00',
            'descricao' => 'Providenciar o informe de rendimentos anual',
        ]);
        $pendencia3->inputs()->create([
            'type' => 'file',
            'label' => 'Informe de rendimento',
            'name' => 'informe_rendimento_isento_pf',
        ]);


        $q4 = \App\Models\Irpf\IrpfQuestionario::query()->create(['pergunta' => 'Possui livro caixa?']);
        $pendencia4 = $q4->pendencia()->create([
            'nome' => 'Livro caixa',
            'descricao' => 'Providenciar comprovantes (recibos, notas fiscais ou faturas) de despesas e receitas refente a atividade profissional',
        ]);
        $pendencia4->inputs()->create([
            'type' => 'file',
            'label' => 'Comprovante',
            'name' => 'comprovante_lc',
        ]);


        $q5 = \App\Models\Irpf\IrpfQuestionario::query()->create(['pergunta' => 'Pagamentos: Doações, despesas médicas, odontológicas, plano de saúde, pensão.']);
        $pendencia5 = $q5->pendencia()->create([
            'nome' => 'Pagamentos: Doações, despesas médicas, odontológicas, plano de saúde, pensão',
            'descricao' => 'Providenciar recibos, notas fiscais, faturas ou comprovante de pagamento',
        ]);
        $pendencia5->inputs()->create([
            'type' => 'file',
            'label' => 'Comprovante',
            'name' => 'comprovante_despesa_dpmops',
        ]);


        $q6 = \App\Models\Irpf\IrpfQuestionario::query()->create(['pergunta' => 'Possui Atividade Rural?']);
        $pendencia6 = $q6->pendencia()->create([
            'nome' => 'Atividade Rural',
            'descricao' => 'Providenciar documentação do imóvel e comprovantes de receitas e despesas relacionadas a atividade rural',
        ]);
        $pendencia6->inputs()->create([
            'type' => 'file',
            'label' => 'Comprovante / Documento',
            'name' => 'comprovante_atividade_rural',
        ]);


        $q7 = \App\Models\Irpf\IrpfQuestionario::query()->create(['pergunta' => 'Possui Bens/ Imovéis superiores a R$ 300.000,00?']);
        $pendencia7 = $q7->pendencia()->create([
            'nome' => 'Bens / Imovéis superiores a R$ 300.000,00',
            'descricao' => 'Providenciar cópia de documentos com valores, data de aquisição, dados do vendedor, numero da matricula do imovel ou renavan do veiculo.',
        ]);
        $pendencia7->inputs()->create([
            'type' => 'file',
            'label' => 'Cópia documento',
            'name' => 'documento_valor_superior_bens',
        ]);
        $pendencia7->inputs()->create([
            'type' => 'text',
            'label' => 'Renavam / Matricula',
            'name' => 'renavam_matricula',
        ]);


        $q8 = \App\Models\Irpf\IrpfQuestionario::query()->create(['pergunta' => 'Houve venda de Bens Móveis/ Imóveis?']);
        $pendencia8 = $q8->pendencia()->create([
            'nome' => 'Venda de móveis/imóveis',
            'descricao' => 'Providenciar cópia de documentação, data, valor e dados do comprador',
        ]);
        $pendencia8->inputs()->create([
            'type' => 'file',
            'label' => 'Cópia documento de venda',
            'name' => 'documento_venda_bens',
        ]);


        $q9 = \App\Models\Irpf\IrpfQuestionario::query()->create(['pergunta' => 'Realizou operações em Bolsas de Valores?']);
        $pendencia9 = $q9->pendencia()->create([
            'nome' => 'Operações na bolsa de valor',
            'descricao' => 'Providenciar informe de rendimento anual de investimentos',
        ]);
        $pendencia9->inputs()->create([
            'type' => 'file',
            'label' => 'Informe de rendimento',
            'name' => 'informe_rendimento_bolsa_valor',
        ]);


        $q10 = \App\Models\Irpf\IrpfQuestionario::query()->create(['pergunta' => 'Realizou contrato de financiamento?']);
        $pendencia10 = $q10->pendencia()->create([
            'nome' => 'Financiamento',
            'descricao' => 'Providenciar cópia do contrato e informe de rendimento do financiamento.',
        ]);
        $pendencia10->inputs()->create([
            'type' => 'file',
            'label' => 'Informe rendimento de financiamento',
            'name' => 'informe_rendimento_financiamento',
        ]);

    }
}
