<?php

namespace XMI;

class Activite extends Base{

	public function __construct(string $id, string $libelle)
	{
		parent::__construct($id, $libelle);
	}

}