<?php

namespace App\Manager;

class PersonneManager extends Manager
{
	/*
	 * Affiche un rendu html
	 */
	public function Liste($request, $response) // La liste des personnes
	{
		$personnes = $this->db->select("personne",
			[
				"id",
				"first_name",
				"last_name",
				"sexe",
				"age"
			]
		); // Des objets Personne

		$response->render($response, 't_personne', array("personnes"=>$personnes));
	}

	public function Nouveau($request, $response) // Affiche un formulaire vide
	{
		$response->render($response, 'f_personne', array("action"=>"Créer"));
	}

	public function Save($request, $response) // Action INSERT
	{
		$data['first_name'] = $request->getParam('prenom');
		$data['last_name'] = $request->getParam('nom');
		$data['sexe'] = $request->getParam('sexe');
		$data['age'] = intval($request->getParam('age'));
		//
		$this->db->insert("personne", $data);
		// Redirection vers la liste des personnes
		$response->withRedirect('personne.liste');
	}

	public function Edition($request, $response) // Affiche le formulaire contenant les valeurs
	{
		$personne = $this->db->select("personne", 
			"*",
			[
				"AND" => [
					"id" => $request->getParam('id')
				]
			]
		);
		$response->render($response, 'f_personne', array("personne"=>$personne[0], "action"=>"Modifier"));
	}

	public function Modifier($request, $response) // Action UPDATE
	{
		$data['first_name'] = $request->getParam('prenom');
		$data['last_name'] = $request->getParam('nom');
		$data['sexe'] = $request->getParam('sexe');
		$data['age'] = intval($request->getParam('age'));

		//
		$this->db->update("personne", $data, ["AND" => ["id"=>$request->getParam('id')] ]);
		// Redirection vers la liste des personnes
		$response->withRedirect('personne.liste');
	}

	public function Supprimer($request, $response) // Supprime une personne connaissant son ID
	{
		//
		$this->db->delete("personne", ["AND" => ["id"=>$request->getParam('id')]]);
		// Redirection vers la liste des personnes
		$response->withRedirect('personne.liste');
	}
}

