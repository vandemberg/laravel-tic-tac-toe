<?php
namespace Tests\Infrastructure\API;

use App\Models\Match;
use Tests\TestCase;

class MatchApiTest extends TestCase
{

    private function init()
    {
        $match = $this->createMatch();

        foreach ([0, 1, 2, 3, 4, 5, 6, 7, 8] as $position) {
            $this->createMove($position, $match->id);
        }

    }

    public function testIndex()
    {
        $this->init();
        $this->json('GET', '/api/match')
            ->assertStatus(200)
            ->assertJsonStructure([
                ['id', 'name', 'winner', 'next', 'board' => []]
            ]);
    }

    public function testStore()
    {
        $this->init();
        $this->json('POST', '/api/match')
            ->assertStatus(201)
            ->assertJsonStructure([
                ['id', 'name', 'winner', 'next', 'board' => []]
            ]);
    }

    public function testShow()
    {
        $this->init();

        $match = Match::all()->first();

        $this->json('GET', "/api/match/{$match->id}")
            ->assertStatus(200)
            ->assertJsonStructure(
                ['id', 'name', 'winner', 'next', 'board' => []]
            );
    }

    public function testUpdate()
    {
        $this->init();

        $match = Match::all()->first();

        $this->json('PUT', "/api/match/{$match->id}", ['position' => 0])
            ->assertStatus(200)
            ->assertJsonStructure(
                ['id', 'name', 'winner', 'next', 'board' => []]
            );
    }

    public function testUpdateWithOutPosition()
    {
        $this->init();

        $match = Match::all()->first();

        $this->json('PUT', "/api/match/{$match->id}")
            ->assertStatus(422);
    }

    public function testDelete()
    {
        $this->init();

        $match = Match::all()->first();

        $this->json('DELETE', "/api/match/{$match->id}")
            ->assertStatus(200);
    }
}