<?php

namespace AppBundle\Security\Authorization;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use AppBundle\Entity\User;

class UserVoter extends Voter {

	const ROLE_ADMIN = 'ROME_ADMIN';

	public function voteOnAttribute($attribute, $subject, TokenInterface $token) {

		$user = $token->getUser();

		if(!$user instanceof User) {
			return false;
		}

		if('ROLE_ADMIN' === $attribute && in_array(self::ROLE_ADMIN, $user->getRoles())) {
			return true;
		}

		// Sinon l'utilisateur n'a pas le droit
		return false;
	}

	public function supports($attribute, $subject) {

		if($attribute != self::ROLE_ADMIN) {
			return false;
		}

		return true;
	}

}