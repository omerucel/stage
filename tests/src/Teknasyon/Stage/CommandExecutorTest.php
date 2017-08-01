<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;

class CommandExecutorTest extends TestCase
{
    public function testExecute()
    {
        $executor = new CommandExecutor();
        $process = $executor->execute(['php', '-v']);
        $this->assertEquals(0, $process->getExitCode());
    }
}
