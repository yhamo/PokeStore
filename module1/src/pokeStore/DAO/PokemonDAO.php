<?php

namespace PokeStore\DAO;

use PokeStore\Domain\Pokemon;

class PokemonDAO extends DAO {

    /**
     * @var \PokeStore\DAO\TypeDAO
     */
    private $TypeDAO;

    public function setTypeDAO($TypeDAO) {
        $this->TypeDAO = $TypeDAO;
    }

    /**
     * Returns the list of all Pokemon, sorted by name.
     *
     * @return array The list of all pokemon.
     */
    public function findAll() {
        $sql = "select * from pokemon order by name_pokemon";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $pokemons = array();
        foreach ($result as $row) {
            $pokemonId = $row['ID_POKEMON'];
            $pokemons[$pokemonId] = $this->buildDomainObject($row);
        }
        return $pokemons;
    }

    /**
     * Returns the list of all pokemons for a given type, sorted by name.
     *
     * 
     *
     * @return array The list of pokemon.
     */
    public function findAllByType($typeId) {
        $sql = "select * from pokemon where ID_TYPE=? ";
        $result = $this->getDb()->fetchAll($sql, array($typeId));

        // Convert query result to an array of domain objects
        $pokemons = array();
        foreach ($result as $row) {
            $pokemonId = $row['ID_POKEMON'];
            $pokemons[$pokemonId] = $this->buildDomainObject($row);
        }
        return $pokemons;
    }

    /**
     * Returns the pokemon matching a given id.
     *
     * @param integer $id The pokemon id.
     *
     * @return \GSB\Domain\Pokemon|throws an exception if no pokemon is found.
     */
    public function find($id) {
        $sql = "select * from pokemon where ID_POKEMON=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No pokemon found for id " . $id);
    }

    /**
     * Creates a pokemon instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \PokeStore\Domain\Pokemon
     */
    protected function buildDomainObject($row) {
        $typeId = $row['ID_Type'];
        $type = $this->TypeDAO->find($typeId);

        $pokemon = new Pokemon();
        $pokemon->setId($row['ID_POKEMON']);
        $pokemon->setNamepokemon($row['name_pokemon']);
        $pokemon->setNameManufacturer($row['Name_Manufacturer']);
        $pokemon->setImage($row['IMG_POK']);
        $pokemon->setPrix($row['PRICE_POK']);
        $pokemon->setDescription($row['DESCRIPTION']);
        $pokemon->setType($type);
        return $pokemon;
    }
}
