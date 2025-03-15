<?php

namespace App\Services;

use Illuminate\Http\Request;
use Exception;

class CardsService
{
    public function shuffle(Request $request) {
        try {
            $n = $request->query('n', 1);
            $deck = $this->generateDeck();
            shuffle($deck);

            $players = array_fill(0, $n, []);
            for ($i = 0; $i < count($deck); $i++) {
                $players[$i % $n][] = $deck[$i];
            }

            $output = [];
            foreach ($players as $player) {
                $output[] = implode(',', $player);
            }

            return response()->json($output);
        } catch (Exception $e) {
            return response()->json(["error" => "Irregularity occurred"]);
        }
    }

    private function generateDeck() {
        $suits = ['S', 'H', 'D', 'C'];
        $values = [1 => 'A', 2, 3, 4, 5, 6, 7, 8, 9, 10 => 'X', 11 => 'J', 12 => 'Q', 13 => 'K'];

        $deck = [];
        foreach ($suits as $suit) {
            foreach ($values as $num => $val) {
                $deck[] = "$suit-$val";
            }
        }
        return $deck;
    }
}
