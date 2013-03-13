<?php

Yii::import('common.ext.image.Image_Driver');

/**
 * Manipulate images using standard methods such as resize, crop, rotate, etc.
 * This class must be re-initialized for every image you wish to manipulate.
 *
 * $Id: Image.php 3809 2008-12-18 12:48:41Z OscarB $
 *
 * @package	Image
 * @author	 Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license	http://kohanaphp.com/license.html
 */
class Image {

	// Master Dimension
	const NONE = 1;
	const AUTO = 2;
	const HEIGHT = 3;
	const WIDTH = 4;
	// Flip Directions
	const HORIZONTAL = 5;
	const VERTICAL = 6;

	// Allowed image types
	public static $allowed_types = array
	(
		IMAGETYPE_GIF => 'gif',
		IMAGETYPE_JPEG => 'jpg',
		IMAGETYPE_PNG => 'png',
		IMAGETYPE_TIFF_II => 'tiff',
		IMAGETYPE_TIFF_MM => 'tiff',
	);

	// Driver instance
	/** @var Image_Driver */
	protected $driver;

	// Driver actions
	protected $actions = array();

	// Reference to the current image filename
	protected $image = '';
	
	const CORNER_LEFT_TOP = 1;
	const CORNER_RIGHT_TOP = 2;
	const CORNER_LEFT_BOTTOM = 3;
	const CORNER_RIGHT_BOTTOM = 4;
	const CORNER_CENTER = 5;

	/**
	 * Creates a new Image instance and returns it.
	 *
	 * @param   string $image  filename of image
	 * @param   array	$config non-default configurations
	 * @return  Image
	 */
	public static function factory($image, $config = NULL) {
		return new Image($image, $config);
	}

	/**
	 * Creates a new image editor instance.
	 *
	 * @throws  Kohana_Exception
	 * @param   string  $image filename of image
	 * @param   array	$config non-default configurations
	 * @return  Image
	 */
	public function __construct($image, $config = NULL) {
		static $check;

		// Make the check exactly once
		($check === NULL) and $check = function_exists('getimagesize');

		if ($check === FALSE)
			throw new CException('image getimagesize missing');

		// Check to make sure the image exists
		if (!is_file($image))
			throw new CException('image file not found');

		// Disable error reporting, to prevent PHP warnings
		$ER = error_reporting(0);

		// Fetch the image size and mime type
		$image_info = getimagesize($image);

		// Turn on error reporting again
		error_reporting($ER);

		// Make sure that the image is readable and valid
		if (!is_array($image_info) OR count($image_info) < 3)
			throw new CException('image file unreadable');

		// Check to make sure the image type is allowed
		if (!isset(Image::$allowed_types[$image_info[2]]))
			throw new CException('image type not allowed');

		// Image has been validated, load it
		$this->image = array
		(
			'file' => str_replace('\\', '/', realpath($image)),
			'width' => $image_info[0],
			'height' => $image_info[1],
			'type' => $image_info[2],
			'ext' => Image::$allowed_types[$image_info[2]],
			'mime' => $image_info['mime']
		);

		// Load configuration
		if ($config === null) {
			$this->config = array(
				'driver' => 'GD',
				'params' => array(),
			);
		}
		else {
			$this->config = $config;
		}

		// Set driver class name
		$driver = 'Image_' . ucfirst($this->config['driver']) . '_Driver';

		// Load the driver
		Yii::import("common.ext.image.drivers.$driver");

		// Initialize the driver
		$this->driver = new $driver($this->config['params']);

		// Validate the driver
		if (!($this->driver instanceof Image_Driver))
			throw new CException('image driver must be implement Image_Driver class');
	}
	
