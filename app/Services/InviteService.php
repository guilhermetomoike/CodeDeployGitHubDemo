<?php


namespace App\Services;


use App\Repositories\InviteRepository;

class InviteService
{
    private InviteRepository $inviteRepository;

    public function __construct(InviteRepository $inviteRepository)
    {
        $this->inviteRepository = $inviteRepository;
    }

    public function create(array $array)
    {
        return $this->inviteRepository->create($array);
    }

    public function getAll($request)
    {
        return $this->inviteRepository->getAll($request);
    }

    public function getByCustomer(int $customerId)
    {
        return $this->inviteRepository->getInviteByCustomerId($customerId);
    }

    public function delete(int $id)
    {
        return $this->inviteRepository->delete($id);
    }
}
