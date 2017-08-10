<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class CommandExecutorTest extends TestCase
{
    public function testExecute()
    {
        $executor = new CommandExecutor();
        $process = $executor->execute(['php', '-v']);
        $this->assertEquals(0, $process->getExitCode());
    }

    public function testListenOutput()
    {
        $executor = new CommandExecutor();
        $executor->execute(['php', '-v'], function ($type, $buffer) {
            $this->assertEquals(Process::OUT, $type);
            $this->assertEquals('PHP 7.', substr($buffer, 0, 6));
        });
    }

    public function testListenError()
    {
        $executor = new CommandExecutor();
        $executor->execute(['phpvv', '-v'], function ($type, $buffer) {
            $this->assertEquals(Process::ERR, $type);
            $this->assertEquals('sh: phpvv: command not found' . PHP_EOL, $buffer);
        });
    }
}
