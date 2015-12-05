<?php
defined('_VALID') or die('Restricted Access!');
class VCaptcha {
	public $width;
	public $height;
	public $fonts;

	private $min_font_size = 18;
	private $max_font_size;
	private $image;
	private $spacing;
	private $code		= '';
	private $characters	= 6;
	private $eclipses	= 150;
	private $lines		= 150;
		
	public function __construct( $width = 200, $height = 50 ) {
        $this->check();
        $this->setLevel();
		$this->fonts 	= array('Custom.ttf', 'Vera.ttf', 'VeraBd.ttf', 'VeraIt.ttf', 'VeraMoIt.ttf', 'VeraMono.ttf', 'VeraSe.ttf', 'arialbi.ttf');
		$this->width 	= $width;
		$this->height	= $height;
		$this->setSpacing();
		$this->setMaxFontSize();
		$this->setCode();
	}
	
    private function setLevel()
    {
        global $config;
        switch ( $config['captcha_level'] ) {
            case 'easy':
                $this->colorMax     = 127;
                $this->fontPosMin  = 0.6;
                $this->fontPosMax  = 0.9;
                $this->characters   = 5;
                break;
            case 'medium':
                $this->colorMax = 160;
                $this->fontPosMin  = 0.5;
                $this->fontPosMax  = 0.9;
                $this->characters   = 6;
                break;
            case 'hard':
                $this->colorMax = 200;
                $this->fontPosMin  = 0.3;
                $this->fontPosMax  = 0.7;
                $this->characters   = 7;
                break;
        }
    }
    
	private function setSpacing() {
		$this->spacing = (int)($this->width / $this->characters);
	}
	
	private function getFont() {
    		global $config;
		return $config['BASE_DIR']. '/data/fonts/' .$this->fonts[rand(0,count($this->fonts)-1)];
	}
	
	private function setMaxFontSize() {
		$this->max_font_size = round($this->width / $this->characters);
	}
	
	private function setCode() {
		for( $i=0; $i<$this->characters; $i++ ) {
            $chars['1']     = rand(97,122);
            $chars['2']     = rand(65,90);
			$this->code    .= chr($chars[rand(1,2)]);
		}
		
		$_SESSION['captcha_code'] = strtoupper($this->code);
	}
	
	private function setBackground() {
		$color = imagecolorallocate($this->image, 48, 63, 68);
		imagefilltoborder($this->image, 0, 0, $color, $color);
	}
	
	private function drawEclipses() {
		for( $i=1; $i<=$this->eclipses; $i++ ) {
			$r = round(rand(0, $this->colorMax));
			$g = round(rand(0, $this->colorMax));
			$b = round(rand(0, $this->colorMax));
			$color = imagecolorallocate( $this->image, $r, $g, $b );
			imagefilledellipse( $this->image,round(rand(0,$this->width)), round(rand(0,$this->height)), round(rand(0,$this->width/16)), round(rand(0,$this->height/4)), $color );
		}
	}
	
	private function drawLines() {
		for( $i=1; $i<=$this->lines; $i++ ) {
			$r = round(rand(0, $this->colorMax));
			$g = round(rand(0, $this->colorMax));
			$b = round(rand(0, $this->colorMax));
			$color = imagecolorallocate($this->image, $r, $g, $b);
			imageline($this->image, rand(0, $this->width), rand(0, $this->height), rand(0, $this->width), rand(0, $this->height), $color);
		}
	}
	
	private function drawCharacters() {
		for( $i=0; $i<$this->characters; $i++ ) {
			$r = round(rand(127, 255));
			$g = round(rand(127, 255));
			$b = round(rand(127, 255));
			$x_pos = round($this->max_font_size*$this->fontPosMin) + $i * round($this->max_font_size*$this->fontPosMax);
			$y_pos = ($this->height / 2) + round(rand(5, 20));
			$fontsize = round(rand($this->min_font_size, $this->max_font_size));
			$color = imagecolorallocate( $this->image, $r, $g, $b);
			$presign = round(rand(0, 1));
			$angle = round(rand(0, 25));
			if( $presign == true )
				$angle = -1*$angle;
			imagettftext($this->image, $fontsize, $angle, $x_pos, $y_pos, $color, $this->getFont(), substr($this->code,$i,1));
		}
	}
	
	public function generate() {
		$this->image = imagecreatetruecolor($this->width, $this->height);
		$this->setBackground();
		imagealphablending($this->image, 1);
		imagecolortransparent($this->image);
		$this->drawLines();
		$this->drawEclipses();
		$this->drawCharacters();
		header('Content-type: image/jpeg');
		imagejpeg($this->image);
		imagedestroy($this->image);
	}
	
	private function check() {
//		$gd = gd_info();
//        if ( !$gd['Freetype Support'] || !$gd['JPG Support'] ) {
//            trigger_error('You dont have support for Freetype and/or JPG support in GD!', E_USER_ERROR);
//        }
	}
}
?>
