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
		$this->_id = $id;
	}

	public function getId() {
		return $this->_id;
	}

	public function setLibelle($libelle) {
		$this->_libelle = $libelle;
	}

	public function getLibelle() {
		return $this->_libelle;
	}

	public function affiche() {
		echo($this->_libelle);
	}

}