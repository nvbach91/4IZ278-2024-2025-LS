<?php

function calculateAge($birthDate)
{
	$birth = new DateTime($birthDate);
	$today = new DateTime('today');
	$age = $birth->diff($today)->y;
	return $age;
}
