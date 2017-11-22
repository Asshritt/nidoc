<?php

class Lien extends Base{

	private $_source;
	private $_cible;

	public function __construct(string $id, string $libelle, Base $source, Base $cible)
	{
	   	parent::__construct($id, $libelle);
	    $this->setSource($source);
	    $this->setCible($cible);
	}

	public function setSource($source) {
		$this->_source = $source;
	}

	public function setCible($cible) {
		$this->_cible = $cible;
	}

	public function affiche() {
		echo($this->_source->getLibelle() . ' -----' . $this->_libelle . '-----> ' . $this->_cible->getLibelle());
	}

}