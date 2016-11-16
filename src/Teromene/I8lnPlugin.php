<?php
namespace Teromene;

class I8lnPlugin extends \Rain\Tpl\Plugin{

    protected $hooks = array('beforeParse');

	protected static $regex = '/{lang=(["\'].*["\'])}/m';
	protected static $i8lnFunction = '_';

    public function beforeParse(\ArrayAccess $context){

		$context->code = preg_replace(self::$regex, self::getReplacement(), $context->code);

    }

	public static function setI8lnFunction($functionName) {

		self::$i8lnFunction = $functionName;

	}

	public static function getReplacement() {

		return '<?php echo ' . self::$i8lnFunction . '($1); ?>';

	}

}
