<?php

namespace AppBundle\ShowFinder;

use AppBundle\Entity\Category;
use AppBundle\Entity\Show;
use GuzzleHttp\Client;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class OMDBFinder implements ShowFinderInterface {

	private $client;
	private $tokenStorage;
	private $apiKey;

	public function __construct(Client $client, TokenStorage $tokenStorage, $apiKey) {
		$this->client = $client;
		$this->tokenStorage = $tokenStorage;
		$this->apiKey = $apiKey;
	}

	/**
     * @param String $query
     * @return Show|array|null
     */
	public function findByName($query) {	
		$result = $this->client->get('/?apikey='.$this->apiKey.'&type=series&t="'.$query.'"');
		$json = json_decode($result->getBody(), true);

		if ($json['Response'] == 'False' && $json['Error'] == 'Series not found!') {
			return [];
		}
		
		//dump(\GuzzleHttp\json_decode($result->getBody(), true)); die;
		return $this->convertToShow($json);
	}

	/**
	 * Create a private function that transform a OMDB JSON into a Show and Category
	 *
	 * @param String $json
	 *
	 * Show[] $shows
	 */ 
	private function convertToShow($json)
	{
		$category = new Category();
		$category->setName($json['Genre']);

		$shows = [];
		$show = new Show();
		
		$show->setName($json['Title']);
		$show->setAbstract($json['Plot']);
		$show->setDatasource(Show::DATA_SOURCE_OMDB);
		$show->setCountry($json['Country']);
		$show->setAuthor($this->tokenStorage->getToken()->getUser());
		$show->setRealisator($json['Writer']);
		$show->setReleaseDate(new \DateTime($json['Released']));
		$show->setMainPicture($json['Poster']);
		$show->setCategory($category);

		$shows[] = $show;

		return $shows;
	}

	public function getName() {
		return 'OMDB_API';
	}
}