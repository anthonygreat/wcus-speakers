<?php

namespace OpenCFP\Tests\Domain\Services;

use OpenCFP\Domain\Services\ResetEmailer;

class EmailerTest extends \PHPUnit_Framework_TestCase
{
    private $mailer;
    private $template;
    private $config_email;
    private $config_title;

    private $user_id;
    private $user_email;
    private $reset_code;

    public function setUp()
    {
        $this->mailer = \Mockery::mock('mailer')->shouldReceive('send')->once()
            ->with(\Mockery::on($this->validateEmail()))->getMock();

        $this->template = \Mockery::mock('template')->shouldIgnoreMissing();
        $this->config_email = 'admin@example.com';
        $this->config_title = 'Reset';

        $this->user_email = 'user@example.com';
        $this->user_id = 123;
        $this->reset_code = '987abc';

        $this->mailer = new ResetEmailer($this->mailer, $this->template, $this->config_email, $this->config_title);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /** @test */
    public function it_sends_the_expected_email()
    {
        $this->mailer->send($this->user_id, $this->user_email, $this->reset_code);
    }

    private function validateEmail()
    {
        return function ($message) {
            return $message->getTo() === array($this->user_email => null);
        };
    }
}
