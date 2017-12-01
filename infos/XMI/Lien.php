<?php

namespace XMI;

class Lien extends Base{

	private $source;
	private $cible;

	public function __construct(string $id, string $libelle, Base $source, Base $cible)
	{
	   	parent::__construct($id, $libelle);
	    $this->setSource($source);
	    $this->setCible($cible);
	}

	public function setSource($source) {
		$this->source = $source;
	}

	public function getSource() {
		return $this->source;
	}

	public function setCible($cible) {
		$this->cible = $cible;
	}

	public function getCible() {
		return $this->cible;
	}

	public function affiche() {
		echo($this->source->getLibelle() . ' -----' . $this->getLibelle() . '-----> ' . $this->getCible()->getLibelle());
	}

}