<?php

namespace Test\AppBundle\Security\Authorization;

use AppBundle\Entity\Show;
use AppBundle\Entity\User;
use AppBundle\Security\Authorization\ShowVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

class ShowVoterTest extends TestCase {

	public function testUserHasRight()
    {
    	$showVoter = new ShowVoter();
    	$user = new User();
    	$show = new Show();
    	$show->setAuthor($user);
    	$token = $this->createMock(PostAuthenticationGuardToken::class);
    	$token->method('getUser')->willReturn($user);
    	$result = $showVoter->voteOnAttribute('', $show, $token);
    	$this->assertSame(true, $result);
    }
    public function testUserHasNoRight()
    {
    	$showVoter = new ShowVoter();
    	$user = new User();
    	$anotherUser = new User();
    	$show = new Show();
    	$show->setAuthor($user);
    	$token = $this->createMock(PostAuthenticationGuardToken::class);
    	$token
    	    ->expects($this->once())
    	    ->method('getUser')
    	    ->willReturn($anotherUser)
    	;
    	$result = $showVoter->voteOnAttribute('', $show, $token);
    	$this->assertSame(false, $result);
    }
}