<?php
require_once 'PHPUnit/Autoload.php';
require "vendor/autoload.php";
require_once "src/I8lnPlugin.php";

use Rain\Tpl;

class I8lnPluginTest extends phpunit\framework\TestCase {

	public static $TPLBaseText = '<?php if(!class_exists(\'Rain\Tpl\')){exit;}?>';

	private static function getTemplateString($templateName) {

		$t = new Tpl;
		$t->draw($templateName, TRUE);

		$filename = glob('tests/cache/*.php')[0];
		$content = file_get_contents($filename);
		unlink($filename);

		return $content;

	}

	public static function setUpBeforeClass() {

		$config = array(
			"tpl_dir" => "tests/",
			"cache_dir" => "tests/cache/"
		);

		Tpl::configure($config);
		Tpl::registerPlugin( new Tpl\Plugin\I8lnPlugin() );

	}

	public function testDefaultFunctionSingleQuotes() {

		$expectedString = self::$TPLBaseText . "<?php echo _('Hello world !'); ?>\n\n";
		$this->assertEquals($expectedString, self::getTemplateString("testSingleQuotes"), 'The expected value for default function single quotes is wrong !'); 


	}

	public function testDefaultFunctionDoubleQuotes() {

		$expectedString = self::$TPLBaseText . "<?php echo _(\"Hello world !\"); ?>\n\n";
		$this->assertEquals($expectedString, self::getTemplateString("testDoubleQuotes"), 'The expected value for default function single quotes is wrong !'); 


	}

	public function testCustomFunctionSingleQuotes() {

		Tpl\Plugin\I8lnPlugin::setI8lnFunction("gettext");

		$expectedString = self::$TPLBaseText . "<?php echo gettext('Hello world !'); ?>\n\n";
		$this->assertEquals($expectedString, self::getTemplateString("testSingleQuotes"), 'The expected value for default function single quotes is wrong !'); 


	}

	public function testCustomFunctionDoubleQuotes() {

		Tpl\Plugin\I8lnPlugin::setI8lnFunction("gettext");

		$expectedString = self::$TPLBaseText . "<?php echo gettext(\"Hello world !\"); ?>\n\n";
		$this->assertEquals($expectedString, self::getTemplateString("testDoubleQuotes"), 'The expected value for default function single quotes is wrong !'); 


	}

}
?>
