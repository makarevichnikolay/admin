<?php

class RMorphy extends CComponent
{
	public $opts = array(
		// storage type, follow types supported
		// 'file' (PHPMORPHY_STORAGE_FILE) - use file operations(fread, fseek) for dictionary access, this is very slow...
		// 'mem' (PHPMORPHY_STORAGE_SHM) - load dictionary in shared memory(using shmop php extension), this is preferred mode
		// 'shm' (PHPMORPHY_STORAGE_MEM) - load dict to memory each time when phpMorphy intialized, this useful when shmop ext. not activated. Speed same as for PHPMORPHY_STORAGE_SHM type
		'storage' => 'file',
		// Enable prediction by suffix
		'predict_by_suffix' => true, 
		// Enable prediction by prefix
		'predict_by_db' => true,
		// TODO: comment this
		'graminfo_as_text' => true,
	);
	
	public $lang = 'uk_UA';
	
	protected $_morphy;
	
	public function init()
	{
		require_once(dirname(__FILE__).'/vendor/src/common.php');
		$dicts = dirname(__FILE__) . '/vendor/dicts';
		$this->_morphy = new phpMorphy($dicts, $this->lang, $this->opts);
	}
	
	public function __call($method, $attributs)
	{
		if(method_exists($this->_morphy, $method))
		{
			return call_user_func_array(array($this->_morphy, $method), $attributs);
		}
		throw new CException(Yii::t('RMorphy', 'Unable to call RMorphy "{method}" method.'), array('{method}'=>$method));
	}
}