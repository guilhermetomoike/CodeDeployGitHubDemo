<?php

namespace Modules\Questionario\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Questionario\Entities\Questionario;
use Modules\Questionario\Entities\QuestionarioPagina;
use Modules\Questionario\Entities\QuestionarioParte;
use Modules\Questionario\Entities\QuestionarioPergunta;
use Modules\Questionario\Entities\QuestionarioPerguntaEscolha;

class QuestionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(\Modules\Questionario\Entities\Questionario::class, 5)->create();

        $this->questionario1();
        // $this->questionario2();
        // $this->questionario3();
    }

    private function questionario1()
    {
        $questionario = Questionario::create([
            'titulo' => 'Acesso Medbook - clientes antigos',
        ]);

        $this->pagina1($questionario);
        $this->pagina2($questionario);
        $this->pagina3($questionario);
        $this->pagina4($questionario);
        $this->pagina5($questionario);
        $this->pagina6($questionario);

        return $questionario;
    }

    private function questionario2()
    {
        $questionario = Questionario::create([
            'titulo' => 'Cadastro completo - médicos',
        ]);

        $this->pagina0($questionario);
        $this->pagina1($questionario);
        $this->pagina2($questionario);
        $this->pagina3($questionario);
        $this->pagina4($questionario);
        $this->pagina5($questionario);
        $this->pagina6($questionario);

        return $questionario;
    }


    private function questionario3()
    {
        $questionario = Questionario::create([
            'titulo' => 'Cadastro completo - estudantes',
        ]);

        $this->paginaEstudante0($questionario);
        $this->paginaEstudante1($questionario);
        $this->paginaEstudante2($questionario);
        $this->paginaEstudante3($questionario);

        return $questionario;
    }

    public function paginaEstudante0($questionario)
    {

        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => 'Vamos começar falando um pouco sobre você...',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Data de nascimento',
            'tipo' => 'dt',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Naturalidade',
            'tipo' => 'tc',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Cidade atual',
            'tipo' => 'tc',
        ]);

        $pergunta = $this->comboUf($parte);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'E-mail *',
            'tipo' => 'tc',
        ]);


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => ' ',
            'tipo' => 'ue',
            'tipo_escolha' => 'hz',
        ]);

        $pergunta_id = $pergunta->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Sou médico(a)',
        ]);

        $medico_escolha_id = $escolha->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Sou estudante',
        ]);


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Token Acesso',
            'tipo' => 'tc',
        ]);
    }

    public function paginaEstudante1($questionario)
    {

        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => ' ',
        ]);


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Você estuda em faculdade pública ou privada?',
            'tipo' => 'ue',
            'tipo_escolha' => 'hz',
        ]);

        $pergunta_id = $pergunta->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Pública',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Privada',
        ]);
        $privada_escolha_id = $escolha->id;


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Selecione a faculdade',
            'tipo' => 'ue',
            'tipo_escolha' => 'cb',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'UEM',
            'outro_informar' => true,
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'UNICESUMAR',
            'outro_informar' => true,
        ]);

        /*
escolhas
*/

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Outro',
            'outro_informar' => true,
        ]);


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Está cursando qual ano?',
            'tipo' => 'ue',
            'tipo_escolha' => 'cb',
        ]);


        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Primeiro',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Segundo',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Terceiro',
        ]);

        /*
escolhas
*/


        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Penúltimo',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Último',
        ]);


        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Outro',
            'outro_informar' => true,
        ]);


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Utilizou financiamento estudantil?',
            'tipo' => 'ue',
            'tipo_escolha' => 'vt',
            'mostrar_se_resposta' => $privada_escolha_id,
            'mostrar_se_pergunta_id' => $pergunta_id,
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Não',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'FIES',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Outro',
            'outro_informar' => true,
        ]);
    }

    public function paginaEstudante2($questionario)
    {

        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => ' ',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Executa alguma função administrativa no curso?',
            'tipo' => 'tc',
        ]);
    }


    public function paginaEstudante3($questionario)
    {

        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => ' ',
        ]);


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Como está a preparação para a residência?',
            'tipo' => 'ue',
            'tipo_escolha' => 'hz',
        ]);

        $pergunta_id = $pergunta->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Já passei!',
        ]);
        $ja_passei_escolha_id = $escolha->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Focado(a) nos estudos',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Primeiro quero trabalhar',
        ]);


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Selecione a especialidade',
            'tipo' => 'ue',
            'tipo_escolha' => 'cb',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Pediatria',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Geral',
        ]);


        /*
escolhas
*/

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Outra',
            'outro_informar' => true,
        ]);



        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Selecione a instituição',
            'tipo' => 'ue',
            'tipo_escolha' => 'vt',
            'mostrar_se_resposta' => $ja_passei_escolha_id,
            'mostrar_se_pergunta_id' => $pergunta_id,
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'UEM',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'UNICESUMAR',
        ]);

        /*
escolhas
*/

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Outro',
            'outro_informar' => true,
        ]);
    }


    private function pagina0($questionario)
    {
        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => 'Vamos começar falando um pouco sobre você...',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Data de nascimento',
            'tipo' => 'dt',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Naturalidade',
            'tipo' => 'tc',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Cidade atual',
            'tipo' => 'tc',
        ]);

        $pergunta = $this->comboUf($parte);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'E-mail *',
            'tipo' => 'tc',
        ]);


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => ' ',
            'tipo' => 'ue',
            'tipo_escolha' => 'hz',
        ]);

        $pergunta_id = $pergunta->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Sou médico(a)',
        ]);

        $medico_escolha_id = $escolha->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Sou estudante',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'CRM-UF',
            'tipo' => 'tc',
            'max' => 14,
            'mostrar_se_resposta' => $medico_escolha_id,
            'mostrar_se_pergunta_id' => $pergunta_id,
        ]);
    }



    private function pagina1($questionario)
    {
        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => 'Sobre sua carreira na medicina...',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Em qual etapa da carreira você se encontra atualmente?',
            'tipo' => 'ue',
            'tipo_escolha' => 'vt',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Início da carreira',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Tentando entrar na residência',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Estou na residência',
        ]);
        $instituicao_escolha_id = $escolha->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Já sou especialista',
        ]);
        $especialista_escolha_id = $escolha->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Já tenho minha clínica própria',
        ]);

        $pergunta_id = $pergunta->id;

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Especialidade',
            'tipo' => 'tc',
            'max' => 128,
            'mostrar_se_resposta' => $especialista_escolha_id,
            'mostrar_se_pergunta_id' => $pergunta_id,
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Instituição',
            'tipo' => 'tc',
            'max' => 128,
            'mostrar_se_resposta' => $instituicao_escolha_id,
            'mostrar_se_pergunta_id' => $pergunta_id,
        ]);
    }


    private function pagina2($questionario)
    {
        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => 'Agora sobre sua graduação...',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Você estudou em faculdade pública ou privada?',
            'tipo' => 'ue',
            'tipo_escolha' => 'hz',
        ]);

        $pergunta_id = $pergunta->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Pública',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Privada',
        ]);
        $privada_escolha_id = $escolha->id;

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Nome da instituição',
            'tipo' => 'tc',
            'max' => 128,
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Ano de conclusão',
            'tipo' => 'dt',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Utilizou financiamento estudantil?',
            'tipo' => 'ue',
            'tipo_escolha' => 'vt',
            'mostrar_se_resposta' => $privada_escolha_id,
            'mostrar_se_pergunta_id' => $pergunta_id,
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Não',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'FIES',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Outro',
            'outro_informar' => true,
        ]);
    }

    private function pagina3($questionario)
    {
        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => 'Agora sobre o seu trabalho...',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Em quais tipos de local você atende?',
            'tipo' => 'me',
            'tipo_escolha' => 'vt',
        ]);

        $pergunta_id = $pergunta->id;

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Hospital Privado grande porte',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Hospital Privado pequeno porte',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Hospital Público grande porte',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Hospital Público pequeno porte',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'UPA',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'UBS',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'SAMU',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Clínica própria',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Clínica de terceiros',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Telemedicina',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Outros',
        ]);
    }

    private function pagina4($questionario)
    {
        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => 'Ainda sobre seu trabalho...',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Qual seu faturamento mensal?',
            'tipo' => 'me',
            'tipo_escolha' => 'vt',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Até R$ 10.000',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'De R$ 10.000 a 20.000',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'De R$ 20.000 a R$ 50.000',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'De R$ 50.000 a R$ 100.000',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Acima de R$ 100.000',
        ]);


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Seu faturamento dos sonhos (sendo realista)',
            'tipo' => 'tc',
        ]);


        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Quais formas de contrato/recebimento?',
            'tipo' => 'ue',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'CNPJ (pessoa jurídica)',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'RPA (autônomo)',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'CLT (carteira assinada)',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Concurso',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Informal (“por fora”)',
        ]);
    }

    private function pagina5($questionario)
    {
        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => 'Ainda sobre seu trabalho...',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Possui alguma fonte de renda ou ocupação alternativa?',
            'tipo' => 'me',
            'tipo_escolha' => 'vt',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Não possuo',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Professor(a) /preceptor(a)',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Influencer/produtor(a) digital',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Gestão de equipe / escala',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Pesquisa científica',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Investimentos',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Empreendimento fora da medicina',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'Outra(s)',
        ]);
    }

    private function pagina6($questionario)
    {
        $pagina = QuestionarioPagina::create([
            'questionario_id' => $questionario->id,
            'titulo' => 'Anamnese da saúde profissional',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => 'Está quase acabando!',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Trabalha em média quantas horas por semana?',
            'tipo' => 'nu',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'E quantas horas você gostaria de trabalhar?',
            'tipo' => 'nu',
        ]);

        $parte = QuestionarioParte::create([
            'questionario_pagina_id' => $pagina->id,
            'titulo' => 'Por último...',
        ]);

        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'Quais são seus objetivos para os próximos 5 anos?*',
            'subtitulo' => 'ex: fazer uma especialização, abrir uma clínica, construir patrimônio, viajar mais, etc.',
            'tipo' => 'tl',
        ]);
    }


    private function comboUf($parte)
    {
        $pergunta = QuestionarioPergunta::create([
            'questionario_parte_id' => $parte->id,
            'titulo' => 'UF',
            'tipo' => 'ue',
            'tipo_escolha' => 'cb',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'AC',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'AL',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'AM',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'AP',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'BA',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'CE',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'DF',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'ES',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'GO',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'MA',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'MG',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'MS',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'MT',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'PA',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'PB',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'PE',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'PI',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'PR',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'RJ',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'RN',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'RO',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'RR',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'RS',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'SC',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'SE',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'SP',
        ]);

        $escolha = QuestionarioPerguntaEscolha::create([
            'questionario_pergunta_id' => $pergunta->id,
            'escolha' => 'TO',
        ]);

        return $pergunta;
    }
}
