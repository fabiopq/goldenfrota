<?php

namespace App\Http\Controllers;

use App\Bico;
use App\Produto;
use App\Veiculo;
use App\Atendente;
use App\Abastecimento;
use App\Motorista;
use App\TanqueMovimentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AbastecimentoController;
use App\PostoAbastecimento;
use League\Csv\Writer;

class IntegracaoAutomacaoController extends Controller
{
    private function disk()
    {
        //alterado para enviar apenas por ftp
        //verifica no arvio .env se a chave APP_ENV = local
        // sefor local nao ira enviar os arquivos para ftp, ficara apenas na pasta storage
        //
        return (App::environment('local')) ? 'local' : 'ftp';
        //return ('ftp');
    }

    /* 
        funcionarios.hir - Cadastro de Funcionarios

        <VersaoRegistro;IdentificacaoFuncionario;Nome>

        Onde:
        < = Caracter marcador de inicio de regsitro
        Versao do Registro = 01 - Versao do layout do registro (2 caracteres Numericos)
        Identificacao Funcionario = 16 caracteres alfa numericos
        Nome = Nome do funcionario (10 caracteres alfa numericos)
        > = Caracter marcador de fim de regsitro
    */
    public function ExportarAtendentes()
    {

        try {
            $conteudo = '';
            $atendentes = Atendente::where('ativo', true)->get();

            foreach ($atendentes as $atendente) {
                $conteudo .= '<01;';
                $conteudo .= substr('                ' . $atendente->senha_atendente, -16) . ';';
                $conteudo .= substr('          ' . $atendente->usuario_atendente, -10);
                $conteudo .= '>';
            }

            //Log::debug($conteudo);
            $arquivo = $conteudo;
            $conteudo = $this->cryptAPI($conteudo);

            /* Config da conta de FTP */
            $this->configFTP();

            Storage::disk($this->disk())->put('funcionarios.hir', $conteudo);
            Storage::disk($this->disk())->put('funcionarios_teste.txt', $arquivo);


            Session::flash('success', 'Dados Exportados com sucesso!');
            return redirect()->action('HomeController@index');
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));
        }
    }

    public function ExportarAtendentesNew()
    {
        $configs = PostoAbastecimento::paginate();

        $i = 1;

        $conteudo = '';
        $atendentes = Atendente::where('ativo', true)->get();

        foreach ($atendentes as $atendente) {
            $conteudo .= '<01;';
            $conteudo .= substr('                ' . $atendente->senha_atendente, -16) . ';';
            $conteudo .= substr('          ' . $atendente->usuario_atendente, -10);
            $conteudo .= '>';
        }

        //Log::debug($conteudo);
        $arquivo = $conteudo;
        $conteudo = $this->cryptAPI($conteudo);

        foreach ($configs as $config) {

            if ($config->ftp_server !== null) {

                $this->configFTPs($config, $i);
                /* Config da conta de FTP */

                // Storage::disk($this->disk())->put('funcionarios.hir', $conteudo);
                $i++;
            }
        }


        try {
            $i = 0;
            foreach ($configs as $config) {

                if ($config->ftp_server !== null) {
                    $i++;
                    try {
                        Storage::disk('ftp' . $i)->put('funcionarios_teste.txt', $arquivo);
                        Storage::disk('ftp' . $i)->put('funcionarios.hir', $arquivo);
                    } catch (\Exception $e) {
                        Session::flash('error', __('messages.exception', [
                            'exception' => $e->getMessage()
                        ]));
                    }
                }
            }

            Session::flash('success', 'Dados Exportados com sucesso!');
            return redirect()->action('HomeController@index');
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));
        }
    }

    // motoristas.hir
    /*
  
   */

    public function ExportarMotoristas()
    {
        try {
            $conteudo = '';
            $motoristas = Motorista::whereNotNull('tag')->where('ativo', true)->get();
            foreach ($motoristas as $motorista) {
                $conteudo .= '<02;';
                $conteudo .= substr('                ' . $motorista->tag, -16) . ';';
                $conteudo .= substr('          ' . $motorista->nome, -10) . ';';
                $conteudo .= substr('          ' . '', -8) . ';';
                $conteudo .= '>';
            }


            $arquivo = $conteudo;
            $conteudo = $this->cryptAPI($conteudo);

            /* Config da conta de FTP */
            $this->configFTP();

            Storage::disk($this->disk())->put('motoristas.hir', $conteudo);
            Storage::disk($this->disk())->put('motoristas.txt', $arquivo);

            Session::flash('success', 'Dados Exportados com sucesso!');
            return redirect()->action('HomeController@index');
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));
        }
    }


    /* 
    produtos.hir  -  Cadastro de produtos

    <VersaoRegistro;CodigoProduto;Descricao>

    Onde:
    < = Caracter marcador de inicio de regsitro
    Versao do Registro = 01 - Versao do layout do registro (2 caracteres Numericos)
    Codigo do produto = Produto (3 caracteres Numericos 1 - 999)
    Descricao = Descricao do Produto (10 caracteres alfa numericos)
    > = Caracter marcador de fim de regsitro
    */

    public function ExportarProdutos()
    {
        try {
            $conteudo = '';
            $produtos = Produto::where('ativo', true)->get();
            foreach ($produtos as $produto) {
                $conteudo .= '<01;';
                $conteudo .= substr('   ' . $produto->id, -3) . ';';
                $conteudo .= substr('          ' . $produto->produto_desc_red, -10);
                $conteudo .= '>';
            }
            $arquivo = $conteudo;
            $conteudo = $this->cryptAPI($conteudo);

            /* Config da conta de FTP */
            $this->configFTP();

            Storage::disk($this->disk())->put('produtos.hir', $conteudo);
            Storage::disk($this->disk())->put('produtos_teste.txt', $arquivo);

            Session::flash('success', 'Dados Exportados com sucesso!');
            return redirect()->action('HomeController@index');
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));

            return redirect()->back();
        }
    }


    /* 
    veiculos.hir - Cadastro de veiculos
    
    <VersaoRegistro;IdentificacaoVeiculo;;TagVeiculo>
    
    Onde:
    < = Caracter marcador de inicio de regsitro
    Versao do Registro = 01 - Versao do layout do registro (2 caracteres Numericos)
    Identificacao Veiculo = placa ou prefixo do veiculo (16 caracteres alfa numericos)
    Tag Veiculo = Tag do veiculo (8 caracteres alfa numericos)
    > = Caracter marcador de fim de regsitro 
    */

    public function ExportarVeiculosold()
    {
        try {
            $conteudo = '';
            $veiculos = Veiculo::where('ativo', true)->get();
            foreach ($veiculos as $veiculo) {
                $conteudo .= '<01;';
                $conteudo .= substr('                ' . $veiculo->placa, -16) . ';';
                $conteudo .= substr('        ' . $veiculo->tag, -8);
                $conteudo .= '>';
            }
            $arquivo = $conteudo;
            $conteudo = $this->cryptAPI($conteudo);

            /* Config da conta de FTP */
            $this->configFTP();

            Storage::disk($this->disk())->put('veiculos.hir', $conteudo);
            Storage::disk($this->disk())->put('veiculos_teste.txt', $arquivo);
            Session::flash('success', 'Dados Exportados com sucesso!');
            return redirect()->action('HomeController@index');
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));

            return redirect()->back();
        }
    }

    public function ExportarVeiculos()
    {

        $configs = PostoAbastecimento::paginate();

        $i = 1;

        $conteudo = '';
        $veiculos = Veiculo::where('ativo', true)->get();
        foreach ($veiculos as $veiculo) {
            $conteudo .= '<01;';
            $conteudo .= substr('                ' . $veiculo->placa, -16) . ';';
            $conteudo .= substr('        ' . $veiculo->tag, -8);
            $conteudo .= '>';
        }

        //Log::debug($conteudo);
        $arquivo = $conteudo;
        $conteudo = $this->cryptAPI($conteudo);

        foreach ($configs as $config) {

            if ($config->ftp_server !== null) {

                $this->configFTPs($config, $i);
                /* Config da conta de FTP */

                // Storage::disk($this->disk())->put('funcionarios.hir', $conteudo);
                $i++;
            }
        }


        try {
            $i = 0;
            foreach ($configs as $config) {

                if ($config->ftp_server !== null) {
                    $i++;
                    try {
                        Storage::disk('ftp' . $i)->put('veiculos.txt', $arquivo);
                        Storage::disk('ftp' . $i)->put('veiculos.hir', $arquivo);
                    } catch (\Exception $e) {
                        Session::flash('error', __('messages.exception', [
                            'exception' => $e->getMessage()
                        ]));
                    }
                }
            }

            Session::flash('success', 'Dados Exportados com sucesso!');
            return redirect()->action('HomeController@index');
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));
        }
    }

    public function ExportarVeiculosHorusTech()
    {
        try {
            $conteudo = '';
            $veiculos = Veiculo::where('ativo', true)->get();

            // Criar o arquivo CSV
            $csv = Writer::createFromString('');

            $csv->setDelimiter(';');
            //$csv->setEnclosure('');
            $csv->setOutputBOM(Writer::BOM_UTF8);

            $csv->insertOne(['Posição', 'ID Cartão', 'Função', 'Versão', 'Controle', 'codigo', 'Nome', 'Disconto', 'Comb. Ctrl.']);

            $i = 0;
            $conteudo .= "Posição; ID Cartão; Função; Versão; Controle ;codigo ;Nome ;Disconto ;Comb. Ctrl.;\n";
            foreach ($veiculos as $veiculo) {
                if (strlen($veiculo->tag) == 16) {
                    $conteudo .= str_pad($i, 6, '0', STR_PAD_LEFT) . ';';
                    $conteudo .= substr('                ' . $veiculo->tag, -16) . ';';
                    $conteudo .= '27: CARD ATTENDANT 1 L  ;';
                    $conteudo .= '10;';
                    $conteudo .= 'FFFF;';
                    $conteudo .= 'FFFFFFFF;';
                    $conteudo .= str_pad($veiculo->tag, 30, ' ') . ';';
                    $conteudo .= '00,00;';
                    $conteudo .= ";\n";
                    //$teste = substr('                ' . $veiculo->tag, -16);
                    // $csv->insertOne([$teste, substr('                ' . $veiculo->tag, -16), '27: CARD ATTENDANT 1 L','10','FFFF','FFFFFFFF',$veiculo->tag,'00,00','']);


                    $i++;
                }
            }
            $arquivo = $conteudo;
            $conteudo = $arquivo;

            // $filename = 'veiculos.csv';

            /* Config da conta de FTP */
            $this->configFTP();
            $filename = 'veiculos_todos.csv';
            //Storage::disk($this->disk())->put($filename, $conteudo);

            // Salvar o arquivo de texto no armazenamento local (storage)
            Storage::put($filename, $conteudo);

            // Retornar o arquivo de texto como download
            return response()->download(storage_path("app/{$filename}"))->deleteFileAfterSend(true);

            Session::flash('success', 'Dados Exportados com sucesso!');
            //Storage::disk($this->disk())->put('veiculos_teste.txt', $arquivo);

            return redirect()->action('HomeController@index');
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));

            return redirect()->back();
        }
    }

    public function ExportarVeiculosSaldoHorusTech()
    {

        //gerar arquivo de veiculos ativos e com saldo e tag para importar no console horustech 
        try {
            $conteudo = '';
            $veiculos = Veiculo::where('ativo', true)->get();

            // Criar o arquivo CSV
            $csv = Writer::createFromString('');

            $csv->setDelimiter(';');
            //$csv->setEnclosure('');
            $csv->setOutputBOM(Writer::BOM_UTF8);

            $csv->insertOne(['Posição', 'ID Cartão', 'Função', 'Versão', 'Controle','codigo', 'Nome', 'Disconto', 'Comb. Ctrl.']);

            $i = 0;
            $conteudo .= "Posição; ID Cartão; Função; Versão; Controle ;codigo ;Nome ;Disconto ;Comb. Ctrl.;\n";
            foreach ($veiculos as $veiculo) {
                $saldo = MovimentacaoCreditoController::saldoCreditoMes($veiculo->cliente_id);
                //dd($saldo);
                if ($saldo > 0) {
                    if (strlen($veiculo->tag) == 16) {
                        $conteudo .= str_pad($i, 6, '0', STR_PAD_LEFT) . ';';
                        $conteudo .= substr('                ' . $veiculo->tag, -16) . ';';
                        $conteudo .= '27: CARD ATTENDANT 1 L  ;';
                        $conteudo .= '10;';
                        $conteudo .= 'FFFF;';
                        $conteudo .= 'FFFFFFFF;';
                        $conteudo .= str_pad($veiculo->tag, 30, ' ') . ';';
                        $conteudo .= '00,00;';
                        $conteudo .= ";\n";
                        //$teste = substr('                ' . $veiculo->tag, -16);
                        // $csv->insertOne([$teste, substr('                ' . $veiculo->tag, -16), '27: CARD ATTENDANT 1 L','10','FFFF','FFFFFFFF',$veiculo->tag,'00,00','']);


                        $i++;
                    }
                }
            }
            $arquivo = $conteudo;
            $conteudo = $arquivo;

            // $filename = 'veiculos.csv';

            /* Config da conta de FTP */
            $this->configFTP();
            $filename = 'veiculos_com_saldo.csv';
            //Storage::disk($this->disk())->put($filename, $conteudo);

            // Salvar o arquivo de texto no armazenamento local (storage)
            Storage::put($filename, $conteudo);

            // Retornar o arquivo de texto como download
            return response()->download(storage_path("app/{$filename}"))->deleteFileAfterSend(true);

            Session::flash('success', 'Dados Exportados com sucesso!');
            //Storage::disk($this->disk())->put('veiculos_teste.txt', $arquivo);

            return redirect()->action('HomeController@index');
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));

            return redirect()->back();
        }
    }

    public function Exportar()
    {
        $this->ExportarAtendentes();
        $this->ExportarProdutos();
        $this->ExportarVeiculos();

        Session::flash('success', 'Dados Exportados com sucesso!');
        return redirect()->action('HomeController@index');
    }

    protected function formataDataHoraAbastecimento(String $dataHora)
    {
        $b = null;

        $dataHora = str_replace(' ', '0', $dataHora);

        foreach (str_split($dataHora, 2) as $a) {
            $b .= $b ? '-' : '';
            $b .= trim($a);
        }

        return \DateTime::createFromFormat('d-m-y-H-i-s', $b);
    }

    public function formataValorDecimal($valor, $numCasas = 2)
    {
        if ($numCasas > 0) {
            return floatval(substr($valor, 0, ($numCasas * -1)) . '.' . substr($valor, ($numCasas * -1)));
        } else {

            return floatval($valor);
        }
    }



    protected function formataPlacaVeiculo($placa)
    {

        return strtoupper(substr($placa, 0, 3) . '-' . substr($placa, -4));
    }

    /* 
    abastecimentos.hir - Arquivo de Abastecimentos:							
    <VersaoRegistro;ID;NS;Bico;Data;Hora;ValorAbastecido;VolumeAbastecido;PrecoUnitario;CasaDecimalPU;EncerranteInicial;EncerranteFinal;
    IdentificacaoFuncionario;IdentificacaoVeiculo;TagVeiculo;Km;Requisicao>

    Onde:
    < = Caracter marcador de inicio de regsitro
    0 - Versao do Registro = 01 - Versao do layout do registro (2 caracteres Numericos) 
    1 - ID = Identificacao do registro de abastecimento (10 caracteres Numericos 1 - 4.294.967.295)
    2 - NS = Numero de serie do Hiro (10 caracteres Numericos 1 - 4.294.967.295)
    3 - Bico = Bico que fez o abastecimento (2 caracteres Numericos 1 - 99)
    4 - Data = Ano Mes Dia (6 caracteres Numericos)
    5 - Hora = Hora Minuto Segundo (6 caracteres Numericos)
    6 - Valor Abastecido = Valor (8 caracteres Numericos sendo 2 decimais)
    7 - Volume Abastecido = Volume (8 caracteres Numericos sendo 3 decimais)
    8 - Preco Unitario = Preco (4 caracteres Numericos)
    9 - Casa Decimal = Numero de casas decimais (1 caracter Numericos 0 - 3)
    10 - Encerrante Inicial = 10 caracteres Numericos sendo 2 decimais
    11 - Encerrante Final = 10 caracteres Numericos sendo 2 decimais
    12 - Identificacao Funcionario = 16 caracteres alfa numericos
    13 - Identificacao Veiculo = placa ou prefixo do veiculo (16 caracteres alfa numericos)
    14 - Tag Veiculo = Tag do veiculo (8 caracteres alfa numericos)
    15 - km = 10 caracteres Numericos sendo 1 decimal
    16 - Requisicao = 16 caracteres alfa numericos
    > = Caracter marcador de fim de regsitro
    */
    public function ImportarAbastecimentosold()
    {

        if (App::environment('local')) {
            Log::debug('Tarefa agendada: Importação de Abastecimento... [ambiente de desenvolvimento]');
            //return;
        }

        // verifica se na configuracao esta habilitado preco do cadastro do combustivel
        $cfgPreco = DB::table('settings')
            ->select('settings.value')
            ->where('settings.key', 'automacao_valor_combustivel')
            ->first();


        try {
            /* Config da conta de FTP */
            $this->configFTP();


            $errosImportacao = false;
            if (Storage::disk($this->disk())->exists('abastecimentos.hir')) {

                try {
                    $arquivo = Storage::disk($this->disk())->get('abastecimentos.hir');
                    $arquivo = $this->cryptAPI($arquivo);
                    Storage::disk($this->disk())->put('abastecimentos_hir_teste.txt', $arquivo);



                    $registros = array();

                    $linhas = explode('>', $arquivo);

                    foreach ($linhas as $linha) {
                        $linha = str_replace('<', '', $linha);
                        $linha = explode(';', $linha);
                        if (count($linha) > 1) {
                            $registros[] = $linha;
                        }
                    }


                    $dataInicio = \DateTime::createFromFormat(
                        'Y-m-d H:i:s',
                        Abastecimento::whereNotNull('id_automacao')
                            ->orderBy('data_hora_abastecimento', 'desc')
                            ->pluck('data_hora_abastecimento')
                            ->first()
                    );


                    foreach ($registros as $registro) {

                        if (count($registro) >= 17) {

                            try {
                                $abastecimento = new Abastecimento;
                                $abastecimentoController = new AbastecimentoController;
                                $obs = null;

                                $atendente = Atendente::where('usuario_atendente', '=', trim($registro[12]))->first();
                                $bico = Bico::where('num_bico', '=', trim($registro[3]))->first();

                                $preco = DB::table('combustiveis')
                                    ->select('combustiveis.valor')
                                    ->leftJoin('tanques', 'tanques.combustivel_id', 'combustiveis.id')
                                    ->leftJoin('bicos', 'bicos.tanque_id', 'tanques.id')
                                    ->where('bicos.id', '=', trim($registro[3]))
                                    ->first();



                                $veiculo = Veiculo::where('placa', '=', $this->formataPlacaVeiculo(trim($registro[13])))->first();



                                if (!$bico) {
                                    $obs .= 'Bico [' . trim($registro[3]) . ']: Não encontrado!&#10;';
                                } else {
                                    $abastecimento->bico_id = $bico->id;
                                }

                                if (!$atendente) {
                                    $obs .= 'Atendente [' . trim($registro[12]) . ']: Não encontrado!&#10;';
                                } else {
                                    $abastecimento->atendente_id = $atendente->id;
                                }


                                $abastecimento->id_automacao = trim($registro[1]);
                                $abastecimento->ns_automacao = trim($registro[2]);

                                $abastecimento->data_hora_abastecimento = $this->formataDataHoraAbastecimento($registro[4] . $registro[5])->format('Y-m-d H:i:s');


                                if ($cfgPreco->value) {

                                    if (!$preco) {
                                        $abastecimento->valor_abastecimento = $this->formataValorDecimal(trim($registro[6]));
                                        $abastecimento->valor_litro = $this->formataValorDecimal(trim($registro[8]), trim($registro[9]));
                                    } else {
                                        $abastecimento->valor_abastecimento = ($this->formataValorDecimal(trim($registro[7]), 3) * $preco->valor);
                                        $abastecimento->valor_litro = $preco->valor;
                                    }
                                } else {
                                    $abastecimento->valor_abastecimento = $this->formataValorDecimal(trim($registro[6]));
                                    $abastecimento->valor_litro = $this->formataValorDecimal(trim($registro[8]), trim($registro[9]));
                                }



                                $abastecimento->volume_abastecimento = $this->formataValorDecimal(trim($registro[7]), 3);

                                $abastecimento->encerrante_inicial = $this->formataValorDecimal(trim($registro[10]));
                                $abastecimento->encerrante_final = $this->formataValorDecimal(trim($registro[11]));
                                $abastecimento->km_veiculo = $this->formataValorDecimal(trim($registro[15]), 1);
                                /* se valor total zerado, calcula valor total */
                                if ($abastecimento->valor_abastecimento == 0) {
                                    $abastecimento->valor_abastecimento = round($abastecimento->volume_abastecimento * $abastecimento->valor_litro, 2);
                                }



                                if (!$veiculo) {  // verifica se nao veio veiculo no arquivo


                                    if (!$atendente->veiculo_id) { //verifica se no cadastro de atendente nao possui veiculo
                                        $abastecimento->media_veiculo = 0;
                                        $obs .= 'Veículo [' . trim($registro[14]) . ']: Não encontrado!&#10;';
                                    } else {
                                        $abastecimento->veiculo_id = $atendente->veiculo_id;



                                        /* if($veiculo->hodometro_decimal){
                                            $abastecimento->km_veiculo = $this->formataValorDecimal(trim($registro[15]), 1); 

                                        }else{ // acresenta zero ao km digitado no arquivo de importacao
                                            $abastecimento->km_veiculo = $this->formataValorDecimal(trim($registro[15]) . '0',  1); 
                                          
                                        }
                                       */
                                        $veiculo = Veiculo::where('id', '=', $atendente->veiculo_id)->first();
                                        $abastecimento->media_veiculo = $abastecimentoController->obterMediaVeiculo($veiculo, $abastecimento) ?? 0;
                                    }
                                } else {


                                    $abastecimento->veiculo_id = $veiculo->id;
                                    //if ( $veiculo->modelo_veiculo->tipo_controle_veiculo_id == 1) {
                                    /* controle de km rodados */

                                    // $abastecimento->km_veiculo = $this->formataValorDecimal(trim($registro[15]), 1);
                                    // } else {
                                    /* controle de horas trabalhadas */
                                    //    $abastecimento->horas_trabalhadas = $this->formataValorDecimal(trim($registro[15]), 1);
                                    //} 
                                    $abastecimento->media_veiculo = $abastecimentoController->obterMediaVeiculo($veiculo, $abastecimento) ?? 0;
                                    // Log::debug('Media_Veiculo='.$abastecimento->media_veiculo);
                                }

                                if ($abastecimento->km_veiculo <= 0) {
                                    $obs .= 'KM não informada para.&#10;';
                                }

                                if ($obs) {
                                    $obs = 'Inconsistências encontradas, verifique.&#10;' . $obs;
                                    $abastecimento->obs_abastecimento = $obs;
                                    $abastecimento->inconsistencias_importacao = true;
                                }


                                $dataAbastecimento = $this->formataDataHoraAbastecimento($registro[4] . $registro[5]);



                                //Log::debug($dataInicio);

                                //dd($dataInicio);
                                if ($dataAbastecimento <= $dataInicio) {
                                    dd($abastecimento);
                                    continue; //pula para o proximo abastecimento
                                }
                            } catch (\Exception $e) {
                                if (App::environment('local')) {
                                    Log::debug($e);
                                } else {
                                    Log::error($e->getMessage());
                                }
                            }


                            try {
                                // dd($abastecimento);
                                //Log::debug($abastecimento);

                                DB::beginTransaction();

                                if ($abastecimento->save()) {
                                    // Movimenta o estoque do tanque 
                                    //VeiculoController::atualizaKmVeiculo($abastecimento);
                                    //dd($abastecimento);

                                    if (MovimentacaoCombustivelController::saidaAbastecimento($abastecimento)) {
                                        DB::commit();
                                        Log::info('Novo abastecimento: ' . $abastecimento . ' importado da Automação.');
                                    } else {
                                        throw new \Exception('Erro ao efetuar a movimentação no tanque. [' . implode("|", $registro) . ']');
                                    }
                                } else {
                                    throw new \Exception('Erro ao inserir o abastecimento. [' . implode("|", $registro) . ']');
                                }
                            } catch (\Exception $e) {
                                $errosImportacao = true;
                                DB::rollback();
                                if (App::environment('local')) {
                                    Log::debug($e);
                                } else {
                                    Log::error($e->getMessage());
                                }
                            }
                        } else {
                            Log::alert('Erro ao importar registro: ' . implode("|", $registro), []);
                        }
                    }
                } finally {
                    // Elimina o arquivo do servidor apenas se conseguir importar todos os abastecimentos */
                    if (!$errosImportacao) {
                        $this->limparArquivoAbastecimentosServidorold();
                    }
                }

                Session::flash('success', 'Abastecimentos Importados com sucesso!');
                return redirect()->action('AbastecimentoController@index');
            } else {
                Session::flash('success', 'Não existem abastecimentos a serem importados!');
                return redirect()->action('AbastecimentoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));

            return redirect()->back();
        }
    }

    public function ImportarAbastecimentos()
    {

        if (App::environment('local')) {
            Log::debug('Tarefa agendada: Importação de Abastecimento... [ambiente de desenvolvimento]');
            //return;
        }

        // verifica se na configuracao esta habilitado preco do cadastro do combustivel
        $cfgPreco = DB::table('settings')
            ->select('settings.value')
            ->where('settings.key', 'automacao_valor_combustivel')
            ->first();


        try {
            /* Config da conta de FTP */
            $configs = PostoAbastecimento::paginate();

            $i = 1;


            foreach ($configs as $config) {

                if ($config->ftp_server !== null) {

                    $this->configFTPs($config, $i);
                    /* Config da conta de FTP */

                    // Storage::disk($this->disk())->put('funcionarios.hir', $conteudo);
                    $i++;
                }
            }


            $i = 1;
            foreach ($configs as $config) {

                if ($config->ftp_server !== null) {

                    $errosImportacao = false;
                    try {


                        if (Storage::disk('ftp' . $i)->exists('abastecimentos.hir')) {
                            log::debug('Existe abastecimento no ftp' . $i);
                            try {
                                $arquivo = Storage::disk('ftp' . $i)->get('abastecimentos.hir');
                                $arquivo = $this->cryptAPI($arquivo);
                                Storage::disk('ftp' . $i)->put('abastecimentos_hir_teste.txt', $arquivo);

                                $registros = array();

                                $linhas = explode('>', $arquivo);

                                foreach ($linhas as $linha) {
                                    $linha = str_replace('<', '', $linha);
                                    $linha = explode(';', $linha);
                                    if (count($linha) > 1) {
                                        $registros[] = $linha;
                                    }
                                }


                                $dataInicio = \DateTime::createFromFormat(
                                    'Y-m-d H:i:s',
                                    Abastecimento::whereNotNull('id_automacao')
                                        ->orderBy('data_hora_abastecimento', 'desc')
                                        ->pluck('data_hora_abastecimento')
                                        ->first()
                                );


                                foreach ($registros as $registro) {

                                    if (count($registro) >= 17) {

                                        try {
                                            $abastecimento = new Abastecimento;
                                            $abastecimentoController = new AbastecimentoController;
                                            $obs = null;

                                            // busca na tabela atendente se existe atendente com a tag do arquivo
                                            $atendente = Atendente::where('usuario_atendente', '=', trim($registro[12]))->first();

                                            if (!$atendente) {
                                                $obs .= 'Atendente [' . trim($registro[12]) . ']: Não encontrado!&#10;';
                                            } else {
                                                $abastecimento->atendente_id = $atendente->id;
                                            }

                                            $bico = Bico::where('num_bico', '=', trim($registro[3]))->first();

                                            $preco = DB::table('combustiveis')
                                                ->select('combustiveis.valor')
                                                ->leftJoin('tanques', 'tanques.combustivel_id', 'combustiveis.id')
                                                ->leftJoin('bicos', 'bicos.tanque_id', 'tanques.id')
                                                ->where('bicos.id', '=', trim($registro[3]))
                                                ->first();



                                            $veiculo = Veiculo::where('placa', '=', $this->formataPlacaVeiculo(trim($registro[13])))->first();

                                            if (!$bico) {
                                                $obs .= 'Bico [' . trim($registro[3]) . ']: Não encontrado!&#10;';
                                            } else {
                                                $abastecimento->bico_id = $bico->id;
                                            }



                                            // confi->id é o caodigo do posto de abastecimento
                                            $abastecimento->posto_abastecimentos_id = $config->id;
                                            $abastecimento->id_automacao = trim($registro[1]);
                                            $abastecimento->ns_automacao = trim($registro[2]);
                                            $abastecimento->data_hora_abastecimento = $this->formataDataHoraAbastecimento($registro[4] . $registro[5])->format('Y-m-d H:i:s');

                                            if ($cfgPreco->value) {

                                                if (!$preco) {
                                                    $abastecimento->valor_abastecimento = $this->formataValorDecimal(trim($registro[6]));
                                                    $abastecimento->valor_litro = $this->formataValorDecimal(trim($registro[8]), trim($registro[9]));
                                                } else {
                                                    $abastecimento->valor_abastecimento = ($this->formataValorDecimal(trim($registro[7]), 3) * $preco->valor);
                                                    $abastecimento->valor_litro = $preco->valor;
                                                }
                                            } else {
                                                $abastecimento->valor_abastecimento = $this->formataValorDecimal(trim($registro[6]));
                                                $abastecimento->valor_litro = $this->formataValorDecimal(trim($registro[8]), trim($registro[9]));
                                            }

                                            $abastecimento->volume_abastecimento = $this->formataValorDecimal(trim($registro[7]), 3);

                                            $abastecimento->encerrante_inicial = $this->formataValorDecimal(trim($registro[10]));
                                            $abastecimento->encerrante_final = $this->formataValorDecimal(trim($registro[11]));
                                            $abastecimento->km_veiculo = $this->formataValorDecimal(trim($registro[15]), 1);
                                            /* se valor total zerado, calcula valor total */
                                            if ($abastecimento->valor_abastecimento == 0) {
                                                $abastecimento->valor_abastecimento = round($abastecimento->volume_abastecimento * $abastecimento->valor_litro, 2);
                                            }



                                            if (!$veiculo) {  // verifica se nao veio veiculo no arquivo


                                                if (!$atendente->veiculo_id) { //verifica se no cadastro de atendente nao possui veiculo
                                                    $abastecimento->media_veiculo = 0;
                                                    $obs .= 'Veículo [' . trim($registro[14]) . ']: Não encontrado!&#10;';
                                                } else {
                                                    $abastecimento->veiculo_id = $atendente->veiculo_id;
                                                    $veiculo = Veiculo::where('id', '=', $atendente->veiculo_id)->first();
                                                    $abastecimento->media_veiculo = $abastecimentoController->obterMediaVeiculo($veiculo, $abastecimento) ?? 0;
                                                }
                                            } else {
                                                $abastecimento->veiculo_id = $veiculo->id;
                                                $abastecimento->media_veiculo = $abastecimentoController->obterMediaVeiculo($veiculo, $abastecimento) ?? 0;
                                                // Log::debug('Media_Veiculo='.$abastecimento->media_veiculo);
                                            }

                                            if ($abastecimento->km_veiculo <= 0) {
                                                $obs .= 'KM não informada para.&#10;';
                                            }

                                            if ($obs) {
                                                $obs = 'Inconsistências encontradas, verifique.&#10;' . $obs;
                                                $abastecimento->obs_abastecimento = $obs;
                                                $abastecimento->inconsistencias_importacao = true;
                                            }


                                            $dataAbastecimento = $this->formataDataHoraAbastecimento($registro[4] . $registro[5]);
                                            // validação de data do abastecimento maior que o ultimo
                                            /* if ($dataAbastecimento <= $dataInicio) {

                                                continue; //pula para o proximo abastecimento
                                            }
                                            */
                                        } catch (\Exception $e) {
                                            if (App::environment('local')) {
                                                Log::debug($e);
                                            } else {
                                                Log::error($e->getMessage());
                                            }
                                        }
                                        //verifica se exite abastecimento repetido no banco de dados
                                        $abastecimento_repetido = DB::table('abastecimentos')
                                            ->select('abastecimentos.id')
                                            ->where('abastecimentos.id_automacao', '=', trim($registro[3]))
                                            ->where('abastecimentos.data_hora_abastecimento', '=', $this->formataDataHoraAbastecimento($registro[4] . $registro[5])->format('Y-m-d H:i:s'))
                                            ->first();
                                        if (!$abastecimento_repetido) {

                                            try {

                                                DB::beginTransaction();

                                                if ($abastecimento->save()) {

                                                    if (MovimentacaoCombustivelController::saidaAbastecimento($abastecimento)) {
                                                        DB::commit();
                                                        Log::info('Novo abastecimento: ' . $abastecimento . ' importado da Automação.');
                                                    } else {
                                                        throw new \Exception('Erro ao efetuar a movimentação no tanque. [' . implode("|", $registro) . ']');
                                                    }
                                                } else {

                                                    throw new \Exception('Erro ao inserir o abastecimento. [' . implode("|", $registro) . ']');
                                                }
                                            } catch (\Exception $e) {

                                                $errosImportacao = true;
                                                DB::rollback();
                                                if (App::environment('local')) {
                                                    Log::debug($e);
                                                } else {
                                                    Log::error($e->getMessage());
                                                    Log::debug($e);
                                                }
                                            }
                                        } else {
                                            Log::debug('Abastecimento ja existe no banco de dados : ' . $abastecimento);
                                        }
                                    } else {
                                        Log::alert('Erro ao importar registro: ' . implode("|", $registro), []);
                                    }
                                }
                            } finally {
                                // Elimina o arquivo do servidor apenas se conseguir importar todos os abastecimentos */

                                if (!$errosImportacao) {
                                    Storage::disk('ftp' . $i)->delete('abastecimentos.hir');
                                    //$this->limparArquivoAbastecimentosServidor($i);
                                }
                            }

                            //Session::flash('success', 'Abastecimentos Importados com sucesso!');
                            //return redirect()->action('AbastecimentoController@index');
                        }
                    } catch (\Exception $e) {
                        Session::flash('error', __('messages.exception', [
                            'exception' => $e->getMessage()
                        ]));
                    }
                }
                $i++;
            }

            Session::flash('success', 'Processo de importação finalizado');
            return redirect()->action('AbastecimentoController@index');
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));

            return redirect()->back();
        }
    }



    public function ParamTesteExportarHiro()
    {


        return View('integracao_hiro.index');
    }

    public function TesteExportarHiro(Request $request)
    {

        $arquivoEntrada = $request->entrada;
        $arquivosaida = $this->cryptAPI($request->entrada);
        return View('integracao_hiro.index')->witharquivoEntrada($arquivoEntrada);
    }



    protected function limparArquivoAbastecimentosServidorold()
    {
        if (App::environment('local')) {
            Log::info('Arquivo remoto de integração não removido por estar em ambiente de testes...');
            return;
        } else {
            if (!Storage::disk($this->disk())->delete('abastecimentos.hir')) {
                Log::alert('Não foi possível apagar o arquivo abastecimentos.hir do servidor...', []);
            }
        }
    }

    protected function limparArquivoAbastecimentosServidor(int $i)
    {


        if (App::environment('local')) {
            log::debug('Arquivo remoto de integração não removido por estar em ambiente de testes...' . $i, []);
            Log::info('Arquivo remoto de integração não removido por estar em ambiente de testes...');
            return;
        } else {
            if (Storage::disk('ftp' . $i)->exists('abastecimentos.hir')) {
                log::debug('deletando arquivo de abastecimentos...' . $i, []);

                Storage::disk(Storage::disk('ftp' . $i))->delete('abastecimentos.hir');
            }

            if (!Storage::disk(Storage::disk('ftp' . $i))->delete('abastecimentos.hir')) {
                log::debug('Não foi possível apagar o arquivo abastecimentos.hir do servidor...' . $i, []);
                Log::alert('Não foi possível apagar o arquivo abastecimentos.hir do servidor...', []);
            } else {
                log::debug('arquivo apagado:' . $i);
            }
        }
    }


    protected function cryptAPI($data)
    {
        $key = 106;
        $result = null;

        $bytes = unpack('C*', $data);

        foreach ($bytes as $byte) {
            $result .= pack('C*', $byte ^ $key);
        }


        return $result;
    }

    protected function configFTP()
    {
        try {
            $configs = SettingController::getGroupSetting(1)->settings()->get(); //ID = 1 (FTP)

            //return $configs;
            foreach ($configs as $config) {
                // dd($configs);
                switch ($config['key']) {
                    case 'ftp_server':
                        Config::set('filesystems.disks.ftp.host', $config['value']);
                        break;
                    case 'ftp_user':
                        Config::set('filesystems.disks.ftp.username', $config['value']);
                        break;
                    case 'ftp_pass':
                        Config::set('filesystems.disks.ftp.password', $config['value']);
                        break;
                    case 'ftp_port':
                        Config::set('filesystems.disks.ftp.port', (int)$config['value']);
                        break;
                    case 'ftp_root':
                        Config::set('filesystems.disks.ftp.root', $config['value']);
                        break;
                    case 'ftp_passive':
                        Config::set('filesystems.disks.ftp.passive', (bool)$config['value']);
                        break;
                    case 'ftp_ssl':
                        Config::set('filesystems.disks.ftp.ssl', (bool)$config['value']);
                        break;
                    case 'ftp_timeout':
                        Config::set('filesystems.disks.ftp.timeout', (int)$config['value']);
                        break;
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Erro na configuração da Conta FTP. [' . $e->getMessage() . '].');
        }
    }

    protected function configFTPs(PostoAbastecimento $config, int $i)
    {
        try {

            //$configs = PostoAbastecimento::paginate();
            //return $configs;



            Log::debug('configurando ftp  ' . $i . ' - ' . $config->ftp_user);

            Config::set('filesystems.disks.ftp' . $i . '.host', $config->ftp_server);

            Config::set('filesystems.disks.ftp' . $i . '.username', $config->ftp_user);

            Config::set('filesystems.disks.ftp' . $i . '.password', $config->ftp_pass);

            Config::set('filesystems.disks.ftp' . $i . '.port', $config->ftp_port);

            Config::set('filesystems.disks.ftp' . $i . '.root', $config->ftp_root);

            Config::set('filesystems.disks.ftp' . $i . '.passive', $config->ftp_passive);

            Config::set('filesystems.disks.ftp' . $i . '.ssl', $config->ftp_ssl);

            Config::set('filesystems.disks.ftp' . $i . '.timeout', $config->ftp_timeout);

            Log::debug('lendo configuracao : ' . Config::get('filesystems.disks.ftp' . $i . '.username'));
            Log::debug('lendo configuracao : ' . Config::get('filesystems.disks.ftp' . $i . '.host'));
        } catch (\Exception $e) {
            throw new \Exception('Erro na configuração da Conta FTP. [' . $e->getMessage() . '].');
        }
    }
}
