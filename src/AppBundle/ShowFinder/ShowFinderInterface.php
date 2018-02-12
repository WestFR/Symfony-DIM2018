<?php

namespace AppBundle\ShowFinder;

interface ShowFinderInterface {

	/**
	 * Returns a array of shows according to the query passed.
	 * @param String $query
	 * @return Array $results
	 */
	public function findByName($query);

	/**
	 * Returns the name of the finders passed.
	 * @return String $name
	 */
	public function getName();
}