<?php

namespace Admin\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

/**
 * File Uploading Component
 *
 * @author        Zankat Kalpesh
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
class FileuploadComponent extends Component {

	/**
	 * Maximum file size
	 *
	 * @var	int
	 */
	public $max_size = 0;

	/**
	 * Maximum image width
	 *
	 * @var	int
	 */
	public $max_width = 0;

	/**
	 * Maximum image height
	 *
	 * @var	int
	 */
	public $max_height = 0;

	/**
	 * Minimum image width
	 *
	 * @var	int
	 */
	public $min_width = 0;

	/**
	 * Minimum image height
	 *
	 * @var	int
	 */
	public $min_height = 0;

	/**
	 * Maximum filename length
	 *
	 * @var	int
	 */
	public $max_filename = 0;

	/**
	 * Maximum duplicate filename increment ID
	 *
	 * @var	int
	 */
	public $max_filename_increment = 100;

	/**
	 * Allowed file types
	 *
	 * @var	string
	 */
	public $allowed_types = '';

	/**
	 * Temporary filename
	 *
	 * @var	string
	 */
	public $file_temp = '';

	/**
	 * Filename
	 *
	 * @var	string
	 */
	public $file_name = '';

	/**
	 * Original filename
	 *
	 * @var	string
	 */
	public $orig_name = '';

	/**
	 * File type
	 *
	 * @var	string
	 */
	public $file_type = '';

	/**
	 * File size
	 *
	 * @var	int
	 */
	public $file_size = NULL;

	/**
	 * Filename extension
	 *
	 * @var	string
	 */
	public $file_ext = '';

	/**
	 * Force filename extension to lowercase
	 *
	 * @var	string
	 */
	public $file_ext_tolower = FALSE;

	/**
	 * Upload path
	 *
	 * @var	string
	 */
	public $upload_path = '';

	/**
	 * Overwrite flag
	 *
	 * @var	bool
	 */
	public $overwrite = FALSE;

	/**
	 * Obfuscate filename flag
	 *
	 * @var	bool
	 */
	public $encrypt_name = FALSE;

	/**
	 * Is image flag
	 *
	 * @var	bool
	 */
	public $is_image = FALSE;

	/**
	 * Image width
	 *
	 * @var	int
	 */
	public $image_width = NULL;

	/**
	 * Image height
	 *
	 * @var	int
	 */
	public $image_height = NULL;

	/**
	 * Image type
	 *
	 * @var	string
	 */
	public $image_type = '';

	/**
	 * Image size string
	 *
	 * @var	string
	 */
	public $image_size_str = '';

	/**
	 * Error messages list
	 *
	 * @var	array
	 */
	public $error_msg = array();

	/**
	 * Remove spaces flag
	 *
	 * @var	bool
	 */
	public $remove_spaces = TRUE;

	/**
	 * MIME detection flag
	 *
	 * @var	bool
	 */
	public $detect_mime = TRUE;

	/**
	 * XSS filter flag
	 *
	 * @var	bool
	 */
	public $xss_clean = FALSE;

	/**
	 * Apache mod_mime fix flag
	 *
	 * @var	bool
	 */
	public $mod_mime_fix = TRUE;

	/**
	 * Temporary filename prefix
	 *
	 * @var	string
	 */
	public $temp_prefix = 'temp_file_';

	/**
	 * Filename sent by the client
	 *
	 * @var	bool
	 */
	public $client_name = '';

	// --------------------------------------------------------------------

	/**
	 * Filename override
	 *
	 * @var	string
	 */
	protected $_file_name_override = '';

	/**
	 * MIME types list
	 *
	 * @var	array
	 */
	protected $_mimes = array();

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @param	array	$config
	 * @return	void
	 */
	public function initialize(array $config): void
	{
		parent::initialize($config);

		//Load Configure File
		Configure::load('fileupload');
		//Read Default Configure
		$dConfig = Configure::read('default');
		//Check config var type
		if(!is_array($dConfig)){ $dConfig = array(); }
		
		//call init
		empty($dConfig) OR $this->init($dConfig, FALSE);
		
		//Read mime_types Configure
		$mime_types = Configure::read('mime_types');
		//Check mime_types var type
		if(empty($mime_types) || !is_array($mime_types)){
			$mime_types = array();
		}
		$this->_mimes = $mime_types;
	}
	
	// --------------------------------------------------------------------

	/**
	 * init preferences
	 *
	 * @param	array	$sConfig
	 * @param	bool	$reset
	 * @return	FileuploadComponent
	 */
	 
	public function init($sConfig = array(), $reset = TRUE)
	{
		$this->_file_name_override = '';
		
		$reflection = new \ReflectionClass($this);
		if ($reset === TRUE)
		{
			$defaults = $reflection->getDefaultProperties();
			foreach (array_keys($defaults) as $key)
			{
				if ($key[0] === '_')
				{
					continue;
				}

				if (isset($sConfig[$key]))
				{
					if ($reflection->hasMethod('set_'.$key))
					{
						$this->{'set_'.$key}($sConfig[$key]);
					}
					else
					{
						$this->$key = $sConfig[$key];
					}
				}
			}
		}
		else
		{
			foreach ($sConfig as $key => &$value)
			{
				if ($key[0] !== '_' && $reflection->hasProperty($key))
				{
					if ($reflection->hasMethod('set_'.$key))
					{
						$this->{'set_'.$key}($value);
					}
					else
					{
						$this->$key = $value;
					}
				}
			}
		}

		// if a file_name was provided in the config, use it instead of the user input
		// supplied file name for all uploads until initialized again
		$this->_file_name_override = $this->file_name;
		//$this->_file_name_override = '';
		
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Perform the file upload
	 *
	 * @param	string	$field
	 * @return	bool
	 */
	public function upload($field = 'upload_file')
	{
		// Is $_FILES[$field] set? If not, no reason to continue.
		if (isset($_FILES[$field]))
		{
			$_file = $_FILES[$field];
		}
		// Does the field name contain array notation?
		elseif (($c = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $field, $matches)) > 1)
		{
			$_file = $_FILES;
			for ($i = 0; $i < $c; $i++)
			{
				// We can't track numeric iterations, only full field names are accepted
				if (($field = trim($matches[0][$i], '[]')) === '' OR ! isset($_file[$field]))
				{
					$_file = NULL;
					break;
				}

				$_file = $_file[$field];
			}
		}

		if ( ! isset($_file))
		{
			$this->set_error('upload_no_file_selected', 'debug');
			return FALSE;
		}

		// Is the upload path valid?
		if ( ! $this->validate_upload_path())
		{
			// errors will already be set by validate_upload_path() so just return FALSE
			return FALSE;
		}

		// Was the file able to be uploaded? If not, determine the reason why.
		if ( ! is_uploaded_file($_file['tmp_name']))
		{
			$error = isset($_file['error']) ? $_file['error'] : 4;

			switch ($error)
			{
				case UPLOAD_ERR_INI_SIZE:
					$this->set_error('upload_file_exceeds_limit', 'info');
					break;
				case UPLOAD_ERR_FORM_SIZE:
					$this->set_error('upload_file_exceeds_form_limit', 'info');
					break;
				case UPLOAD_ERR_PARTIAL:
					$this->set_error('upload_file_partial', 'debug');
					break;
				case UPLOAD_ERR_NO_FILE:
					$this->set_error('upload_no_file_selected', 'debug');
					break;
				case UPLOAD_ERR_NO_TMP_DIR:
					$this->set_error('upload_no_temp_directory', 'error');
					break;
				case UPLOAD_ERR_CANT_WRITE:
					$this->set_error('upload_unable_to_write_file', 'error');
					break;
				case UPLOAD_ERR_EXTENSION:
					$this->set_error('upload_stopped_by_extension', 'debug');
					break;
				default:
					$this->set_error('upload_no_file_selected', 'debug');
					break;
			}

			return FALSE;
		}

		// Set the uploaded data as class variables
		$this->file_temp = $_file['tmp_name'];
		$this->file_size = $_file['size'];

		// Skip MIME type detection?
		if ($this->detect_mime !== FALSE)
		{
			$this->_file_mime_type($_file);
		}

		$this->file_type = preg_replace('/^(.+?);.*$/', '\\1', $this->file_type);
		$this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
		$this->file_name = $this->_prep_filename($_file['name']);
		$this->file_ext	 = $this->get_extension($this->file_name);
		$this->client_name = $this->file_name;

		// Is the file type allowed to be uploaded?
		if ( ! $this->is_allowed_filetype())
		{
			$this->set_error('upload_invalid_filetype', 'debug');
			return FALSE;
		}

		// if we're overriding, let's now make sure the new name and type is allowed
		if ($this->_file_name_override !== '')
		{
			$this->file_name = $this->_prep_filename($this->_file_name_override);

			// If no extension was provided in the file_name config item, use the uploaded one
			if (strpos($this->_file_name_override, '.') === FALSE)
			{
				$this->file_name .= $this->file_ext;
			}
			else
			{
				// An extension was provided, let's have it!
				$this->file_ext	= $this->get_extension($this->_file_name_override);
			}

			if ( ! $this->is_allowed_filetype(TRUE))
			{
				$this->set_error('upload_invalid_filetype', 'debug');
				return FALSE;
			}
		}

		// Convert the file size to kilobytes
		if ($this->file_size > 0)
		{
			$this->file_size = round($this->file_size/1024, 2);
		}

		// Is the file size within the allowed maximum?
		if ( ! $this->is_allowed_filesize())
		{
			$this->set_error('upload_invalid_filesize', 'info');
			return FALSE;
		}

		// Are the image dimensions within the allowed size?
		// Note: This can fail if the server has an open_basedir restriction.
		if ( ! $this->is_allowed_dimensions())
		{
			$this->set_error('upload_invalid_dimensions', 'info');
			return FALSE;
		}

		// Sanitize the file name for security
		$this->file_name = $this->sanitize_filename($this->file_name);

		// Truncate the file name if it's too long
		if ($this->max_filename > 0)
		{
			$this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);
		}

		// Remove white spaces in the name
		if ($this->remove_spaces === TRUE)
		{
			$this->file_name = preg_replace('/\s+/', '_', $this->file_name);
		}

		if ($this->file_ext_tolower && ($ext_length = strlen($this->file_ext)))
		{
			// file_ext was previously lower-cased by a get_extension() call
			$this->file_name = substr($this->file_name, 0, -$ext_length).$this->file_ext;
		}

		/*
		 * Validate the file name
		 * This function appends an number onto the end of
		 * the file if one with the same name already exists.
		 * If it returns false there was a problem.
		 */
		$this->orig_name = $this->file_name;
		if (FALSE === ($this->file_name = $this->set_filename($this->upload_path, $this->file_name)))
		{
			return FALSE;
		}

		/*
		 * Run the file through the XSS hacking filter
		 * This helps prevent malicious code from being
		 * embedded within a file. Scripts can easily
		 * be disguised as images or other file types.
		 */
		if ($this->xss_clean && $this->do_xss_clean() === FALSE)
		{
			$this->set_error('upload_unable_to_write_file', 'error');
			return FALSE;
		}

		/*
		 * Move the file to the final destination
		 * To deal with different server configurations
		 * we'll attempt to use copy() first. If that fails
		 * we'll use move_uploaded_file(). One of the two should
		 * reliably work in most environments
		 */
		if ( ! @copy($this->file_temp, $this->upload_path.$this->file_name))
		{
			if ( ! @move_uploaded_file($this->file_temp, $this->upload_path.$this->file_name))
			{
				$this->set_error('upload_destination_error', 'error');
				return FALSE;
			}
		}

		/*
		 * Set the finalized image dimensions
		 * This sets the image width/height (assuming the
		 * file was an image). We use this information
		 * in the "data" function.
		 */
		$this->set_image_properties($this->upload_path.$this->file_name);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Finalized filedata Array
	 *
	 * Returns an associative array containing all of the information
	 * related to the upload, allowing the developer easy access in one array.
	 *
	 * @param	string	$index
	 * @return	mixed
	 */
	public function output($index = NULL)
	{
		$filedata = array(
				'file_name'		=> $this->file_name,
				'file_type'		=> $this->file_type,
				'file_path'		=> $this->upload_path,
				'full_path'		=> $this->upload_path.$this->file_name,
				'raw_name'		=> substr($this->file_name, 0, -strlen($this->file_ext)),
				'orig_name'		=> $this->orig_name,
				'client_name'		=> $this->client_name,
				'file_ext'		=> $this->file_ext,
				'file_size'		=> $this->file_size,
				'is_image'		=> $this->is_image(),
				'image_width'		=> $this->image_width,
				'image_height'		=> $this->image_height,
				'image_type'		=> $this->image_type,
				'image_size_str'	=> $this->image_size_str,
			);

		if ( ! empty($index))
		{
			return isset($filedata[$index]) ? $filedata[$index] : NULL;
		}

		return $filedata;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Upload Path
	 *
	 * @param	string	$path
	 * @return	FileuploadComponent
	 */
	public function set_upload_path($path)
	{
		// Make sure it has a trailing slash
		$this->upload_path = rtrim($path, '/').'/';
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set the file name
	 *
	 * This function takes a filename/path as input and looks for the
	 * existence of a file with the same name. If found, it will append a
	 * number to the end of the filename to avoid overwriting a pre-existing file.
	 *
	 * @param	string	$path
	 * @param	string	$filename
	 * @return	string
	 */
	public function set_filename($path, $filename)
	{
		if ($this->encrypt_name === TRUE)
		{
			$filename = md5(uniqid(mt_rand())).$this->file_ext;
		}

		if ($this->overwrite === TRUE OR ! file_exists($path.$filename))
		{
			return $filename;
		}

		$filename = str_replace($this->file_ext, '', $filename);

		$new_filename = '';
		for ($i = 1; $i < $this->max_filename_increment; $i++)
		{
			if ( ! file_exists($path.$filename.$i.$this->file_ext))
			{
				$new_filename = $filename.$i.$this->file_ext;
				break;
			}
		}

		if ($new_filename === '')
		{
			$this->set_error('upload_bad_filename', 'debug');
			return FALSE;
		}
		else
		{
			return $new_filename;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set Maximum File Size
	 *
	 * @param	int	$n
	 * @return	FileuploadComponent
	 */
	public function set_max_filesize($n)
	{
		$this->max_size = ($n < 0) ? 0 : (int) $n;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Maximum File Size
	 *
	 * An internal alias to set_max_filesize() to help with configuration
	 * as initialize() will look for a set_<property_name>() method ...
	 *
	 * @param	int	$n
	 * @return	FileuploadComponent
	 */
	protected function set_max_size($n)
	{
		return $this->set_max_filesize($n);
	}

	// --------------------------------------------------------------------

	/**
	 * Set Maximum File Name Length
	 *
	 * @param	int	$n
	 * @return	FileuploadComponent
	 */
	public function set_max_filename($n)
	{
		$this->max_filename = ($n < 0) ? 0 : (int) $n;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Maximum Image Width
	 *
	 * @param	int	$n
	 * @return	FileuploadComponent
	 */
	public function set_max_width($n)
	{
		$this->max_width = ($n < 0) ? 0 : (int) $n;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Maximum Image Height
	 *
	 * @param	int	$n
	 * @return	FileuploadComponent
	 */
	public function set_max_height($n)
	{
		$this->max_height = ($n < 0) ? 0 : (int) $n;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set minimum image width
	 *
	 * @param	int	$n
	 * @return	FileuploadComponent
	 */
	public function set_min_width($n)
	{
		$this->min_width = ($n < 0) ? 0 : (int) $n;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set minimum image height
	 *
	 * @param	int	$n
	 * @return	FileuploadComponent
	 */
	public function set_min_height($n)
	{
		$this->min_height = ($n < 0) ? 0 : (int) $n;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Allowed File Types
	 *
	 * @param	mixed	$types
	 * @return	FileuploadComponent
	 */
	public function set_allowed_types($types)
	{
		$this->allowed_types = (is_array($types) OR $types === '*')
			? $types
			: explode('|', $types);
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Image Properties
	 *
	 * Uses GD to determine the width/height/type of image
	 *
	 * @param	string	$path
	 * @return	FileuploadComponent
	 */
	public function set_image_properties($path = '')
	{
		if ($this->is_image() && function_exists('getimagesize'))
		{
			if (FALSE !== ($D = @getimagesize($path)))
			{
				$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');

				$this->image_width	= $D[0];
				$this->image_height	= $D[1];
				$this->image_type	= isset($types[$D[2]]) ? $types[$D[2]] : 'unknown';
				$this->image_size_str	= $D[3]; // string containing height and width
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set XSS Clean
	 *
	 * Enables the XSS flag so that the file that was uploaded
	 * will be run through the XSS filter.
	 *
	 * @param	bool	$flag
	 * @return	FileuploadComponent
	 */
	public function set_xss_clean($flag = FALSE)
	{
		$this->xss_clean = ($flag === TRUE);
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate the image
	 *
	 * @return	bool
	 */
	public function is_image()
	{
		// IE will sometimes return odd mime-types during upload, so here we just standardize all
		// jpegs or pngs to the same file type.

		$png_mimes  = array('image/x-png');
		$jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');

		if (in_array($this->file_type, $png_mimes))
		{
			$this->file_type = 'image/png';
		}
		elseif (in_array($this->file_type, $jpeg_mimes))
		{
			$this->file_type = 'image/jpeg';
		}

		$img_mimes = array('image/gif',	'image/jpeg', 'image/png');

		return in_array($this->file_type, $img_mimes, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Verify that the filetype is allowed
	 *
	 * @param	bool	$ignore_mime
	 * @return	bool
	 */
	public function is_allowed_filetype($ignore_mime = FALSE)
	{
		if ($this->allowed_types === '*')
		{
			return TRUE;
		}

		if (empty($this->allowed_types) OR ! is_array($this->allowed_types))
		{
			$this->set_error('upload_no_file_types', 'debug');
			return FALSE;
		}

		$ext = strtolower(ltrim($this->file_ext, '.'));

		if ( ! in_array($ext, $this->allowed_types, TRUE))
		{
			return FALSE;
		}

		// Images get some additional checks
		if (in_array($ext, array('gif', 'jpg', 'jpeg', 'jpe', 'png'), TRUE) && @getimagesize($this->file_temp) === FALSE)
		{
			return FALSE;
		}

		if ($ignore_mime === TRUE)
		{
			return TRUE;
		}

		if (isset($this->_mimes[$ext]))
		{
			return is_array($this->_mimes[$ext])
				? in_array($this->file_type, $this->_mimes[$ext], TRUE)
				: ($this->_mimes[$ext] === $this->file_type);
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Verify that the file is within the allowed size
	 *
	 * @return	bool
	 */
	public function is_allowed_filesize()
	{
		return ($this->max_size === 0 OR $this->max_size > $this->file_size);
	}

	// --------------------------------------------------------------------

	/**
	 * Verify that the image is within the allowed width/height
	 *
	 * @return	bool
	 */
	public function is_allowed_dimensions()
	{
		if ( ! $this->is_image())
		{
			return TRUE;
		}

		if (function_exists('getimagesize'))
		{
			$D = @getimagesize($this->file_temp);

			if ($this->max_width > 0 && $D[0] > $this->max_width)
			{
				return FALSE;
			}

			if ($this->max_height > 0 && $D[1] > $this->max_height)
			{
				return FALSE;
			}

			if ($this->min_width > 0 && $D[0] < $this->min_width)
			{
				return FALSE;
			}

			if ($this->min_height > 0 && $D[1] < $this->min_height)
			{
				return FALSE;
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate Upload Path
	 *
	 * Verifies that it is a valid upload path with proper permissions.
	 *
	 * @return	bool
	 */
	public function validate_upload_path()
	{
		if ($this->upload_path === '')
		{
			$this->set_error('upload_no_filepath', 'error');
			return FALSE;
		}

		if (realpath($this->upload_path) !== FALSE)
		{
			$this->upload_path = str_replace('\\', '/', realpath($this->upload_path));
		}

		if ( ! is_dir($this->upload_path))
		{
			$this->set_error('upload_no_filepath', 'error');
			return FALSE;
		}

		if ( ! $this->is_really_writable($this->upload_path))
		{
			$this->set_error('upload_not_writable', 'error');
			return FALSE;
		}

		$this->upload_path = preg_replace('/(.+?)\/*$/', '\\1/',  $this->upload_path);
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Extract the file extension
	 *
	 * @param	string	$filename
	 * @return	string
	 */
	public function get_extension($filename)
	{
		$x = explode('.', $filename);

		if (count($x) === 1)
		{
			return '';
		}

		$ext = ($this->file_ext_tolower) ? strtolower(end($x)) : end($x);
		return '.'.$ext;
	}

	// --------------------------------------------------------------------

	/**
	 * Limit the File Name Length
	 *
	 * @param	string	$filename
	 * @param	int	$length
	 * @return	string
	 */
	public function limit_filename_length($filename, $length)
	{
		if (strlen($filename) < $length)
		{
			return $filename;
		}

		$ext = '';
		if (strpos($filename, '.') !== FALSE)
		{
			$parts		= explode('.', $filename);
			$ext		= '.'.array_pop($parts);
			$filename	= implode('.', $parts);
		}

		return substr($filename, 0, ($length - strlen($ext))).$ext;
	}

	// --------------------------------------------------------------------

	/**
	 * Runs the file through the XSS clean function
	 *
	 * This prevents people from embedding malicious code in their files.
	 * I'm not sure that it won't negatively affect certain files in unexpected ways,
	 * but so far I haven't found that it causes trouble.
	 *
	 * @return	string
	 */
	public function do_xss_clean()
	{
		$file = $this->file_temp;

		if (filesize($file) == 0)
		{
			return FALSE;
		}

		if (memory_get_usage() && ($memory_limit = ini_get('memory_limit')))
		{
			$memory_limit *= 1024 * 1024;

			// There was a bug/behavioural change in PHP 5.2, where numbers over one million get output
			// into scientific notation. number_format() ensures this number is an integer
			// http://bugs.php.net/bug.php?id=43053

			$memory_limit = number_format(ceil(filesize($file) + $memory_limit), 0, '.', '');

			ini_set('memory_limit', $memory_limit); // When an integer is used, the value is measured in bytes. - PHP.net
		}

		// If the file being uploaded is an image, then we should have no problem with XSS attacks (in theory), but
		// IE can be fooled into mime-type detecting a malformed image as an html file, thus executing an XSS attack on anyone
		// using IE who looks at the image. It does this by inspecting the first 255 bytes of an image. To get around this
		// CI will itself look at the first 255 bytes of an image to determine its relative safety. This can save a lot of
		// processor power and time if it is actually a clean image, as it will be in nearly all instances _except_ an
		// attempted XSS attack.

		if (function_exists('getimagesize') && @getimagesize($file) !== FALSE)
		{
			if (($file = @fopen($file, 'rb')) === FALSE) // "b" to force binary
			{
				return FALSE; // Couldn't open the file, return FALSE
			}

			$opening_bytes = fread($file, 256);
			fclose($file);

			// These are known to throw IE into mime-type detection chaos
			// <a, <body, <head, <html, <img, <plaintext, <pre, <script, <table, <title
			// title is basically just in SVG, but we filter it anyhow

			// if it's an image or no "triggers" detected in the first 256 bytes - we're good
			return ! preg_match('/<(a|body|head|html|img|plaintext|pre|script|table|title)[\s>]/i', $opening_bytes);
		}

		if (($fgc_data = @file_get_contents($file)) === FALSE)
		{
			return FALSE;
		}

		return $fgc_data;
	}

	// --------------------------------------------------------------------

	/**
	 * Set an error message
	 *
	 * @param	string	$msg
	 * @return	FileuploadComponent
	 */
	public function set_error($msg, $log_level = 'error')
	{
		is_array($msg) OR $msg = array($msg);
		foreach ($msg as $val){
			$this->error_msg[] = $val;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Display the error message
	 *
	 * @param	string	$open
	 * @param	string	$close
	 * @return	string
	 */
	public function errors()
	{
		return (count($this->error_msg) > 0) ? $this->error_msg : array();
	}

	// --------------------------------------------------------------------

	/**
	 * Prep Filename
	 *
	 * Prevents possible script execution from Apache's handling
	 * of files' multiple extensions.
	 *
	 * @link	http://httpd.apache.org/docs/1.3/mod/mod_mime.html#multipleext
	 *
	 * @param	string	$filename
	 * @return	string
	 */
	protected function _prep_filename($filename)
	{
		if ($this->mod_mime_fix === FALSE OR $this->allowed_types === '*' OR ($ext_pos = strrpos($filename, '.')) === FALSE)
		{
			return $filename;
		}

		$ext = substr($filename, $ext_pos);
		$filename = substr($filename, 0, $ext_pos);
		return str_replace('.', '_', $filename).$ext;
	}

	// --------------------------------------------------------------------

	/**
	 * File MIME type
	 *
	 * Detects the (actual) MIME type of the uploaded file, if possible.
	 * The input array is expected to be $_FILES[$field]
	 *
	 * @param	array	$file
	 * @return	void
	 */
	protected function _file_mime_type($file)
	{
		// We'll need this to validate the MIME info string (e.g. text/plain; charset=us-ascii)
		$regexp = '/^([a-z\-]+\/[a-z0-9\-\.\+]+)(;\s.+)?$/';

		/* Fileinfo extension - most reliable method
		 *
		 * Unfortunately, prior to PHP 5.3 - it's only available as a PECL extension and the
		 * more convenient FILEINFO_MIME_TYPE flag doesn't exist.
		 */
		if (function_exists('finfo_file'))
		{
			$finfo = @finfo_open(FILEINFO_MIME);
			if (is_resource($finfo)) // It is possible that a FALSE value is returned, if there is no magic MIME database file found on the system
			{
				$mime = @finfo_file($finfo, $file['tmp_name']);
				finfo_close($finfo);

				/* According to the comments section of the PHP manual page,
				 * it is possible that this function returns an empty string
				 * for some files (e.g. if they don't exist in the magic MIME database)
				 */
				if (is_string($mime) && preg_match($regexp, $mime, $matches))
				{
					$this->file_type = $matches[1];
					return;
				}
			}
		}

		/* Notes:
		 *	- the DIRECTORY_SEPARATOR comparison ensures that we're not on a Windows system
		 *	- many system admins would disable the exec(), shell_exec(), popen() and similar functions
		 *	  due to security concerns, hence the $this->function_usable() checks
		 */
		if (DIRECTORY_SEPARATOR !== '\\')
		{
			$cmd = function_exists('escapeshellarg')
				? 'file --brief --mime '.escapeshellarg($file['tmp_name']).' 2>&1'
				: 'file --brief --mime '.$file['tmp_name'].' 2>&1';

			if ($this->function_usable('exec'))
			{
				/* This might look confusing, as $mime is being populated with all of the output when set in the second parameter.
				 * However, we only need the last line, which is the actual return value of exec(), and as such - it overwrites
				 * anything that could already be set for $mime previously. This effectively makes the second parameter a dummy
				 * value, which is only put to allow us to get the return status code.
				 */
				$mime = @exec($cmd, $mime, $return_status);
				if ($return_status === 0 && is_string($mime) && preg_match($regexp, $mime, $matches))
				{
					$this->file_type = $matches[1];
					return;
				}
			}

			if ( ! ini_get('safe_mode') && $this->function_usable('shell_exec'))
			{
				$mime = @shell_exec($cmd);
				if (strlen($mime) > 0)
				{
					$mime = explode("\n", trim($mime));
					if (preg_match($regexp, $mime[(count($mime) - 1)], $matches))
					{
						$this->file_type = $matches[1];
						return;
					}
				}
			}

			if ($this->function_usable('popen'))
			{
				$proc = @popen($cmd, 'r');
				if (is_resource($proc))
				{
					$mime = @fread($proc, 512);
					@pclose($proc);
					if ($mime !== FALSE)
					{
						$mime = explode("\n", trim($mime));
						if (preg_match($regexp, $mime[(count($mime) - 1)], $matches))
						{
							$this->file_type = $matches[1];
							return;
						}
					}
				}
			}
		}

		// Fall back to the deprecated mime_content_type(), if available (still better than $_FILES[$field]['type'])
		if (function_exists('mime_content_type'))
		{
			$this->file_type = @mime_content_type($file['tmp_name']);
			if (strlen($this->file_type) > 0) // It's possible that mime_content_type() returns FALSE or an empty string
			{
				return;
			}
		}

		$this->file_type = $file['type'];
	}
	/**
	 * Function usable
	 *
	 * Executes a function_exists() check, and if the Suhosin PHP
	 * extension is loaded - checks whether the function that is
	 * checked might be disabled in there as well.
	 *
	 * This is useful as function_exists() will return FALSE for
	 * functions disabled via the *disable_functions* php.ini
	 * setting, but not for *suhosin.executor.func.blacklist* and
	 * *suhosin.executor.disable_eval*. These settings will just
	 * terminate script execution if a disabled function is executed.
	 *
	 * The above described behavior turned out to be a bug in Suhosin,
	 * but even though a fix was commited for 0.9.34 on 2012-02-12,
	 * that version is yet to be released. This function will therefore
	 * be just temporary, but would probably be kept for a few years.
	 */
	protected function function_usable($function_name)
	{
		static $_suhosin_func_blacklist;

		if (function_exists($function_name))
		{
			if ( ! isset($_suhosin_func_blacklist))
			{
				$_suhosin_func_blacklist = extension_loaded('suhosin')
					? explode(',', trim(ini_get('suhosin.executor.func.blacklist')))
					: array();
			}

			return ! in_array($function_name, $_suhosin_func_blacklist, TRUE);
		}

		return FALSE;
	}
	
	/**
	 * Tests for file writability
	 *
	 * is_writable() returns TRUE on Windows servers when you really can't write to
	 * the file, based on the read-only attribute. is_writable() is also unreliable
	 * on Unix servers if safe_mode is on.
	*/
	function is_really_writable($file)
	{
		// If we're on a Unix server with safe_mode off we call is_writable
		if (DIRECTORY_SEPARATOR === '/' && ($this->is_php('5.4') OR ! ini_get('safe_mode')))
		{
			return is_writable($file);
		}

		/* For Windows servers and safe_mode "on" installations we'll actually
		 * write a file then read it. Bah...
		 */
		if (is_dir($file))
		{
			$file = rtrim($file, '/').'/'.md5(mt_rand());
			if (($fp = @fopen($file, 'ab')) === FALSE)
			{
				return FALSE;
			}

			fclose($fp);
			@chmod($file, 0777);
			@unlink($file);
			return TRUE;
		}
		elseif ( ! is_file($file) OR ($fp = @fopen($file, 'ab')) === FALSE)
		{
			return FALSE;
		}

		fclose($fp);
		return TRUE;
	}
	/**
	 * Sanitize Filename
	 *
	 * @param	string	$str Input file name
	 * @param 	bool	$relative_path	Whether to preserve paths
	 * @return	string
	 */
	public function sanitize_filename($str, $relative_path = FALSE){
		$filename_bad_chars =	array(
			'../', '<!--', '-->', '<', '>',
			"'", '"', '&', '$', '#',
			'{', '}', '[', ']', '=',
			';', '?', '%20', '%22',
			'%3c',		// <
			'%253c',	// <
			'%3e',		// >
			'%0e',		// >
			'%28',		// (
			'%29',		// )
			'%2528',	// (
			'%26',		// &
			'%24',		// $
			'%3f',		// ?
			'%3b',		// ;
			'%3d'		// =
		);

		if ( ! $relative_path)
		{
			$filename_bad_chars[] = './';
			$filename_bad_chars[] = '/';
		}

		$str = $this->remove_invisible_characters($str, FALSE);

		do
		{
			$old = $str;
			$str = str_replace($filename_bad_chars, '', $str);
		}
		while ($old !== $str);

		return stripslashes($str);
	}
	
	/**
	 * Remove Invisible Characters
	 *
	 * This prevents sandwiching null characters
	 * between ascii characters, like Java\0script.
	 *
	 * @param	string
	 * @param	bool
	 * @return	string
	 */
	function remove_invisible_characters($str, $url_encoded = TRUE){
		$non_displayables = array();

		if ($url_encoded)
		{
			$non_displayables[] = '/%0[0-8bcef]/i';	// url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%1[0-9a-f]/i';	// url encoded 16-31
		}

		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

		do
		{
			$str = preg_replace($non_displayables, '', $str, -1, $count);
		}
		while ($count);

		return $str;
	}
	
	function is_php($version)
	{
		static $_is_php;
		$version = (string) $version;

		if ( ! isset($_is_php[$version]))
		{
			$_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
		}

		return $_is_php[$version];
	}
}
