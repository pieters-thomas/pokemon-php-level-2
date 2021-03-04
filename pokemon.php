<?php

class pokemon
{
    private string $name;
    private string $id;
    private string $sprite;

    public function __construct($identifier)
    {
        $pokeData = json_decode(file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $identifier), true, 512, JSON_THROW_ON_ERROR);

        $this->name = $pokeData['species']['name'];
        $this->id = $pokeData['id'];
        $this->sprite = $pokeData['sprites']['front_default'];
    }

    public function printPokemon(): void
    {
        $html = '<div class="gridSlot">'
            . '<a href=' . 'pokedex/pokedex.php?find=' . $this->name . '>'
            . '<img class="gridSprite" src=' . $this->sprite . ' alt="pokemon image">'
            . '<div class="gridTag">#' . $this->id . ' ' . $this->name . '</div>'
            . '</a></div>';

        echo $html;
    }

}