<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Environnement;
use App\Entity\Visite;
use PHPUnit\Framework\TestCase;

/**
 * Description of VisiteTest
 *
 * @author akhal
 */
class VisiteTest extends TestCase {
    
    public function testGetDatecreationString(){
        $visite = new Visite();
        $visite->setDatecreation(new \DateTime("2024-04-24"));
        $this->assertEquals("24/04/2024", $visite->getDatecreationString());
    }
    
    public function testAddEnvironnement(){
        $visite = new Visite();
        $environnement = new Environnement();
        $environnement->setNom("Montagne");
        $visite->addEnvironnement($environnement);
        $visite->addEnvironnement($environnement);
        $this->assertCount(1, $visite->getEnvironnements(), "le Test : Ajouter un environnment déja présent devraît échouer");
    }
}
