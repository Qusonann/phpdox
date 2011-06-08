<?php
/**
 * Copyright (c) 2010-2011 Arne Blankerts <arne@blankerts.de>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright notice,
 *     this list of conditions and the following disclaimer in the documentation
 *     and/or other materials provided with the distribution.
 *
 *   * Neither the name of Arne Blankerts nor the names of contributors
 *     may be used to endorse or promote products derived from this software
 *     without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT  * NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER ORCONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    phpDox
 * @subpackage unitTests
 * @author     Bastian Feder <phpdox@bastian-feder.de>
 * @copyright  Arne Blankerts <arne@blankerts.de>, All rights reserved.
 * @license    BSD License
 */

namespace TheSeer\phpDox\Tests\Unit\DocBlock {

    use TheSeer\phpDox\DocBlock\GenericElement;

    class GenericElementTest extends \TheSeer\phpDox\Tests\phpDox_TestCase {

        /**
         * @covers TheSeer\phpDox\DocBlock\GenericElement::getAnnotationName
         * @covers TheSeer\phpDox\DocBlock\GenericElement::__construct
         */
        public function testGetAnnotationname() {
            $element = new GenericElement('Tux');
            $this->assertEquals('Tux', $element->getAnnotationName());
        }

        /**
         * @covers TheSeer\phpDox\DocBlock\GenericElement::getBody
         */
        public function testGetBody() {
            $element = new GenericElement('Tux');
            $this->assertNull($element->getBody());
        }

        /**
         * @covers TheSeer\phpDox\DocBlock\GenericElement::setBody
         */
        public function testSetBody() {
            $element = new GenericElement('Tux');
            $element->setBody('Linus');
            $this->assertAttributeEquals('Linus', 'body', $element);
        }

        /**
         * @covers TheSeer\phpDox\DocBlock\GenericElement::__call
         */
        public function testMagicCall() {
            $element = new GenericElement('Tux');
            $element->setGnu('Puffy');
            $this->assertAttributeContains('Puffy', 'attributes', $element);
        }

        /**
         * @expectedException TheSeer\phpDox\DocBlock\GenericElementException
         * @covers TheSeer\phpDox\DocBlock\GenericElement::__call
         */
        public function testMagicCallExpectingGenericElementException() {
            $element = new GenericElement('Tux');
            $element->isGnu('Puffy');
        }

        /**
         * @covers TheSeer\phpDox\DocBlock\GenericElement::asDom
         */
        public function testAsDomNoRegisteredElments() {

            $node = new \stdClass;

            $fDomDocument = $this->getFDomDocumentFixture(array('createElementNS'));
            $fDomDocument
                ->expects($this->once())
                ->method('createElementNS')
                ->will($this->returnValue($node));

            $docBlock = new GenericElement('Tux');
            $this->assertEquals(new \stdClass, $docBlock->asDom($fDomDocument));

        }
    }
}