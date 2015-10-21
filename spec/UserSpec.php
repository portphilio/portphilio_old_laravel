<?php

namespace spec\Portphilio;

use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior {

	function let() {
		$this->beConstructedWith([
			'first_name' => 'John',
			'last_name' => 'Smith',
			'username' => 'jsmith',
			'email' => 'john.smith@gmail.com',
			'password' => 'I am number 1!',
		]);
	}

	function it_is_initializable() {
		$this->shouldHaveType('Portphilio\User');
	}

	function it_requires_a_first_name() {
		$this->valid()->shouldBeTrue();
	}
}
