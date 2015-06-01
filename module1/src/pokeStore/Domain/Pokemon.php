<?php

namespace PokeStore\Domain;

class Pokemon {

    private $id;
    private $Type;
    private $namepokemon;
    private $nameManufacturer;
    private $image;
    private $prix;
    private $description;

    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->Type;
    }

    public function getNamepokemon() {
        return $this->namepokemon;
    }

    public function getNameManufacturer() {
        return $this->nameManufacturer;
    }

    public function getImage() {
        return $this->image;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setType($Type) {
        $this->Type = $Type;
    }

    public function setNamepokemon($namepokemon) {
        $this->namepokemon = $namepokemon;
    }

    public function setNameManufacturer($nameManufacturer) {
        $this->nameManufacturer = $nameManufacturer;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

}
