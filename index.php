<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'pokemon.php';
session_start();

//api links;

const API_ALL = 'https://pokeapi.co/api/v2/pokemon?limit=898&offset=0';
const API_POKEMON = 'https://pokeapi.co/api/v2/pokemon/';
const API_TYPE = 'https://pokeapi.co/api/v2/type/';
const OPTIONS = [
    0 => 'random',
    1 => 'normal',
    2 => 'fighting',
    3 => 'flying',
    4 => 'poison',
    5 => 'ground',
    6 => 'rock',
    7 => 'bug',
    8 => 'ghost',
    9 => 'steel',
    10 => 'fire',
    11 => 'water',
    12 => 'grass',
    13 => 'electric',
    14 => 'psychic',
    15 => 'ice',
    16 => 'dragon',
    17 => 'dark',
    18 => 'fairy',
];

//grid values;

const DISPLAY_TOTAL = 36;
const DISPLAY_PAGE = 12;
const ID_RANGE = [1, 898];

//functions

function prepId($type)
{
    $idArray = [];

    if ($type === 'random' || empty($_POST['type'])) {

        $typeList = json_decode(file_get_contents(API_ALL), true, 512, JSON_THROW_ON_ERROR);
        shuffle($typeList['results']);
        for ($i = 0; $i < DISPLAY_TOTAL; $i++) {
            $idArray[] = array_shift($typeList['results'][$i]);
        }
        $_SESSION['listing'] = $idArray;
        return;
    }

    $typeList = json_decode(file_get_contents(API_TYPE . $type), true, 512, JSON_THROW_ON_ERROR);

    shuffle($typeList['pokemon']);

    for ($i = 0; $i < DISPLAY_TOTAL; $i++) {
        $idArray[] = array_shift($typeList['pokemon'][$i]['pokemon']);
    }
    $_SESSION['listing'] = $idArray;
}

function unfoldGrid($startPoint){

    $array = $_SESSION['listing'];

    for ($i = $startPoint; $i < ($startPoint + DISPLAY_PAGE); $i++) {

        $pokemon = new pokemon($array[$i]);
        $pokemon->printPokemon();

    }
}

function unfoldNav($totalPages, $page)
{
    if ($page > 1) {
        echo '<a class="page-link navButton" href="index.php?page=' . ($page - 1) . '" >Previous</a>';
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a class="page-link navButton" href="index.php?page=' . $i . '" >' . $i . '</a>';
    }

    if ($page < $totalPages) {
        echo '<a class="page-link navButton" href="index.php?page=' . ((int)$page + 1) . '" >Next</a>';
    }
}

function unfoldDropdown()
{
    foreach (OPTIONS as $option => $value) {
        echo '<option value="' . $value . '">' . $value . '</option>';
    }
}

//gather id/name for pokemon to display in grid;

if (isset($_POST['type']) || !empty($_POST['type']) || !isset($_SESSION['listing'])) {
    prepId($_POST['type'] ?? 'random');
}

//determine current page and pokemon to display on page

$page = htmlspecialchars((string)($_GET['page'] ?? 1), ENT_NOQUOTES);
$start_from = ($page - 1) * DISPLAY_PAGE;

$totalPages = ceil(DISPLAY_TOTAL / DISPLAY_PAGE);

require 'category-frame.php';