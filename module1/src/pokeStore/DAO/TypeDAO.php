<?php

namespace PokeStore\DAO;

use PokeStore\Domain\Type;


class TypeDAO extends DAO
{
    /**
     * Returns the list of all type , sorted by ID .
     *
     * @return array The list of all types.
     */
    public function findAll() {
        $sql = "select * from Type order by LIB_TYPE";
        $result = $this->getDb()->fetchAll($sql);
        
        // Converts query result to an array of domain objects
        $types = array();
        foreach ($result as $row) {
            $typeID = $row['ID_TYPE'];
            $types[$typeID] = $this->buildDomainObject($row);
        }
        return $types;
    }

    /**
     * Returns the type matching the given id.
     *
     * @param integer $id The type id.
     *
     * @return \PokeStore\Domain\type |throws an exception if no type is found.
     */
    public function find($id) {
        $sql = "select * from TYPE where ID_TYPE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No TYPE found for id " . $id);
    }

    /**
     * Creates a type instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \GSB\Domain\type
     */
    protected function buildDomainObject($row) {
        $type = new Type();
        $type->setId($row['ID_TYPE']);
        $type->setLabel($row['LIB_TYPE']);
        return $type;
    }
}