<?php

/*
 * Phake - Mocking Framework
 * 
 * Copyright (c) 2010, Mike Lively <mike.lively@sellingsource.com>
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 
 *  *  Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 * 
 *  *  Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 * 
 *  *  Neither the name of Mike Lively nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * @category   Testing
 * @package    Phake
 * @author     Mike Lively <m@digitalsandwich.com>
 * @copyright  2010 Mike Lively <m@digitalsandwich.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.digitalsandwich.com/
 */

class Phake_MockReaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Phake_MockReader
     */
    private $reader;

    /**
     * @var Phake_IMock
     */
    private $mock;

    /**
     * @Mock
     * @var Phake_Mock_Info
     */
    private $info;

    public function setUp()
    {
        Phake::initAnnotations($this);
        $this->reader = new Phake_MockReader();
        $this->mock   = $this->getMock('Phake_IMock');
        $this->mock->__PHAKE_info = $this->info;
    }

    public function testGetCallRecorder()
    {

        $recorder = Phake::mock('Phake_CallRecorder_Recorder');
        Phake::when($this->info)->getCallRecorder()->thenReturn($recorder);

        $this->assertSame($recorder, $this->reader->getCallRecorder($this->mock));
    }

    public function testGetName()
    {
        $this->mock->__PHAKE_name = 'PhakeMock';
        $this->assertSame($this->mock->__PHAKE_name, $this->reader->getName($this->mock));
    }

    public function testGetStubMapper()
    {
        $mapper = Phake::mock('Phake_Stubber_StubMapper');
        Phake::when($this->info)->getStubMapper()->thenReturn($mapper);

        $this->assertSame($mapper, $this->reader->getStubMapper($this->mock));
    }

    public function testGetDefaultAnswer()
    {
        $answer = Phake::mock('Phake_Stubber_IAnswer');
        Phake::when($this->info)->getDefaultAnswer()->thenReturn($answer);

        $this->assertSame($answer, $this->reader->getDefaultAnswer($this->mock));
    }

    public function testIsObjectFrozen()
    {
        Phake::when($this->info)->isObjectFrozen()->thenReturn(true);
        $this->assertTrue($this->reader->isObjectFrozen($this->mock));
    }

    public function testSetIsObjectFrozen()
    {
        $this->reader->setIsObjectFrozen($this->mock, true);
        Phake::verify($this->info)->freezeObject();
    }

    public function testSetObjectThawed()
    {
        $this->reader->setIsObjectFrozen($this->mock, false);
        Phake::verify($this->info)->thawObject();
    }

}

