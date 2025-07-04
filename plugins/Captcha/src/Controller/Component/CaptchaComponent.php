<?php

namespace Captcha\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Event\EventInterface;

class CaptchaComponent extends Component	{

    /**
     * Default monospaced fonts available
     *
     * The font files (.ttf) are stored in app/Lib/Fonts
     * You can add more fonts to this directory and then to the array below
     * @var array
     */
    private $__fonts = array('anonymous', 'droidsans', 'ubuntu');

    /**
     * Used in a mechanism to detect errors
     *
     * @var array
     */
    private $errors = array();

    /**
     * Set to define fatal error (Missing GD support or Font file)
     *
     * @var bool
     */
    private $fatalError = false;

    /**
     * Set to check about the True Type Font support
     *
     * @var bool
     */
    private $TTFSupport = true;

    /**
     * Set the default name of session key
     *
     * @var bool
     */
    private $sessionKey = 'captcha';

    /**
     * The default theme/texture on image, behind the captcha text
     *
     * @var array
     */
    private $themes = array(
      'default'=>array(
        'bgcolor'=>array(200,200, 200),
        'txtcolor'=>array(10, 30, 80),
        'noisecolor'=>array(60, 90, 120)
      )
    );

    /**
     * The default settings
     *
     * @var array
     */
    public $settings = array(
      'width' => 120,
      'height' => 40,
      'length' => 6,
      'theme'=>'default',
      'fontAdjustment'=>0.50,
      'type'=>'image',
      'field' => 'captcha',
      'rotate' => true,
      'reload_txt' => 'Can\'t read? Reload',
      'clabel' => 'Enter security code shown above:',
      'mlabel' => 'Answer simple math:'
    );

    public function initialize(array $config): void
    {
        //debug($this->Session->read());
        $this->Session = $this->_registry->getController()->getRequest()->getSession();
        $this->__init();
    }

    /**
     * Constructor
     *
     * @param ComponentRegistry $registry A formerly known "ComponentCollection" this component can use 
       to lazy load its   components
     * @param array $settings Array of configuration settings.
     */
    public function __construct(ComponentRegistry $registry, $settings = array()) {
        $this->Controller = $registry->getController();
        parent::__construct($registry, array_merge($this->settings, (array)$settings));
    }

    /**
     * Custom Intializer of our Component
     *
     * Checks the given setup for support
     * @param (void) 
     */
    private function __init() :void {
        
        //Check to see if the TTF support is enabled
        $this->__checkTTFSupport();

        //basically for helper specific settings
        $this->__setDefaults();

        //set the name of Session key
        $this->__setSessionKey();

        //Initialize captcha type (image or math text). If image do some basic support test like GD check and existence of font files. Create a Math Question if it's the Math Captcha
        $this->__initType();
        
        //Do not expect to get in there.
        if($this->__hasFatalError()) {
            die($this->__getStringErrors());
        }
    }

    /**
     * beforeRender
     *
     * @param ($instance of Controller) 
     */
    /* public function beforeRender() :void {
      $this->Controller->helpers['Captcha.Captcha'] = array_merge($this->__getSettings(), array('plugin'=>'Captcha', 'controller'=>'Captcha', 'action'=>'create'));
    } */

    public function implementedEvents(): array
    {
        return [
            'Controller.beforeRender' => 'beforeRender'
        ];
    }
    
    public function beforeRender(EventInterface $event): void
    {
        $controller = $event->getSubject(); // کنترلر فعال

        // افزودن Helper به ViewBuilder
        $controller->viewBuilder()->addHelper('Captcha.Captcha', array_merge(
            $this->__getSettings(),
            [
                'plugin' => 'Captcha',
                'controller' => 'Captcha',
                'action' => 'create'
            ]
        ));
    }
    /**
     * Set Helper generated params
     *
     * @param (void) 
     */
    function __setDefaults()    {

        //$q = $this->Controller->request->getQuery();
        $controller = $this->_registry->getController();
        $request = $controller->getRequest();
        $q = $request->getQuery();
        if(!$q) return;

        if(isset($q['length']))
          $q['length'] = intval($q['length']) <5 ? 5 : $q['length'];
        
        //Preference is given the settings parameter passed through helper
        foreach($this->settings as $k=>$v)  {
            if(isset($q[$k]) && $q[$k]) $this->settings[$k] = $q[$k];
        }
    }

