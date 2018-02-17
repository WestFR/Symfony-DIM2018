<?php

namespace AppBundle\ShowFinder;

use GuzzleHttp\Client;

class OMDBFinder implements ShowFinderInterface {

	private $client;

	public function __construct(Client $client) {
		$this->client = $client;
	}

	public function findByName($query) {
		$result = $this->client->get('/?apikey=b99f30d1&type=series&t='. '%' . $query . '%');
        return json_decode($result->getBody());
	}

	public function getName() {
		return 'OMDB_API';
	}
}