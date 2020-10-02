<?php

namespace App\Core;

class NotFound
{
	public function __404Erreur__($request, $response)
	{
		echo "Page non trouvé : Erreur 404";
	}
}