	public function watermark($watermarkFile, $offsetX=0, $offsetY=0, $corner = self::CORNER_RIGHT_BOTTOM)
    {
		$img = $this->loadImage($this->image['file']);
        //$this->checkLoaded();
        if ($wImg = $this->loadImage($watermarkFile))
        {
    		$posX = 0;
    		$posY = 0;
    		switch ($corner)
    		{
    		    case self::CORNER_LEFT_TOP:
    		        $posX = $offsetX;
    		        $posY = $offsetY;
    		        break;
    		    case self::CORNER_RIGHT_TOP:
    		        $posX = $this->width - $wImg['width'] - $offsetX;
    		        $posY = $offsetY;
    		        break;
    		    case self::CORNER_LEFT_BOTTOM:
    		        $posX = $offsetX;
    		        $posY = $this->height - $wImg['height'] - $offsetY;
    		        break;
    		    case self::CORNER_RIGHT_BOTTOM:
    		        $posX = $this->image['width'] - $wImg['width'] - $offsetX;
    		        $posY = $this->image['height'] - $wImg['height'] - $offsetY;
    		        break;
    		    case self::CORNER_CENTER:
    		        $posX = floor(($this->width - $wImg['width']) / 2);
    		        $posY = floor(($this->height - $wImg['height']) / 2);
    		        break;
    		    default:
    		        throw new Exception('Invalid $corner value');
    		}
    		imagecopy($img['image'], $wImg['image'], $posX, $posY, 0, 0, $wImg['width'], $wImg['height']);
			switch ($img['format'])
			{
				case 1:
					if (!imagegif($img['image'], $this->image['file']))
					{
						throw new Exception('Can\'t save gif file');
					}
					break;
				case 2:
					if (!imagejpeg($img['image'], $this->image['file'], 75))
					{
						throw new Exception('Can\'t save jpeg file');
					}
					break;
				case 3:
					if (!imagepng($img['image'], $this->image['file']))
					{
						throw new Exception('Can\'t save png file');
					}
					break;
				default:
					throw new Exception('Invalid image format for save');
			}
            imagedestroy($wImg['image']);
            return $this;
        }
        else
        {
        	return false;
        }
    }
	private function loadImage($file)
	{
        $result = array();
        if ($imageInfo = @getimagesize($file))
        {
            $result['width'] = $imageInfo[0];
            $result['height'] = $imageInfo[1];

            $result['mimeType'] = $imageInfo['mime'];

            switch ($result['format'] = $imageInfo[2])
            {
                case 1:
                    if ($result['image'] = imagecreatefromgif($file))
                    {
                        return $result;
                    }
                    else
                    {
                        throw new Exception('Invalid image gif format');
                    }
                    break;
                case 2:
                    if ($result['image'] = imagecreatefromjpeg($file))
                    {
                        return $result;
                    }
                    else
                    {
                        throw new Exception('Invalid image jpeg format');
                    }
                    break;
                case 3:
                    if ($result['image'] = imagecreatefrompng($file))
                    {
                        return $result;
                    }
                    else
                    {
                    	throw new Exception('Invalid image png format');
                    }
                    break;
          	    default:
  				    throw new Exception('Not supported image format');
      		}
  	    }
  	    else
  	    {
  	        throw new Exception('Invalid image file');
  	    }


	}

	/**
	 * Handles retrieval of pre-save image properties
	 *
	 * @param   string  $property name
	 * @return  mixed
	 */
	public function __get($property) {
		if (isset($this->image[$property])) {
			return $this->image[$property];
		}
		else
		{
			throw new CException('invalid property');
		}
	}

	/**
	 * Resize an image to a specific width and height. By default, Kohana will
	 * maintain the aspect ratio using the width as the master dimension. If you
	 * wish to use height as master dim, set $image->master_dim = Image::HEIGHT
	 * This method is chainable.
	 *
	 * @throws  Kohana_Exception
	 * @param   integer  $width
	 * @param   integer  $height
	 * @param   integer  $master one of: Image::NONE, Image::AUTO, Image::WIDTH, Image::HEIGHT
	 * @return  Image
	 */
	public function resize($width, $height, $master = NULL) {
		if (!$this->valid_size('width', $width))
			throw new CException('image invalid width');

		if (!$this->valid_size('height', $height))
			throw new CException('image invalid height');

		if (empty($width) AND empty($height))
			throw new CException('image invalid dimensions');

		if ($master === NULL) {
			// Maintain the aspect ratio by default
			$master = Image::AUTO;
		}
		elseif (!$this->valid_size('master', $master))
			throw new CException('image invalid master');

		$this->actions['resize'] = array
		(
			'width' => $width,
			'height' => $height,
			'master' => $master,
		);

		return $this;
	}

	/**
	 * Crop an image to a specific width and height. You may also set the top
	 * and left offset.
	 * This method is chainable.
	 *
	 * @throws  CException
	 * @param   integer  $width
	 * @param   integer  $height
	 * @param int|string $top offset, pixel value or one of: top, center, bottom
	 * @param int|string $left offset, pixel value or one of: left, center, right
	 * @return  Image
	 */
	public function crop($width, $height, $top = 'center', $left = 'center') {
		if (!$this->valid_size('width', $width))
			throw new CException('image invalid width', $width);

		if (!$this->valid_size('height', $height))
			throw new CException('image invalid height', $height);

		if (!$this->valid_size('top', $top))
			throw new CException('image invalid top', $top);

		if (!$this->valid_size('left', $left))
			throw new CException('image invalid left', $left);

		if (empty($width) AND empty($height))
			throw new CException('image invalid dimensions');

		$this->actions['crop'] = array
		(
			'width' => $width,
			'height' => $height,
			'top' => $top,
			'left' => $left,
		);

		return $this;
	}

