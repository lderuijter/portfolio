<?php

namespace Core;

// trait om singleton pattern te kunnen hergebruiken
trait SingletonTrait
{
    private static ?self $instance = null;

    // functie om een enkele instantie te maken via singleton pattern
    final public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // opnieuw aanmaken en clone mag niet worden uitgevoerd
    final private function __construct(){}
    private function __clone(){}
}