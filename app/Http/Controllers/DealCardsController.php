<?php

namespace App\Http\Controllers;

use App\Services\CardsService;
use Illuminate\Http\Request;

class DealCardsController extends Controller
{
    private $cardsService;

    public function __construct(CardsService $cardsService) {
        $this->cardsService = $cardsService;
    }

    function shuffleDeck (Request $request) {
        return $this->cardsService->shuffle($request);
    }

}
