<?php

namespace XMI;

class Base{

	private $id;
	private $libelle;

	public function __construct(string $id, string $libelle)
	{
	   	$this->setId($id);
	    $this->setLibelle($libelle);
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setLibelle($libelle) {
		$this->libelle = $libelle;
	}

	public function getLibelle() {
		return $this->libelle;
	}

	public function affiche() {
		echo($this->libelle);
	}

}