    /**
     * Generate AlphaNumeric Key of given characters
     *
     * @param (void) 
     */
    function __AlphaNumeric() {

      /* list all possible characters ; similar looking characters and vowels have been ommitted */
      $possible = '23456789bcdfghjkmnpqrstvwxyz';//ABCDFGHJKMNPRSTVWXYZ

      $code = '';$i = 0;
      while ($i < $this->settings['length']) { 
        $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
        $i++;
      }
      return $code;
    }
    function __Numeric() {
      /* list all possible characters ; similar looking characters and vowels have been ommitted */
      $possible = '1234567890';//ABCDFGHJKMNPRSTVWXYZ
      $code = '';$i = 0;
      while ($i < $this->settings['length']) { 
        $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
        $i++;
      }
      return $code;
    }
    

    /**
     * Session Session key name for the current captcha call
     *
     * @param (void) 
     */
    private function __setSessionKey()
    {
        $this->sessionKey = "{$this->settings['field']}";
    }

    /**
     * return session key name for the current call
     *
     * @param (void) 
     */
    private function __getSessionKey()
    {
        return $this->sessionKey;
    }

    function create($settings = array()) {
      switch($this->__getType()):
        case 'number';
            $this->__imageCaptcha('number');
        break;
        case 'image';
          $this->__imageCaptcha();
        break;
        case 'math';
        /*if(isset($this->Controller->request->data[$this->settings['model']][$this->settings['field']]))  {
          $this->Controller->Session->write('security_code_math', $this->Controller->Session->read('security_code'));
        }*/

        $this->__mathCaptcha();
        echo  __($this->settings['stringOperation']);
        break;
      endswitch;
    }
    private function __initType()  {
      if($this->__getType() == 'image' or $this->__getType() == 'number')  {
       // Gets full path to fonts dir
       $font_path = dirname(dirname(dirname(__FILE__))) . DS . 'Lib' . DS . 'Fonts';

       $font_name = $this->__fonts[array_rand($this->__fonts)] . ".ttf";

       $this->settings['font'] = $font_path . DS . $font_name;

        if(!$this->__gdInfo())  {
           $this->__setError(__('Cannot use image captcha as GD library is not enabled! Set $this->settings[\'type\'] => \'math\' in order to show a simple math captcha instead!'));
           $this->fatalError = true;
        } else  {
          if(!$this->__TTFEnabled())  {
            $this->__setError(__("For best results use GD library with freetype font enabled!"));
            if(Configure::read('debug'))  {
              debug(__("CAPTCHA COMPONENT - For best results use GD library with Freetype enabled!"));
            }
          } else if(!file_exists($this->settings['font'])) {
            $this->__setError(__("Font file does not exist at location: ") . $this->settings['font']);
            $this->fatalError = true;
          }
        }
      }
      /* else  {
        $this->create();
      }*/
    }

    private function __setType($type)  {
      $this->settings['type'] = $type;
    }

    private function __getType()  {
      return $this->settings['type'];
    }

    private function __mathCaptcha()  {
      $operators = array("+", "-", "*");
      $rand_key = array_rand($operators);
      switch($operators[$rand_key]):
        case "+":
          $a = rand(0,20);
          $b = rand(0,20);
          $code = $a + $b;
          $stringOperation = $a . " + " . $b;
        break;
        case "-":
          $a = rand(0,20);
          $b = rand(0,20);
          $code = $a > $b ? $a - $b : $b - $a;
          $stringOperation =  $a > $b ? $a . " - " . $b : $b . " - " . $a;
        break;
        case "*":
          $a = rand(0,10);
          $b = rand(0,10);
          $code = $a * $b;
          $stringOperation = $a . " * " . $b;
        break;
      endswitch;
      $this->settings['stringOperation'] = $stringOperation;
			//debug($this->settings['stringOperation']);
			//debug($this->__getSessionKey());
			//debug($code);
      $this->Session->write($this->__getSessionKey(), $code);
    }

