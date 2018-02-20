<?php

namespace AppBundle\Security\Authorization;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;


class ShowVoter extends Voter {

	public function voteOnAttribute($attribute, $subject, TokenInterface $token) {

		$user = $token->getUSer();
		$show = $subject;

		// Si l'utilisateur est l'auteur du show, il peut faire quelque chose
		if($show->getAuthor() === $user) {
			return true;
		}

		// Sinon l'utilisateur n'a pas  le droit
		return false;
	}

	public function supports($attribute, $subject) {

		if($subject instanceof Show) {
			return true;
		}

		return false;
	}

}