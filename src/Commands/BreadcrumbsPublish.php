<?php

/**
 * --------------------------------------------------------------------
 * CodeIgniter 4 - CI4 Breadcrumbs
 * --------------------------------------------------------------------
 *
 * This is a library for generating breadcrumb trails in CodeIgniter 4. It 
 * supports both Bootstrap and Halfmoon frameworks, and allows users to 
 * either add breadcrumbs manually or generate them automatically based on 
 * the current URL.
 *
 * @package    CI4 Breadcrumbs
 * @author     GeekLabs - Lee Skelding 
 * @license    https://opensource.org/licenses/MIT	MIT License
 * @link       https://github.com/GeekLabsUK/CI4-Breadcrumbs
 * @since      Version 2.0
 */

namespace Geeklabs\Breadcrumbs\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Autoload;
use Exception;

/**
 * Class BreadcrumbsPublish
 *
 * @package Geeklabs\Breadcrumbs\Commands
 *
 * This command publishes the Breadcrumbs file to the Modules directory of
 * the current application.
 */
class BreadcrumbsPublish extends BaseCommand
{
    /**
     * The name of the command group.
     *
     * @var string
     */
    protected $group = 'Breadcrumbs';

    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'breadcrumbs:publish'; // php spark breadcrumbs:publish

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Publish Breadcrumb components into the current application.';

    /**
     * The path to the Geeklabs\Breadcrumbs\src directory.
     *
     * @var string
     */
    protected $sourcePath;

    /**
     * Copies the breadcrumb file to the Modules directory of the current application.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->determineSourcePath();
        $this->publishCoreFile();
        $this->publishConfigFile();
        CLI::write('Breadcrumb file was successfully generated.', 'green');
    }

    //--------------------------------------------------------------------
    /**
     * Determines the current source path from which all other files are located.
     */
    protected function determineSourcePath()
    {
        $this->sourcePath = realpath(__DIR__ . '/../');
        if ($this->sourcePath === '/' || empty($this->sourcePath)) {
            CLI::error('Unable to determine the correct source directory. Bailing.');
            exit();
        }
    }

    //--------------------------------------------------------------------
    /**
     * Publish Breadcrumbs file.
     */
    protected function publishCoreFile()
    {
        $path    = "{$this->sourcePath}/Core/Breadcrumbs.php";
        $content = file_get_contents($path);
        $content = str_replace('namespace Geeklabs\Breadcrumbs\Core', 'namespace App\Modules\Breadcrumbs', $content);
        $content = str_replace('use Geeklabs\Breadcrumbs\Config\Config', 'use App\Modules\Breadcrumbs\Config\Config', $content);
        $this->writeFile('Modules/Breadcrumbs/Breadcrumbs.php', $content);
    }

    //--------------------------------------------------------------------
    /**
     * Publish Breadcrumbs Config file.
     */
    protected function publishConfigFile()
    {
        $path    = "{$this->sourcePath}/Config/Config.php";
        $content = file_get_contents($path);
        $content = str_replace('namespace Geeklabs\Breadcrumbs\Config', 'namespace App\Modules\Breadcrumbs\Config', $content);
        $framework = CLI::promptByKey('What css framework are you using?:', ['Bootstrap', 'Halfmoon',]);
        if ($framework == '0') {
            $framework = 'bootstrap';
        } elseif ($framework == '1') {
            $framework = 'halfmoon';
        } else {
            CLI::error('Invalid option selected. Bailing.');
            exit();
        }
        $content = str_replace('default', $framework, $content);
        $this->writeFile('Modules/Breadcrumbs/Config/Config.php', $content);
    }

    //--------------------------------------------------------------------
    /**
     * Write a file to the specified path, catching any exceptions and showing a nicely formatted error.
     *
     * @param string $path The path to the file to write.
     * @param string $content The content to write to the file.
     *
     * @throws Exception If the file cannot be written.
     */
    protected function writeFile(string $path, string $content)
    {
        $config    = new Autoload();
        $appPath   = $config->psr4[APP_NAMESPACE];
        $directory = dirname($appPath . $path);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        if (file_exists($appPath . $path) && CLI::prompt('file already exists, do you want to replace it?', ['y', 'n']) === 'n') {
            CLI::error('Cancelled');
            exit();
        }

        try {
            write_file($appPath . $path, $content);
        } catch (Exception $e) {
            $this->showError($e);
            exit();
        }
        $path = str_replace($appPath, '', $path);
        CLI::write(CLI::color('Created: ', 'yellow') . $path);
    }
    //--------------------------------------------------------------------


}