    function __imageCaptcha($type = null) {
        $width = $this->settings['width'];
        $height = $this->settings['height'];
        $this->__prepareThemes();
        $theme = $this->settings['theme'];
        if(!$this->__TTFEnabled())  {
            $width = 70;
            $height = 30;
            $theme = "default";
            $this->themes[$theme]['txtcolor'] = array(255, 255, 255);
        }
        if($type == 'number')
            $code = $this->__Numeric();
        else
            $code = $this->__AlphaNumeric();

        /* font size will be 75% of the image height */
        $font_size = $height * $this->settings['fontAdjustment'];
        $image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
        /* set the colours */
        $background_color = imagecolorallocate($image, $this->themes[$theme]['bgcolor'][0], $this->themes[$theme]['bgcolor'][1], $this->themes[$theme]['bgcolor'][2]);
        $text_color = imagecolorallocate($image, $this->themes[$theme]['txtcolor'][0], $this->themes[$theme]['txtcolor'][1], $this->themes[$theme]['txtcolor'][2]);
        $noise_color = imagecolorallocate($image, $this->themes[$theme]['noisecolor'][0], $this->themes[$theme]['noisecolor'][1], $this->themes[$theme]['noisecolor'][2]);
        /* generate random dots in background */
        for( $i=0; $i<($width*$height)/3; $i++ ) {
            imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
        }
        /* generate random lines in background */
        for( $i=0; $i<($width*$height)/150; $i++ ) {
            imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
        }

        /* create textbox and add text */
        if($this->__TTFEnabled())  {

            //If specified, rotate text
            $angle = 0;
            if($this->settings['rotate']) {
                $angle = rand(-15, 15);
            }

            $textbox = imagettfbbox($font_size, $angle, $this->settings['font'], $code) or die('Error in imagettfbbox function');
            $x = intval(($width - $textbox[4])/2);
            $y = intval(($height - $textbox[5])/2);
            $y -= 5;
            imagettftext($image, $font_size, $angle, $x, $y, $text_color, $this->settings['font'] , $code) or die('Error in imagettftext function');
        } else if(function_exists("imagestring"))  {
            //$font_size = imageloadfont($this->settings['font']);
            $textbox = imagestring($image, 5, 5, 5, $code, $text_color) or die('Error in imagestring function');
        } else  {
            $this->__setError("Cannot use image captcha without GD Library enabled!");
        }

        $sessionKey = $this->__getSessionKey();

        $this->Session->delete($sessionKey);
        $this->Session->write($sessionKey, $code);
        //@ob_end_clean(); //clean buffers, as a fix for 'headers already sent errors..'

        /* output captcha image to browser */
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
    }
    function getCode($sessionKey)	{
      return $this->Session->read("{$sessionKey}");
    }
    private function __prepareThemes()	{
      if($this->settings['theme']=='random')	{
        $this->themes['random'] = array(
          'bgcolor'=>array($bg_r=rand(0,255), $bg_g=rand(0,255), $bg_b=rand(0,255)),
          'txtcolor'=>array(rand(0,255), rand(0,255), rand(0,255)),
          'noisecolor'=>array(rand(0,255), rand(0,255), rand(0,255))
        );
        $ch_r = rand(40, 50);$ch_g = rand(40, 50);$ch_b = rand(40, 50);
        $txt_r = $bg_r+$ch_r >= 255 ? 255 : $bg_r+$ch_r;
        $txt_g = $bg_g+$ch_g >= 255 ? 255 : $bg_g+$ch_g;
        $txt_b = $bg_b+$ch_b >= 255 ? 255 : $bg_b+$ch_b;
        $this->themes['random']['txtcolor'] = array($txt_r, $txt_g, $txt_b);
      }
    }
    function __setError($error_message) {
      $this->errors[] = $error_message;
    }
    function __getErrors() {
      return $this->errors;
    }
    private function __hasErrors() {
      return !is_null($this->errors);
    }
    private function __hasFatalError()  {
      return $this->fatalError;
    }
    private function __getStringErrors()  {
      if($this->__hasErrors())  {
        $html = '<p>CAPTCHA ERRORS:</p><ul class="c-errors">';
        foreach($this->__getErrors() as $error) {
          $html .= '<li>' . $error . '</li>';
        }
        $html .= '</ul>';
        return $html;
      }
    }
    private function __checkTTFSupport() {
      if(!function_exists("imagettftext")) $this->TTFSupport = false;
    }
    private function __TTFEnabled()  {
      return $this->TTFSupport;
    }
    private function __getSettings()  {
      return $this->settings;
    }
    private function __gdInfo() {
      if(!function_exists("gd_info")) return false;
      return true;
    }
  }