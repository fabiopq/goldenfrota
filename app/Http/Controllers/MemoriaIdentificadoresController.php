<?php

namespace App\Http\Controllers;

use App\MemoriaIdentificadores;
use Illuminate\Http\Request;
use SplFileObject;
use Illuminate\Support\Facades\Session;
use App\ModeloBomba;

class MemoriaIdentificadoresController extends Controller
{
    //
    public function showUploadForm()
    {
        return view('memoria_identificadores.create');
    }

    public $fields = array(
        'id' => 'ID',
        'posicao' => 'Modelo de Bomba',
        'indentificador' => 'Núm. Bicos'
        
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarModeloBomba()) {
            if (isset($request->searchField)) {
                $memoria_identificadores = MemoriaIdentificadores::where('identificador', 'like', '%'.$request->searchField.'%')->paginate();
            } else {
                $memoria_identificadores = MemoriaIdentificadores::paginate();
            }
            return View('memoria_identificadores.index', [
                'modelo_bombas' => $memoria_identificadores,
                'fields' => $this->fields
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        
    }

    public function create(Request $request)
    {
        
    }




    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt', // Permitir apenas arquivos CSV com no máximo 2MB
        ]);

        if ($request->file('file')->isValid()) {
            $path = $request->file('file')->store('uploads'); // Salvar o arquivo na pasta "uploads"

            // Abrir o arquivo CSV e importar os dados para o banco de dados
            $file = fopen(storage_path('app/' . $path), 'r');
            $header = fgetcsv($file); // Ler a linha de cabeçalho do CSV

            MemoriaIdentificadores::truncate();

            // Loop através das linhas do CSV com separador por ponto e virgula
            while (($row = fgetcsv($file, 0, ';')) !== false) {
                // Criar um novo produto com os dados de cada linha

                MemoriaIdentificadores::create([
                    'posicao' => $row[0], // Assumindo que a posição está na primeira coluna do CSV
                    'identificador' => $row[1], // Assumindo que o nome está na segunda coluna do CSV
                    // Adicione aqui mais campos conforme necessário
                ]);
            }

            fclose($file); // Fechar o arquivo CSV

            // Retornar uma resposta de sucesso
            Session::flash('success', __('messages.create_success_f', [
                'model' => __('memoria_identificadores'),
                'name' => ''
            ]));
            return redirect()->action('MemoriaIdentificadoresController@showUploadForm');
        } else {
            // Se o arquivo não for válido, retornar uma resposta de erro
            Session::flash('error', __('messages.exception', [
                'exception' => 'O arquivo enviado é inválido'
            ]));
            return redirect()->back()->withInput();
        }
    }


    private function processCSV($file)
    {
        $csvData = [];
        $file = new SplFileObject($file->getPathname());
        $file->setFlags(SplFileObject::READ_CSV);
        foreach ($file as $row) {
            if (!empty($row[0])) {
                $csvData[] = $row;
            }
        }
        return $csvData;
    }
}
