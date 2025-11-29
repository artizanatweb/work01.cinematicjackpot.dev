<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class ConsoleSeeder extends Seeder
{
    public function __construct(protected readonly ConsoleOutput $output)
    {
        $formatter = $this->output->getFormatter();
        $formatter->setStyle('success', new OutputFormatterStyle('black', 'green'));
        $formatter->setStyle('error', new OutputFormatterStyle('black', 'red'));
        $formatter->setStyle('update', new OutputFormatterStyle('black', 'blue'));
    }

    /**
     * Run the database seeds.
     */
    abstract public function run(): void;

    protected function success(string $message, bool $newLineWrap = true): void
    {
        if ($newLineWrap) {
            $this->output->write('', true);
        }
        $this->output->write('  ');
        $this->output->write('<success> SUCCESS </success>');
        $this->output->write(' ');
        $this->output->writeln($message);
        if ($newLineWrap) {
            $this->output->write('', true);
        }
    }

    protected function error(string $message): void
    {
        $this->output->write('', true);
        $this->output->write('  ');
        $this->output->write('<error> ERROR </error>');
        $this->output->write(' ');
        $this->output->writeln($message);
        $this->output->write('', true);
    }

    protected function info(string $message, bool $newLineWrap = true): void
    {
        if ($newLineWrap) {
            $this->output->write('', true);
        }
        $this->output->write('  ');
        $this->output->write('<update> INFO </update>');
        $this->output->write(' ');
        $this->output->writeln($message);
        if ($newLineWrap) {
            $this->output->write('', true);
        }
    }

    protected function newLine(): void
    {
        $this->output->write('', true);
    }
}