	/**
	 * Allows rotation of an image by 180 degrees clockwise or counter clockwise.
	 *
	 * @param   integer  $degrees
	 * @return  Image
	 */
	public function rotate($degrees) {
		$degrees = (int)$degrees;

		if ($degrees > 180) {
			do
			{
				// Keep subtracting full circles until the degrees have normalized
				$degrees -= 360;
			}
			while ($degrees > 180);
		}

		if ($degrees < -180) {
			do
			{
				// Keep adding full circles until the degrees have normalized
				$degrees += 360;
			}
			while ($degrees < -180);
		}

		$this->actions['rotate'] = $degrees;

		return $this;
	}

	/**
	 * Flip an image horizontally or vertically.
	 *
	 * @throws  Kohana_Exception
	 * @param   integer  $direction
	 * @return  Image
	 */
	public function flip($direction) {
		if ($direction !== self::HORIZONTAL AND $direction !== self::VERTICAL)
			throw new CException('image invalid flip');

		$this->actions['flip'] = $direction;

		return $this;
	}

	/**
	 * Change the quality of an image.
	 *
	 * @param   integer $amount quality as a percentage
	 * @return  Image
	 */
	public function quality($amount) {
		$this->actions['quality'] = max(1, min($amount, 100));

		return $this;
	}

	/**
	 * Sharpen an image.
	 *
	 * @param   integer  $amount to sharpen, usually ~20 is ideal
	 * @return  Image
	 */
	public function sharpen($amount) {
		$this->actions['sharpen'] = max(1, min($amount, 100));

		return $this;
	}

	/**
	 * Save the image to a new image or overwrite this image.
	 *
	 * @throws  CException
	 * @param bool|string $new_image filename
	 * @param   integer  $chmod permissions for new image
	 * @param   boolean  $keep_actions keep or discard image process actions
	 * @return  boolean
	 */
	public function save($new_image = FALSE, $chmod = 0644, $keep_actions = FALSE) {
		// If no new image is defined, use the current image
		empty($new_image) and $new_image = $this->image['file'];

		// Separate the directory and filename
		$dir = pathinfo($new_image, PATHINFO_DIRNAME);
		$file = pathinfo($new_image, PATHINFO_BASENAME);

		// Normalize the path
		$dir = str_replace('\\', '/', realpath($dir)) . '/';

		if (!is_writable($dir))
			throw new CException('image directory unwritable');

		if ($status = $this->driver->process($this->image, $this->actions, $dir, $file)) {
			if ($chmod !== FALSE) {
				// Set permissions
				chmod($new_image, $chmod);
			}
		}

		// Reset actions. Subsequent save() or render() will not apply previous actions.
		if ($keep_actions === FALSE)
			$this->actions = array();

		return $status;
	}

	/**
	 * Output the image to the browser.
	 *
	 * @param   boolean $keep_actions keep or discard image process actions
	 * @return	boolean
	 */
	public function render($keep_actions = FALSE) {
		$new_image = $this->image['file'];

		// Separate the directory and filename 
		$dir = pathinfo($new_image, PATHINFO_DIRNAME);
		$file = pathinfo($new_image, PATHINFO_BASENAME);

		// Normalize the path 
		$dir = str_replace('\\', '/', realpath($dir)) . '/';

		// Process the image with the driver 
		$status = $this->driver->process($this->image, $this->actions, $dir, $file, $render = TRUE);

		// Reset actions. Subsequent save() or render() will not apply previous actions.
		if ($keep_actions === FALSE)
			$this->actions = array();

		return $status;
	}

	/**
	 * Sanitize a given value type.
	 *
	 * @param   string  $type type of property
	 * @param   mixed	$value property value
	 * @return  boolean
	 */
	protected function valid_size($type, & $value) {
		if (is_null($value))
			return TRUE;

		if (!is_scalar($value))
			return FALSE;

		switch ($type)
		{
			case 'width':
			case 'height':
				if (is_string($value) AND !ctype_digit($value)) {
					// Only numbers and percent signs
					if (!preg_match('/^[0-9]++%$/D', $value))
						return FALSE;
				}
				else
				{
					$value = (int)$value;
				}
				break;
			case 'top':
				if (is_string($value) AND !ctype_digit($value)) {
					if (!in_array($value, array('top', 'bottom', 'center')))
						return FALSE;
				}
				else
				{
					$value = (int)$value;
				}
				break;
			case 'left':
				if (is_string($value) AND !ctype_digit($value)) {
					if (!in_array($value, array('left', 'right', 'center')))
						return FALSE;
				}
				else
				{
					$value = (int)$value;
				}
				break;
			case 'master':
				if ($value !== Image::NONE AND
					$value !== Image::AUTO AND
					$value !== Image::WIDTH AND
					$value !== Image::HEIGHT
				)
					return FALSE;
				break;
		}

		return TRUE;
	}

} // End Image