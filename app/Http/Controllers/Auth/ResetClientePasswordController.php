<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Cliente\ResetPasswordService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResetClientePasswordController
{
    private ResetPasswordService $resetPasswordService;

    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->resetPasswordService = $resetPasswordService;
    }

    public function resetPassword(Request $request)
    {
        $email = $request->post('email');
        $cpf = $request->post('cpf');
        try {
            $this->resetPasswordService->resetPassword($cpf, $email);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
        return new JsonResponse(['message' => 'Uma nova senha foi enviada para seu email.']);
    }

    public function ResetPasswordInfo(Request $request)
    {
        $cpf = $request->post('cpf');
        $email = $this->resetPasswordService->getInfo($cpf);
        if (!$email) {
            $message = 'Nenhum email registrado para o cpf informado.';
            return new JsonResponse(compact('message'), 400);
        }
        return new JsonResponse(compact('email'));
    }
}
