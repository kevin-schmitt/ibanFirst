<?php

namespace App\Controller;

use App\Api\IbanFirstApi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Exception;
/**
 * @Route("/api/wallets")
 */
class WalletController
{
    private $ibanFirstApi;

    public function __construct(IbanFirstApi $ibanFirstApi)
    {
        $this->ibanFirstApi = $ibanFirstApi;
    }

    /**
     * list wallets
     * @Route("",  methods={"GET"})
     * @return JsonResponse
     */
    public function list()
    {
        $status = Response::HTTP_OK;

        try
        {
            $response = $this->ibanFirstApi->wallets();
        } catch(Exception $e)
        {
            $status = $e->getCode();
            $response['errors'] = $e->getMessage();
        }

        return new JsonResponse(
            $response,
            $status
        );
    }

    /**
     * get all finacial movement for wallet id specify
     * @Route("/{walletId}/financial_movements",  methods={"GET"})
     * @return JsonResponse
     */
    public function financialMovements(string $walletId)
    {
        $status = Response::HTTP_OK;

        try
        {
            $response = $this->ibanFirstApi->financialMovements($walletId);
        } catch(Exception $e)
        {
            $status = $e->getCode();
            $response['errors'] = $e->getMessage();
        }

        return new JsonResponse(
            $response,
            $status
        );
    }
}