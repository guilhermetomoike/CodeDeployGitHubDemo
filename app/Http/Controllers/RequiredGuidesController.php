<?php

namespace App\Http\Controllers;

use App\Repositories\RequiredGuidesRepository;
use Illuminate\Http\Request;

class RequiredGuidesController extends Controller
{
    /**
     * @var RequiredGuidesRepository
     */
    private RequiredGuidesRepository $requiredGuidesRepository;

    public function __construct(RequiredGuidesRepository $requiredGuidesRepository)
    {
        $this->requiredGuidesRepository = $requiredGuidesRepository;
    }

    public function index()
    {
        $data = $this->requiredGuidesRepository->getAllRequiredGuides();

        return response($data);
    }
}
