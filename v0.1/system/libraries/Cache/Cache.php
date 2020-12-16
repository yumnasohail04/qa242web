<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 2.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Caching Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Core
 * @author		EllisLab Dev Team
 * @link
 */
class CI_Cache extends CI_Driver_Library {
    
	/**
	 * Valid cache drivers
	 *
	 * @var array
	 */
	protected $valid_drivers = array(
		'apc',
		'dummy',
		'file',
		'memcached',
		'redis',
		'wincache'
	);

	/**
	 * Path of cache files (if file-based cache)
	 *
	 * @var string
	 */
	protected $_cache_path = NULL;

	/**
	 * Reference to the driver
	 *
	 * @var mixed
	 */
	protected $_adapter = 'dummy';

	/**
	 * Fallback driver
	 *
	 * @var string
	 */
	protected $_backup_driver = 'dummy';

	/**
	 * Cache key prefix
	 *
	 * @var	string
	 */
	public $key_prefix = '';

	/**
	 * Constructor
	 *
	 * Initialize class properties based on the configuration array.
	 *
	 * @param	array	$config = array()
	 * @return	void
	 */
	private $_ci;
	private $_path;
	private $_contents;
	private $_filename;
	private $_expires;
	private $_default_expires;
	private $_created;
	private $_dependencies;
	public function __construct($config = array())
	{
		isset($config['adapter']) && $this->_adapter = $config['adapter'];
		isset($config['backup']) && $this->_backup_driver = $config['backup'];
		isset($config['key_prefix']) && $this->key_prefix = $config['key_prefix'];

		// If the specified adapter isn't available, check the backup.
		if ( ! $this->is_supported($this->_adapter))
		{
			if ( ! $this->is_supported($this->_backup_driver))
			{
				// Backup isn't supported either. Default to 'Dummy' driver.
				log_message('error', 'Cache adapter "'.$this->_adapter.'" and backup "'.$this->_backup_driver.'" are both unavailable. Cache is now using "Dummy" adapter.');
				$this->_adapter = 'dummy';
			}
			else
			{
				// Backup is supported. Set it to primary.
				log_message('debug', 'Cache adapter "'.$this->_adapter.'" is unavailable. Falling back to "'.$this->_backup_driver.'" backup adapter.');
				$this->_adapter = $this->_backup_driver;
			}
		}

		$this->_ci =& get_instance();
		$this->_reset();

		$this->_ci->load->config('cache');

		$this->_path = $this->_ci->config->item('cache_dir');
		$this->_default_expires = $this->_ci->config->item('cache_default_expires');
		if ( ! is_dir($this->_path))
		{
			show_error("Cache Path not found: $this->_path");
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Get
	 *
	 * Look for a value in the cache. If it exists, return the data
	 * if not, return FALSE
	 *
	 * @param	string	$id
	 * @return	mixed	value matching $id or FALSE on failure
	 */
	function get($filename = NULL, $use_expires = true)
	{
		// Check if cache was requested with the function or uses this object
		if ($filename !== NULL)
		{
			$this->_reset();
			$this->_filename = $filename;
		}

		// Check directory permissions
		if ( ! is_dir($this->_path) OR ! is_really_writable($this->_path))
		{
			return FALSE;
		}

		// Build the file path.
		$filepath = $this->_path.$this->_filename.'.cache';

		// Check if the cache exists, if not return FALSE
		if ( ! @file_exists($filepath))
		{
			return FALSE;
		}

		// Check if the cache can be opened, if not return FALSE
		if ( ! $fp = @fopen($filepath, FOPEN_READ))
		{
			return FALSE;
		}

		// Lock the cache
		flock($fp, LOCK_SH);

		// If the file contains data return it, otherwise return NULL
		if (filesize($filepath) > 0)
		{
			$this->_contents = unserialize(fread($fp, filesize($filepath)));
		}
		else
		{
			$this->_contents = NULL;
		}

		// Unlock the cache and close the file
		flock($fp, LOCK_UN);
		fclose($fp);

		// Check cache expiration, delete and return FALSE when expired
		if ($use_expires && ! empty($this->_contents['__cache_expires']) && $this->_contents['__cache_expires'] < time())
		{
			$this->delete($filename);
			return FALSE;
		}

		// Check Cache dependencies
		if(isset($this->_contents['__cache_dependencies']))
		{
			foreach ($this->_contents['__cache_dependencies'] as $dep)
			{
				$cache_created = filemtime($this->_path.$this->_filename.'.cache');

				// If dependency doesn't exist or is newer than this cache, delete and return FALSE
				if (! file_exists($this->_path.$dep.'.cache') or filemtime($this->_path.$dep.'.cache') > $cache_created)
				{
					$this->delete($filename);
					return FALSE;
				}
			}
		}

		// Instantiate the object variables
		$this->_expires		= isset($this->_contents['__cache_expires']) ? $this->_contents['__cache_expires'] : NULL;
		$this->_dependencies = isset($this->_contents['__cache_dependencies']) ? $this->_contents['__cache_dependencies'] : NULL;
		$this->_created		= isset($this->_contents['__cache_created']) ? $this->_contents['__cache_created'] : NULL;

		// Cleanup the meta variables from the contents
		$this->_contents = @$this->_contents['__cache_contents'];

		// Return the cache
		log_message('debug', "Cache retrieved: ".$filename);
		return $this->_contents;
	}

	// ------------------------------------------------------------------------

	/**
	 * Cache Save
	 *
	 * @param	string	$id	Cache ID
	 * @param	mixed	$data	Data to store
	 * @param	int	$ttl	Cache TTL (in seconds)
	 * @param	bool	$raw	Whether to store the raw value
	 * @return	bool	TRUE on success, FALSE on failure
	 */
	public function save($id, $data, $ttl = 60, $raw = FALSE)
	{
		return $this->{$this->_adapter}->save($this->key_prefix.$id, $data, $ttl, $raw);
	}
	
	/**
	 * Write Cache File
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @param	int
	 * @param	array
	 * @return	void
	 */
	function write($contents = NULL, $filename = NULL, $expires = NULL, $dependencies = array())
	{
		// Check if cache was passed with the function or uses this object
		if ($contents !== NULL)
		{
			$this->_reset();
			$this->_contents = $contents;
			$this->_filename = $filename;
			$this->_expires = $expires;
			$this->_dependencies = $dependencies;
		}

		// Put the contents in an array so additional meta variables
		// can be easily removed from the output
		$this->_contents = array('__cache_contents' => $this->_contents);
		// Check directory permissions
		if ( ! is_dir($this->_path) OR ! is_really_writable($this->_path))
		{
			return;
		}

		// check if filename contains dirs
		$subdirs = explode(DIRECTORY_SEPARATOR, $this->_filename);
		if (count($subdirs) > 1)
		{
			array_pop($subdirs);
			$test_path = $this->_path.implode(DIRECTORY_SEPARATOR, $subdirs);

			// check if specified subdir exists
			if ( ! @file_exists($test_path))
			{
				// create non existing dirs, asumes PHP5
				if ( ! @mkdir($test_path, DIR_WRITE_MODE, TRUE)) return FALSE;
			}
		}

		// Set the path to the cachefile which is to be created
		$cache_path = $this->_path.$this->_filename.'.cache';

		// Open the file and log if an error occures
		if ( ! $fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE))
		{
			log_message('error', "Unable to write Cache file: ".$cache_path);
			return;
		}

		// Meta variables
		$this->_contents['__cache_created'] = time();
		$this->_contents['__cache_dependencies'] = $this->_dependencies;

		// Add expires variable if its set...
		if (! empty($this->_expires))
		{
			$this->_contents['__cache_expires'] = $this->_expires + time();
		}
		// ...or add default expiration if its set
		elseif (! empty($this->_default_expires) )
		{
			$this->_contents['__cache_expires'] = $this->_default_expires + time();
		}

		// Lock the file before writing or log an error if it failes
		if (flock($fp, LOCK_EX))
		{
			fwrite($fp, serialize($this->_contents));
			flock($fp, LOCK_UN);
		}
		else
		{
			log_message('error', "Cache was unable to secure a file lock for file at: ".$cache_path);
			return;
		}
		fclose($fp);
		@chmod($cache_path, DIR_WRITE_MODE);

		// Log success
		log_message('debug', "Cache file written: ".$cache_path);

		// Reset values
		$this->_reset();
	}
	
	/**
	 * Initialize Cache object to empty
	 *
	 * @access	private
	 * @return	void
	 */
	private function _reset()
	{
		$this->_contents = NULL;
		$this->_filename = NULL;
		$this->_expires = NULL;
		$this->_created = NULL;
		$this->_dependencies = array();
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete from Cache
	 *
	 * @param	string	$id	Cache ID
	 * @return	bool	TRUE on success, FALSE on failure
	 */
	public function delete($id)
	{
		return $this->{$this->_adapter}->delete($this->key_prefix.$id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Increment a raw value
	 *
	 * @param	string	$id	Cache ID
	 * @param	int	$offset	Step/value to add
	 * @return	mixed	New value on success or FALSE on failure
	 */
	public function increment($id, $offset = 1)
	{
		return $this->{$this->_adapter}->increment($this->key_prefix.$id, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Decrement a raw value
	 *
	 * @param	string	$id	Cache ID
	 * @param	int	$offset	Step/value to reduce by
	 * @return	mixed	New value on success or FALSE on failure
	 */
	public function decrement($id, $offset = 1)
	{
		return $this->{$this->_adapter}->decrement($this->key_prefix.$id, $offset);
	}

	// ------------------------------------------------------------------------

	/**
	 * Clean the cache
	 *
	 * @return	bool	TRUE on success, FALSE on failure
	 */
	public function clean()
	{
		return $this->{$this->_adapter}->clean();
	}

	// ------------------------------------------------------------------------

	/**
	 * Cache Info
	 *
	 * @param	string	$type = 'user'	user/filehits
	 * @return	mixed	array containing cache info on success OR FALSE on failure
	 */
	public function cache_info($type = 'user')
	{
		return $this->{$this->_adapter}->cache_info($type);
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Cache Metadata
	 *
	 * @param	string	$id	key to get cache metadata on
	 * @return	mixed	cache item metadata
	 */
	public function get_metadata($id)
	{
		return $this->{$this->_adapter}->get_metadata($this->key_prefix.$id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Is the requested driver supported in this environment?
	 *
	 * @param	string	$driver	The driver to test
	 * @return	array
	 */
	public function is_supported($driver)
	{
		static $support;

		if ( ! isset($support, $support[$driver]))
		{
			$support[$driver] = $this->{$driver}->is_supported();
		}

		return $support[$driver];
	}
}
