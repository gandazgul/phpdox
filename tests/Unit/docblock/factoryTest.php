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
 * @author     Bastian Feder <phpdox@bastina-feder.de>
 * @copyright  Arne Blankerts <arne@blankerts.de>, All rights reserved.
 * @license    BSD License
 */

namespace TheSeer\phpDox\Tests\Unit\DocBlock {

    use TheSeer\phpDox\Factory;

    class FactoryTest extends \PHPUnit_Framework_TestCase {

        /**
         * @covers TheSeer\phpDox\Factory::setXMLDir
         */
        public function testSetXMLDir() {
            $factory = new Factory();
            $factory->setXMLDir('/os/mascott/Tux');

            $this->assertAttributeEquals('/os/mascott/Tux', 'xmlDir', $factory);
        }

        /**
         * @covers TheSeer\phpDox\Factory::addFactory
         */
        public function testAddFactory() {
            $factory = new Factory();
            $factory->addFactory('Gnu', $factory);
            $actual = $this->readAttribute($factory, 'map');

            $this->assertInstanceOf('TheSeer\phpDox\Factory', $actual['Gnu']);
        }

        /**
         * @covers TheSeer\phpDox\Factory::addClass
         */
        public function testAddClass() {
            $factory = new Factory();
            $factory->addClass('Gnu', 'myClass');
            $actual = $this->readAttribute($factory, 'map');

            $this->assertEquals('myClass', $actual['Gnu']);
        }

        /**
         * @covers TheSeer\phpDox\Factory::getInstanceFor
         */
        public function testGetInstanceForClass() {
            $factory = new Factory();
            $factory->addClass('Gnu', 'stdClass');

            $this->assertInstanceOf('stdClass', $factory->getInstanceFor('Gnu'));
        }

        /**
         * @covers TheSeer\phpDox\Factory::getInstanceFor
         */
        public function testGetInstanceForFactory() {
            $factory = new Factory();
            $factory->addClass('stdClass', new Factory());

            $this->assertInstanceOf('stdClass', $factory->getInstanceFor('stdClass'));
        }

        /**
         * @covers TheSeer\phpDox\Factory::getInstanceFor
         */
        public function testGetInstanceForMethod() {
            $factory = new Factory();

            $this->assertInstanceOf('TheSeer\phpDox\ProgressLogger', $factory->getInstanceFor('Logger', 'silent'));
        }
    }
}