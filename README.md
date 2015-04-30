[![Build Status](https://travis-ci.org/tanzsport/esv-client-php.svg?branch=master)](https://travis-ci.org/tanzsport/esv-client-php)

# ESV-Client PHP #

## Installation ##

1. [Composer](https://getcomposer.org/) installieren falls noch nicht vorhanden:

		curl -s http://getcomposer.org/installer | php

2. Im Wurzelverzeichnis des eigenen Projektes eine neue Composer-Abhängigkeit installieren:

		composer require "tanzsport/esv-api-client" "dev-master"

3. Die Einbindung in das eigene Projekt erfolgt über den Composer-Autoloader:

		require_once 'vendor/autoload.php';

## Parameter ##

Für die tatsächliche Verwendung des Clients sind erforderlich:

* API-Token
* Benutzername
* Passwort

## Initialisierung ##

Zunächst muss ein Endpunkt definiert werden:

	$endpunkt = new \Tanzsport\ESV\API\Endpunkt("http://...");

Der Endpunkt wird mit der Basis-URL für alle Zugriffe initialisiert, die frei eingegeben werden kann. Alternativ können die Klassenkonstanten Q1, Q2, PROD für die unterschiedlichen Umgebungen verwendet werden. 

**Tanzsport\ESV\API\Client** ist die zentrale Klasse, über die der Client initialisiert wird:

	$client = new \Tanzsport\ESV\API\Client($endpunkt, 'MyUserAgent', 'token', 'user', 'password');
	
Der User-Agent kann frei gewählt werden, sollte aber sprechend sein.

## Operationen ##

### Abfrage von Einzelstartern ###

Einzelstarter können anhand Ihrer DTV-ID oder WDSF-MIN abgefragt werden:

	$client->getStarterResource()->findeStarterNachDtvOderWdsfId('Einzel', 10000456);

## Testsuite ausführen ##

Um die PHPUnit-Tests ausführen zu können, ist eine lokale Konfigurationdatei **.env.json** mit folgendem Inhalt erforderlich:

	{
		"ESV_ENDPOINT": "Basis-URL",
		"ESV_TOKEN": "Token",
		"ESV_USER": "Benutzername",
		"ESV_PASSWORD": "Passwort",
		"ESV_VERIFY_SSL": 1
	}	
	

	




