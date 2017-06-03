<?php

namespace BlueBlazeAssociates\Technology\PHP\PHPOnSiteGround\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Webmozart\PathUtil\Path;

/**
 *
 * @author Ed Gifford
 *
 */
class Install extends Command {

  /**
   *
   * @var string
   */
  const ARG__ERROR_LOG_DIR = 'error_log_dir';

  /**
   *
   * @var string
   */
  const ARG__INSTALL_DIR = 'install_dir';

  /**
   *
   * @var string
   */
  private $error_log_dir = null;

  /**
   *
   * @var string
   */
  private $install_dir = null;

  /**
   *
   * {@inheritDoc}
   * @see \Symfony\Component\Console\Command\Command::configure()
   */
  protected function configure() {

    $this->setName('php:install');
    $this->setDescription('Installs helper scripts for several versions of PHP.');
    $this->setHelp('This command installs helper scripts for PHP 4.x, 5.0 to 5.6, 7.0, and 7.1.');
    $this->addOption(self::ARG__ERROR_LOG_DIR, null, InputOption::VALUE_REQUIRED, 'The directory where to store PHP\'s error_log.');
    $this->addOption(self::ARG__INSTALL_DIR,   null, InputOption::VALUE_REQUIRED, 'The directory where to create PHP executable scripts.');
  }

  /**
   *
   * {@inheritDoc}
   * @see \Symfony\Component\Console\Command\Command::execute()
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    // Print info about what is about to happen.
    $output->writeln([
        '',
        $this->getHelp(),
        ''
    ]);

    // Process error_log_dir argument.
    $this->error_log_dir = $this->processOptionErrorLogDir($input, $output);

    // Process error_log_dir argument.
    $this->install_dir = $this->processOptionInstallDir($input, $output);

    // Print info about what is about to happen.
    $output->writeln([
        '<info>The PHP error_log will be written into the directory: <comment>' . $this->error_log_dir . '</comment></info>',
        '<info>PHP executables will be created in this directory: <comment>' . $this->install_dir . '</comment></info>',
        ''
    ]);

    // Confirm this with the user.
    $helper = $this->getHelper('question');
    if (true === $helper->ask($input, $output, new ConfirmationQuestion('<info>Continue with this action? <comment>(y/n)</comment>: </info>', false))) {
      $output->writeln('We\'re gonna do it.');
    } else {
      $output->writeln('Bailing!!!');
    }
  }

  /**
   * Process error_log_dir argument.
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   *
   * @return string
   */
  private function processOptionErrorLogDir($input, $output) {

    // Set an initial local value.
    $arg_value = null;

    // Try to grab the value off of the command line.
    $arg_value = $input->getOption(self::ARG__ERROR_LOG_DIR);

    // If not set or valid, ask for it.
    while (true === empty($arg_value)) {
      $default_value = Path::getHomeDirectory() . '/tmp';
      $helper        = $this->getHelper('question');
      $arg_value     = $helper->ask(
          $input,
          $output,
          new Question('In what directory would you like to store error_log files? [<comment>' . $default_value . '</comment>]: ', $default_value)
      );
    }

    return $arg_value;
  }

  /**
   * Process install_dir argument.
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   *
   * @return string
   */
  private function processOptionInstallDir($input, $output) {

    // Set an initial local value.
    $arg_value = null;

    // Try to grab the value off of the command line.
    $arg_value= $input->getOption(self::ARG__INSTALL_DIR);

    // If not set or valid, ask for it.
    while (true === empty($arg_value)) {
      $default_value = Path::getHomeDirectory() . '/bin';
      $helper        = $this->getHelper('question');
      $arg_value     = $helper->ask(
          $input,
          $output,
          new Question('In what directory should PHP executable scripts be installed? [<comment>' . $default_value . '</comment>]: ', $default_value)
      );
    }

    return $arg_value;
  }
}
