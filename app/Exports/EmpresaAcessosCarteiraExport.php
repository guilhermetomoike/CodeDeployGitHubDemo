<?php

namespace App\Exports;

use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmpresaAcessosCarteiraExport
    extends DefaultValueBinder
    implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithCustomValueBinder, WithColumnWidths
{
    private array $params;

    private array $heads = ['numero','cnpj', 'razao_social','Email_Socio_Adm','site', 'login', 'senha', 'cidade', 'estado','carteira', 'regime'];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function collection()
    {
        return Empresa::with([
            'endereco',
            'acessos_prefeituras' => fn($acesso) => $acesso->where('tipo', 'emissor'),
            'carteirasrel',
        ])
            ->when($this->params['carteira'] ?? false, function ($query, $value) {
                $query->whereHas('carteirasrel', fn($carteira) => $carteira->where('carteiras.id', $value));
            })
            ->when($this->params['congelada'] ?? false, function ($query, $value) {
                $query->where('congelada', 1);
            })
            ->get()
            ->transform(function ($empresa) {
                $site = $empresa->acessos_prefeituras->count() ? $empresa->acessos_prefeituras[0]->site : null;
               
                $login = $empresa->acessos_prefeituras->count() ? $empresa->acessos_prefeituras[0]->login : null;
                $senha = $empresa->acessos_prefeituras->count() ? $empresa->acessos_prefeituras[0]->senha : null;
                $email = isset($empresa->socioAdministrador->emails)  ? $empresa->socioAdministrador[0]->emails[0]->value : null;
                      
                // $carteiras = $empresa->carteiras->count() ? $empresa->carteiras[0]->nome : null;
                // $carteiras = count($empresa->carteirasrel);
                $carteiras = '';
                foreach ($empresa->carteirasrel as $carteira) {

                    if ($carteiras != '') {
                        $carteiras = $carteira->nome . ' - ' . $carteiras;
                    }
                    if ($carteiras == '') {
                        $carteiras = $carteira->nome;
                    }
                }
                // $carteira = $empresa->carteiras->count() ;
               
                $cidade = $empresa->endereco ? $empresa->endereco->cidade : null;
                $uf = $empresa->endereco ? $empresa->endereco->uf : null;

                return [
                    'id' => $empresa->id,
                    'cpnj' => " ".$empresa->cnpj,
                    'razao_social' => $empresa->razao_social,
                    'Email_Socio_Adm'=>$email,
                    'site' => $site,
                    'login' => " ".$login,
                    'senha' => $senha,
                    'cidade' => $cidade,
                    'estado' => $uf,
                    'carteira' => $carteiras,
                    'regime' => $empresa->regime_tributario,
                ];
            })->prepend($this->heads);
    }

    public function columnFormats(): array
    {
        return [
          
            'E' =>  NumberFormat::FORMAT_TEXT,
            'F' =>  NumberFormat::FORMAT_TEXT,
        ];
    }
    public function columnWidths(): array
    {
        return [
            'C' => 50,
            'D' => 35,
            'E' => 55,
            'F' => 35,
            'G' => 35,       

        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (in_array($value, $this->heads) && $cell->getRow() === 1) {
            $cell->getStyle()->getBorders()->getOutline()->setBorderStyle('thin');
            $cell->getStyle()->getFont()->setBold(true);
            
        }
        return parent::bindValue($cell, $value);
    }
}
