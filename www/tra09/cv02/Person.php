<?php

class Person
{
	private $avatar;
	private $lastName;
	private $firstName;
	private $dateOfBirth;
	private $occupation;
	private $company;
	private $street;
	private $descriptiveNumber;
	private $referenceNumber;
	private $city;
	private $phone;
	private $email;
	private $website;
	private $lookingForJob;

	public function __construct(
		$avatar,
		$lastName,
		$firstName,
		$dateOfBirth,
		$occupation,
		$company,
		$street,
		$descriptiveNumber,
		$referenceNumber,
		$city,
		$phone,
		$email,
		$website,
		$lookingForJob
	) {
		$this->avatar = $avatar;
		$this->lastName = $lastName;
		$this->firstName = $firstName;
		$this->dateOfBirth = $dateOfBirth;
		$this->occupation = $occupation;
		$this->company = $company;
		$this->street = $street;
		$this->descriptiveNumber = $descriptiveNumber;
		$this->referenceNumber = $referenceNumber;
		$this->city = $city;
		$this->phone = $phone;
		$this->email = $email;
		$this->website = $website;
		$this->lookingForJob = $lookingForJob;
	}

	public function getAvatar()
	{
		return $this->avatar;
	}

	public function getFullName()
	{
		return $this->firstName . ' ' . $this->lastName;
	}

	public function getAge()
	{
		return calculateAge($this->dateOfBirth);
	}

	public function getOccupation()
	{
		return $this->occupation;
	}

	public function getCompany()
	{
		return $this->company;
	}

	public function getAddress()
	{
		return [
			'street' => $this->street,
			'descriptiveNumber' => $this->descriptiveNumber,
			'referenceNumber' => $this->referenceNumber,
			'city' => $this->city
		];
	}

	public function getContactInfo()
	{
		return [
			'phone' => $this->phone,
			'email' => $this->email,
			'website' => $this->website
		];
	}

	public function isLookingForJob()
	{
		return $this->lookingForJob;
	}
}
