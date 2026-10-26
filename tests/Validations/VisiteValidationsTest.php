<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Visite;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function Symfony\Component\Clock\now;

/**
 * Description of VisiteValidationsTest
 *
 * @author akhal
 */
class VisiteValidationsTest extends KernelTestCase {
    
    public function getVisite() : Visite{
        return (new Visite())
            ->setVille("New York")
            ->setPays("USA");
    }
    
    public function testValidNoteVisite() {
        
        $visite = $this->getVisite()->setNote(10);
        $this->assertErrors($visite, 0, "La valeur 10 ne devrait pas renvoyer d'erreur");
        $visite = $this->getVisite()->setNote(20);
        $this->assertErrors($visite, 0, "La valeur 20 ne devrait pas renvoyer d'erreur");
        $visite = $this->getVisite()->setNote(0);
        $this->assertErrors($visite, 0, "La valeur 0 ne devrait pas renvoyer d'erreur");
    }
    
    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message=""){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    
    public function testNonValidNoteVisite() {
        $visite = $this->getVisite()->setNote(21);
        $this->assertErrors($visite, 1, "La valeur 21 ne devrait pas renvoyer d'erreur" );
        $visite = $this->getVisite()->setNote(-1);
        $this->assertErrors($visite, 1, "La valeur -1 ne devrait pas renvoyer d'erreur" );
        $visite = $this->getVisite()->setNote(43);
        $this->assertErrors($visite, 1, "La valeur 43 ne devrait pas renvoyer d'erreur" );
        $visite = $this->getVisite()->setNote(-43);
        $this->assertErrors($visite, 1, "La valeur -43 ne devrait pas renvoyer d'erreur" );
    }
    
    public function testNonValidTempmaxVisite() {
        $visite = $this->getVisite()
                ->setTempmin(20)
                ->setTempmax(18);
        $this->assertErrors($visite, 1, "min=20, max=18 devrait échouer");
    }
    
    public function testNonValidTempVisite() {
        $visite = $this->getVisite()
                ->setTempmin(24)
                ->setTempmax(-2);
        $this->assertErrors($visite, 1, "min=24, max=-2 devrait échouer");
        
        $visite = $this->getVisite()
                ->setTempmin(16)
                ->setTempmax(16);
        $this->assertErrors($visite, 1, "min=16, max=16 devrait échouer");
    }

    public function testValidTempVisite() {
        $visite = $this->getVisite()
                ->setTempmin(-18)
                ->setTempmax(45);
        $this->assertErrors($visite, 0, "min=-18, max=45 ne devrait pas échouer");
        
        $visite = $this->getVisite()
                ->setTempmin(5)
                ->setTempmax(6);
        $this->assertErrors($visite, 0, "min=5, max=6 ne devrait pas échouer");
    }
    
    public function testValidDateVisite() {
        
        $visite = $this->getVisite()->setDatecreation(new \DateTime("now -1 year"));
        $this->assertErrors($visite, 0, "La date 01/01/2026 ne devrait pas échouer");
        $visite = $this->getVisite()->setDatecreation(new \DateTime("now"));
        $this->assertErrors($visite, 0, "La date du jour ne devrait pas échouer");
    }
    
    public function testNonValidDateVisite() {
        
        $visite = $this->getVisite()->setDatecreation(new \DateTime("now +1 year"));
        $this->assertErrors($visite, 1, "La date 31/12/2026 devrait échouer");
        $visite = $this->getVisite()->setDatecreation(new \DateTime("tomorrow"));
        $this->assertErrors($visite, 1, "La date du lendemain devrait échouer");
    }
}