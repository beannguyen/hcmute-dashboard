<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'App\User',
		'secret' => '',
	],

	'google' => [
		'client_id' => '997167985443-d2casj66d1u8gnsfn2pl6duf95p1thid.apps.googleusercontent.com',
		'client_secret' => 'kpABOaATZB1sk9UmZG8afZzU',
		'redirect' => 'http://dashboard.baigiai.vn/oauth/callback',
	]

];
