<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class CarneController extends Controller
{
    public function criarCarne(Request $request)
    {

        try {
            $request->validate([
                'valor_total' => 'required|numeric|min:0.01',
                'qtd_parcelas' => 'required|integer|min:1',
                'data_primeiro_vencimento' => 'required|date_format:Y-m-d|after_or_equal:today',
                'periodicidade' => 'required|in:mensal,semanal',
                'valor_entrada' => 'nullable|numeric|min:0|lt:valor_total',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Os dados fornecidos são inválidos.',
                'errors' => $e->errors()
            ], 422);
        }

        $valorTotal = $request->input('valor_total');
        $qtdParcelas = $request->input('qtd_parcelas');
        $dataPrimeiroVencimento = Carbon::parse($request->input('data_primeiro_vencimento'));
        $periodicidade = $request->input('periodicidade');
        $valorEntrada = $request->input('valor_entrada', 0);

        $intervalo = $periodicidade === 'mensal' ? '1 month' : '1 week';

        $parcelas = [];
        $valorRestante = $valorTotal - $valorEntrada;
        $valorParcela = $valorRestante / $qtdParcelas;

        if ($valorEntrada > 0) {
            $parcelas[] = [
                'data_vencimento' => $dataPrimeiroVencimento->format('Y-m-d'),
                'valor' => $valorEntrada,
                'numero' => 1,
                'entrada' => true,
            ];
            $dataPrimeiroVencimento->add($intervalo);
        }

        for ($i = 0; $i < $qtdParcelas; $i++) {
            $parcelas[] = [
                'data_vencimento' => $dataPrimeiroVencimento->format('Y-m-d'),
                'valor' => round($valorParcela, 2),
                'numero' => count($parcelas) + 1,
                'entrada' => false,
            ];
            $dataPrimeiroVencimento->add($intervalo);
        }

        return response()->json([
            'total' => $valorTotal,
            'valor_entrada' => $valorEntrada,
            'parcelas' => $parcelas,
        ]);
    }

    public function recuperarParcelas($id)
    {
        // TODO - Atualmente sem conexao com o banco para recuperar as parcelas
        $parcelas = [];

        return response()->json($parcelas);
    }
}

