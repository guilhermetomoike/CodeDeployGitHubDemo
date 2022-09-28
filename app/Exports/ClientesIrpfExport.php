<?php

namespace App\Exports;

use App\Models\Arquivo;
use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ClientesIrpfExport
extends DefaultValueBinder
implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithCustomValueBinder
{
    private array $params;

    private array $heads = ['empresas', 'nome', 'email', 'telefone', 'carteiras', 'respondeu_questionario', 'enviou_todas_pendencias', 'data_envio_ultima_pendencia', 'ano'];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function collection()
    {
        $ano = !array_key_exists('ano', $this->params) || $this->params['ano'] == 'null'
            ? now()->subYear()->year
            : $this->params['ano'];

        return Cliente
            ::query()
            ->select('id', 'nome_completo')
            ->with([
                'celulares',
                'emails',
                'empresa',
                'empresa.carteiras',
                'irpf' => function ($query) use ($ano) {
                    $query->where('ano', $ano);
                },
                'irpf.resposta.pendencia',
                'irpf.pendencias',
            ])
            ->whereHas('irpf', function ($query) use ($ano) {
                $query->where('ano', $ano);
            })
            ->get()
            ->transform(function ($cliente) use ($ano) {
                $empresas = $cliente->empresa->map(fn ($empresa) => $empresa->id)->toArray();
                $carteiras = $cliente
                    ->empresa
                    ->map(fn ($empresa) => $empresa->carteiras)
                    ->flatten()
                    ->map(fn ($carteira) => $carteira->nome)
                    ->toArray();
                $respondeuQuestionario = $cliente->irpf && $cliente->irpf->resposta ? $cliente->irpf->resposta->count() > 0 : false;
                $enviouPendencias = false;
                $dataPendencia = '';

                if ($respondeuQuestionario) {
                    $requiredPendencias = $cliente
                        ->irpf
                        ->resposta
                        ->filter(fn ($resposta) => $resposta->resposta)
                        ->map(fn ($resposta) => isset($resposta->pendencia->id) ? [
                            'id' => $resposta->pendencia->id,
                            'quantidade' => (int)$resposta->quantidade,
                        ] : ['quantidade' => (int)$resposta->quantidade])
                        ->sortBy('id')
                        ->values();
                    $validPendencias = $cliente
                        ->irpf
                        ->pendencias
                        ->filter(fn ($pendencia) => collect($pendencia->inputs)->contains(fn ($item) => ($item['value'] ?? false)));
                    $sentPendencias = $validPendencias
                        ->map(fn ($pendencia) => $pendencia->irpf_pendencia_id)
                        ->groupBy(fn ($value) => $value)
                        ->map(fn ($pendencia) => [
                            'id' => $pendencia[0],
                            'quantidade' => $pendencia->count(),
                        ])
                        ->sortBy('id')
                        ->values();
                    $diffPendencias = $requiredPendencias
                        ->map(fn ($item) => serialize($item))
                        ->diffAssoc($sentPendencias->map(fn ($item) => serialize($item)))
                        ->map(fn ($value) => unserialize($value));
                    $checkDiffPendencias = $diffPendencias->filter(fn ($item, $key) => ($sentPendencias[$key]['quantidade'] ?? 0) < $item['quantidade']);
                    $enviouPendencias = $requiredPendencias->count() <= $sentPendencias->count() && !$checkDiffPendencias->count();
                    $lastSentPendencia = $validPendencias
                        ->map(fn ($pendencia) => collect($pendencia->inputs)->map(fn ($input) => $input['value'] ?? null)->values())
                        ->flatten()
                        ->sort()
                        ->last();
                    $pendencyFile = $lastSentPendencia ? Arquivo::query()->find($lastSentPendencia) : null;
                    $dataPendencia = $pendencyFile ? $pendencyFile->created_at->format('d/m/Y') : '';
                }

                
                return [
                    'empresas' => implode(',', $empresas),
                    'nome' => $cliente->nome_completo,
                    'email' => $cliente->emails->first()->value ?? '',
                    'telefone' => $cliente->celulares->first()->value ?? '',
                    'carteiras' => implode(', ', $carteiras),
                    'respondeu_questionario' => $respondeuQuestionario ? 'Sim' : 'Não',
                    'enviou_todas_pendencias' => $enviouPendencias ? 'Sim' : 'Não',
                    'data_envio_ultima_pendencia' => $dataPendencia,
                    'ano' => $ano,
                ];
            })
            ->prepend($this->heads);
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
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
