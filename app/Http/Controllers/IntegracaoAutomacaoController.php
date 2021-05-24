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

class IntegracaoAutomacaoController extends Controller
{
    private function disk() {
        return (App::environment('local')) ? 'local' : 'ftp';
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
    public function ExportarAtendentes() {
        try {
            $conteudo = '';
            $atendentes = Atendente::where('ativo', true)->get();
            foreach ($atendentes as $atendente) {
                $conteudo .= '<01;';
                $conteudo .= substr('                '.$atendente->senha_atendente, -8).';';
                $conteudo .= substr('          '.$atendente->usuario_atendente, -10);
                $conteudo .= '>';
            }

            Log::debug($conteudo);

            $conteudo = $this->cryptAPI($conteudo);

            /* Config da conta de FTP */
            $this->configFTP();

            Storage::disk($this->disk())->put('funcionarios.hir', $conteudo);
        
            Session::flash('success', 'Dados Exportados com sucesso!');
            return redirect()->action('HomeController@index');
        
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));

            
        }
    }

    public function ExportarMotoristas() {
        try {
            $conteudo = '';
            $motoristas = Motorista::whereNotNull('tag')->where('ativo', true)->get();
            foreach ($motoristas as $motorista) {
                $conteudo .= '<01;';
                $conteudo .= substr('                '.$motorista->tag, -8).';';
                $conteudo .= substr('          '.$motorista->nome, -10);
                $conteudo .= '>';
            }

            Log::debug($conteudo);

            $conteudo = $this->cryptAPI($conteudo);

            /* Config da conta de FTP */
            $this->configFTP();

            Storage::disk($this->disk())->put('funcionarios.hir', $conteudo);
        
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

    public function ExportarProdutos() {
        try {
            $conteudo = '';
            $produtos = Produto::where('ativo', true)->get();
            foreach ($produtos as $produto) {
                $conteudo .= '<01;';
                $conteudo .= substr('   '.$produto->id, -3).';';
                $conteudo .= substr('          '.$produto->produto_desc_red, -10);
                $conteudo .= '>';
            }

            $conteudo = $this->cryptAPI($conteudo);

            /* Config da conta de FTP */
            $this->configFTP();

            Storage::disk($this->disk())->put('produtos.hir', $conteudo);
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
    
    public function ExportarVeiculos() {
        try {
            $conteudo = '';
            $veiculos = Veiculo::where('ativo', true)->get();
            foreach ($veiculos as $veiculo) {
                $conteudo .= '<01;';
                $conteudo .= substr('                '.$veiculo->placa, -16).';';
                $conteudo .= substr('        '.$veiculo->tag, -8);
                $conteudo .= '>';
            }

            $conteudo = $this->cryptAPI($conteudo);

            /* Config da conta de FTP */
            $this->configFTP();

            Storage::disk($this->disk())->put('veiculos.hir', $conteudo);
            Session::flash('success', 'Dados Exportados com sucesso!');
            return redirect()->action('HomeController@index');

        } catch(\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));

            return redirect()->back();
        }
    }

    public function Exportar() {
        $this->ExportarAtendentes();
        $this->ExportarProdutos();
        $this->ExportarVeiculos();

        Session::flash('success', 'Dados Exportados com sucesso!');
        return redirect()->action('HomeController@index');
    }

    protected function formataDataHoraAbastecimento(String $dataHora) {
        $b = null;
        $dataHora = str_replace(' ', '0', $dataHora);
        foreach (str_split($dataHora, 2) as $a) {
            $b .= $b ? '-' : '';
            $b .= trim($a);
        }
        return \DateTime::createFromFormat('d-m-y-H-i-s', $b);
    }

    protected function formataValorDecimal($valor, $numCasas = 2) {
        if ($numCasas > 0) {            
            return floatval(substr($valor, 0, ($numCasas * -1)).'.'.substr($valor, ($numCasas * -1)));
        } else {
            return floatval($valor);
        }
    }

    protected function formataPlacaVeiculo($placa) {
        
        return strtoupper(substr($placa, 0, 3).'-'.substr($placa, -4));
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
    public function ImportarAbastecimentos() {
        if (App::environment('local')) {
            Log::debug('Tarefa agendada: Importação de Abastecimento... [ambiente de desenvolvimento]');
            //return;
        }

         // verifica se na configuracao esta habilitado preco do cadastro do combustivel
        $cfgPreco = DB::table('settings')
                                ->select('settings.value')
                                ->where('settings.key','automacao_valor_combustivel')
                                ->first();
                                //dd($cfgPreco->value);
        
        try {
            /* Config da conta de FTP */
            $this->configFTP();

            $errosImportacao = false;
            if (Storage::disk($this->disk())->exists('abastecimentos.hir')) {
                
                try {
                    $arquivo = Storage::disk($this->disk())->get('abastecimentos.hir');
                    $arquivo = $this->cryptAPI($arquivo);
                   
                    
                    
                    $registros = array();
                    
                    $linhas = explode('>', $arquivo);

                    foreach ($linhas as $linha) {
                        $linha = str_replace('<', '', $linha);
                        $linha = explode(';', $linha);
                        if (count($linha) > 1) {
                            $registros[] = $linha;
                        }
                    }
                    
                    
                    $dataInicio = \DateTime::createFromFormat('Y-m-d H:i:s', 
                                        Abastecimento::whereNotNull('id_automacao')
                                                ->orderBy('data_hora_abastecimento', 'desc')
                                                ->pluck('data_hora_abastecimento')
                                                ->first());
                                               // dd($registros);

                    foreach ($registros as $registro)  {
                        if (count($registro) == 17) {
                            
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
                        
                               // dd('placa', '=', $this->formataPlacaVeiculo(trim($registro[13]))); 
                                $veiculo = Veiculo::where('placa', '=', $this->formataPlacaVeiculo(trim($registro[13])))->first();
        
        
                                if (!$bico) {   
                                    $obs .= 'Bico ['.trim($registro[3]).']: Não encontrado!&#10;';
                                } else {
                                    $abastecimento->bico_id = $bico->id;
                                }
        
                                if (!$atendente) {
                                    $obs .= 'Atendente ['.trim($registro[12]).']: Não encontrado!&#10;';
                                } else {
                                    $abastecimento->atendente_id = $atendente->id;
                                }
                                
                                
                                $abastecimento->id_automacao = trim($registro[1]);
                                $abastecimento->ns_automacao = trim($registro[2]);           
                                $abastecimento->data_hora_abastecimento = $this->formataDataHoraAbastecimento($registro[4].$registro[5])->format('Y-m-d H:i:s');
                                
                                
                                if ($cfgPreco->value){
                                    if (!$preco){
                                        $abastecimento->valor_abastecimento = $this->formataValorDecimal(trim($registro[6]));
                                        $abastecimento->valor_litro = $this->formataValorDecimal(trim($registro[8]), trim($registro[9]));

                                    }else{
                                        $abastecimento->valor_abastecimento = ($this->formataValorDecimal(trim($registro[7]), 3) * $preco->valor);
                                        $abastecimento->valor_litro = $preco->valor;
                                    }

                                     
                                    
                                }else{
                                    $abastecimento->valor_abastecimento = $this->formataValorDecimal(trim($registro[6]));
                                    $abastecimento->valor_litro = $this->formataValorDecimal(trim($registro[8]), trim($registro[9]));
                                }
                                
                                
                              
                                $abastecimento->volume_abastecimento = $this->formataValorDecimal(trim($registro[7]), 3);
                                
                                $abastecimento->encerrante_inicial = $this->formataValorDecimal(trim($registro[10]));
                                $abastecimento->encerrante_final = $this->formataValorDecimal(trim($registro[11]));                                
                        
                                /* se valor total zerado, calcula valor total */
                                if ($abastecimento->valor_abastecimento == 0) {
                                    $abastecimento->valor_abastecimento = round($abastecimento->volume_abastecimento * $abastecimento->valor_litro, 2);
                                }
        
                                if (!$veiculo) {  // verifica se nao veio veiculo no arquivo
                                    
                                    
                                    if (!$atendente->veiculo_id){//verifica se no cadastro de atendente nao possui veiculo
                                        $abastecimento->media_veiculo = 0;
                                        $obs .= 'Veículo ['.trim($registro[14]).']: Não encontrado!&#10;';
                                    }else{
                                        $abastecimento->veiculo_id = $atendente->veiculo_id;
                                        $abastecimento->km_veiculo = $this->formataValorDecimal(trim($registro[15]), 1); 
                                        $veiculo = Veiculo::where('id', '=',$atendente->veiculo_id)->first(); 
                                        $abastecimento->media_veiculo = $abastecimentoController->obterMediaVeiculo($veiculo, $abastecimento) ?? 0;
                                    }
                                    
                                } else {
                                    $abastecimento->veiculo_id = $veiculo->id;
                                    //if ( $veiculo->modelo_veiculo->tipo_controle_veiculo_id == 1) {
                                        /* controle de km rodados */
                                    $abastecimento->km_veiculo = $this->formataValorDecimal(trim($registro[15]), 1);
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
                                
                                if ($obs){
                                    $obs = 'Inconsistências encontradas, verifique.&#10;'.$obs;
                                    $abastecimento->obs_abastecimento = $obs;
                                    $abastecimento->inconsistencias_importacao = true;
                                } 
                                
                                $dataAbastecimento = $this->formataDataHoraAbastecimento($registro[4].$registro[5]);
                               
                                
                               
                                //Log::debug($dataInicio);


                                 if ($dataAbastecimento <= $dataInicio) {
                                    
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
                                
                                if($abastecimento->save()) {
                                    // Movimenta o estoque do tanque 
                                    if (MovimentacaoCombustivelController::saidaAbastecimento($abastecimento)) {
                                        DB::commit();
                                        Log::info('Novo abastecimento: '.$abastecimento.' importado da Automação.');
                                    } else {
                                        throw new \Exception('Erro ao efetuar a movimentação no tanque. ['.implode("|",$registro).']');
                                    }
                                } else {
                                    throw new \Exception('Erro ao inserir o abastecimento. ['.implode("|",$registro).']');
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
                            Log::alert('Erro ao importar registro: '.implode("|",$registro), []);
                        }
                    }
                } finally {
                    // Elimina o arquivo do servidor apenas se conseguir importar todos os abastecimentos */
                    if (!$errosImportacao) {
                        $this->limparArquivoAbastecimentosServidor();
                    }
                }
                
                Session::flash('success', 'Abastecimentos Importados com sucesso!');
                return redirect()->action('AbastecimentoController@index');
            } else {
                Session::flash('success', 'Não existem abastecimentos a serem importados!');
                return redirect()->action('AbastecimentoController@index');
            }
        } catch(\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));

            return redirect()->back();
        }

        }
    public function ParamTesteExportarHiro() {

        
        return View('integracao_hiro.index');
    
    }

    public function TesteExportarHiro(Request $request) {

        $arquivoEntrada = $request->entrada;
        $arquivosaida = $this->cryptAPI($request->entrada);
        return View('integracao_hiro.index')->witharquivoEntrada($arquivoEntrada);
    
    }



    protected function limparArquivoAbastecimentosServidor() {
        if (App::environment('local')) {
            Log::info('Arquivo remoto de integração não removido por estar em ambiente de testes...');
            return;
        } else {
            if (!Storage::disk($this->disk())->delete('abastecimentos.hir')) {
                Log::alert('Não foi possível apagar o arquivo abastecimentos.hir do servidor...', []);
            }   
        }
    }

    protected function cryptAPI($data) {
        $key = 106;
        $result = null;

        $bytes = unpack('C*', $data);

        foreach ($bytes as $byte) {
            $result .= pack('C*', $byte ^ $key);
        }

        
        return $result;

    }

    protected function configFTP() {
        try {
            $configs = SettingController::getGroupSetting(1)->settings()->get(); //ID = 1 (FTP)

            //return $configs;
            foreach($configs as $config) {
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
            throw new \Exception('Erro na configuração da Conta FTP. ['.$e->getMessage().'].');
        }
    }
}
