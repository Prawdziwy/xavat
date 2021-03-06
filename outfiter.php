<?php
class Outfiter {

	protected static $instance = null;
	protected static $_outfit_lookup_table = array(
		0xFFFFFF, 0xFFD4BF, 0xFFE9BF, 0xFFFFBF, 0xE9FFBF, 0xD4FFBF,
		0xBFFFBF, 0xBFFFD4, 0xBFFFE9, 0xBFFFFF, 0xBFE9FF, 0xBFD4FF,
		0xBFBFFF, 0xD4BFFF, 0xE9BFFF, 0xFFBFFF, 0xFFBFE9, 0xFFBFD4,
		0xFFBFBF, 0xDADADA, 0xBF9F8F, 0xBFAF8F, 0xBFBF8F, 0xAFBF8F,
		0x9FBF8F, 0x8FBF8F, 0x8FBF9F, 0x8FBFAF, 0x8FBFBF, 0x8FAFBF,
		0x8F9FBF, 0x8F8FBF, 0x9F8FBF, 0xAF8FBF, 0xBF8FBF, 0xBF8FAF,
		0xBF8F9F, 0xBF8F8F, 0xB6B6B6, 0xBF7F5F, 0xBFAF8F, 0xBFBF5F,
		0x9FBF5F, 0x7FBF5F, 0x5FBF5F, 0x5FBF7F, 0x5FBF9F, 0x5FBFBF,
		0x5F9FBF, 0x5F7FBF, 0x5F5FBF, 0x7F5FBF, 0x9F5FBF, 0xBF5FBF,
		0xBF5F9F, 0xBF5F7F, 0xBF5F5F, 0x919191, 0xBF6A3F, 0xBF943F,
		0xBFBF3F, 0x94BF3F, 0x6ABF3F, 0x3FBF3F, 0x3FBF6A, 0x3FBF94,
		0x3FBFBF, 0x3F94BF, 0x3F6ABF, 0x3F3FBF, 0x6A3FBF, 0x943FBF,
		0xBF3FBF, 0xBF3F94, 0xBF3F6A, 0xBF3F3F, 0x6D6D6D, 0xFF5500,
		0xFFAA00, 0xFFFF00, 0xAAFF00, 0x54FF00, 0x00FF00, 0x00FF54,
		0x00FFAA, 0x00FFFF, 0x00A9FF, 0x0055FF, 0x0000FF, 0x5500FF,
		0xA900FF, 0xFE00FF, 0xFF00AA, 0xFF0055, 0xFF0000, 0x484848,
		0xBF3F00, 0xBF7F00, 0xBFBF00, 0x7FBF00, 0x3FBF00, 0x00BF00,
		0x00BF3F, 0x00BF7F, 0x00BFBF, 0x007FBF, 0x003FBF, 0x0000BF,
		0x3F00BF, 0x7F00BF, 0xBF00BF, 0xBF007F, 0xBF003F, 0xBF0000,
		0x242424, 0x7F2A00, 0x7F5500, 0x7F7F00, 0x557F00, 0x2A7F00,
		0x007F00, 0x007F2A, 0x007F55, 0x007F7F, 0x00547F, 0x002A7F,
		0x00007F, 0x2A007F, 0x54007F, 0x7F007F, 0x7F0055, 0x7F002A,
		0x7F0000,
	);

	public static function instance() {
		if (!isset(self::$instance))
			self::$instance = new self();
		return self::$instance;
	}
	
	protected function alphaOverlay(&$destImg, &$overlayImg, $imgW, $imgH) {
		for ($y = 0; $y < $imgH; $y++) {
			for ($x = 0; $x < $imgW; $x++) {
				$ovrARGB = imagecolorat($overlayImg, $x, $y);
				$ovrA = ($ovrARGB >> 24) << 1;
				$ovrR = $ovrARGB >> 16 & 0xFF;
				$ovrG = $ovrARGB >> 8 & 0xFF;
				$ovrB = $ovrARGB & 0xFF;

				$change = false;
				if ($ovrA == 0) {
					$dstR = $ovrR;
					$dstG = $ovrG;
					$dstB = $ovrB;
					$change = true;
				} elseif ($ovrA < 254) {
					$dstARGB = imagecolorat($destImg, $x, $y);
					$dstR = $dstARGB >> 16 & 0xFF;
					$dstG = $dstARGB >> 8 & 0xFF;
					$dstB = $dstARGB & 0xFF;

					$dstR = (($ovrR * (0xFF - $ovrA)) >> 8) + (($dstR * $ovrA) >> 8);
					$dstG = (($ovrG * (0xFF - $ovrA)) >> 8) + (($dstG * $ovrA) >> 8);
					$dstB = (($ovrB * (0xFF - $ovrA)) >> 8) + (($dstB * $ovrA) >> 8);
					$change = true;
				}
				if ($change) {
					$dstRGB = imagecolorallocatealpha($destImg, $dstR, $dstG, $dstB, 0);
					imagesetpixel($destImg, $x, $y, $dstRGB);
				}
			}
		}
		return $destImg;
	}

	protected function outfit($outfit, $addons, $head, $body, $legs, $feet, $mount, $dir = 3) 
	{
		$outfitPath = "outfits/";
		$ioutfit = $ioutfit_template = null;
		$mount_id = $mount;
		$mount = ($mount == 0) ? 1 : 2;
		
		//make sure the outfit has addons
		if($addons != 0 && !file_exists($outfitPath . $outfit . '/1_1_' . $addons . '_' . $dir . '.png'))
			$addons = 0;
		
		if($addons == 3)
		{
			if($mount == 2) //check for images (mounted)
			{
				for($i = 1; $i <= 3; $i++)
				{
					if(!file_exists($outfitPath . $outfit . '/1_'. $mount .'_'. $i .'_' . $dir . '.png')
						|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_'. $i .'_' . $dir . '_template.png'))
						$mount = 1;
				}
			}
			
			if($mount == 1) //check for images (dismounted)
			{
				for($i = 1; $i <= 3; $i++)
				{
					if(!file_exists($outfitPath . $outfit . '/1_' . $mount . '_'. $i .'_' . $dir . '.png')
						|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_'. $i .'_' . $dir . '_template.png'))
						return;
				}
			}
				
			$addon2 = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_3_' . $dir . '.png');
			$addon1 = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_2_' . $dir . '.png');
			$addon2t = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_3_' . $dir . '_template.png');
			$addon1t = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_2_' . $dir . '_template.png');
			
			$ioutfit = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '.png');
			$ioutfit_template = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '_template.png');
			
			$this->alphaOverlay($ioutfit, $addon1, 64, 64);
			$this->alphaOverlay($ioutfit_template, $addon1t, 64, 64);
			
			$this->alphaOverlay($ioutfit, $addon2, 64, 64);
			$this->alphaOverlay($ioutfit_template, $addon2t, 64, 64);
		} 
		else if($addons == 2) 
		{
			if($mount == 2) //check for images (mounted)
			{
				if(!file_exists($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '.png')
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_3_' . $dir . '.png') 
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '_template.png') 
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_3_' . $dir . '_template.png'))
					$mount = 1;
			}
			
			if($mount == 1) //check for images (dismounted)
			{
				if(!file_exists($outfitPath . $outfit . '/1_'. $mount .'_3_' . $dir . '.png') 
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '.png') 
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '_template.png') 
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_3_' . $dir . '_template.png'))
					return;
			}
				
			$addon2 = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_3_' . $dir . '.png');
			$addon2t = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_3_' . $dir . '_template.png');
			
			$ioutfit = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '.png');
			$ioutfit_template = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '_template.png');
			imagealphablending($ioutfit, false);
			imagesavealpha($ioutfit, true);
			
			$this->alphaOverlay($ioutfit, $addon2, 64, 64);
			$this->alphaOverlay($ioutfit_template, $addon2t, 64, 64);
			
		} 
		else if($addons == 1)
		{
			if($mount == 2) //check for images (mounted)
			{
				if(!file_exists($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '.png')
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_2_' . $dir . '.png')
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '_template.png')
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_2_' . $dir . '_template.png'))
					$mount = 1;
			}
			
			if($mount == 1) //check for images (dismounted)
			{
				if(!file_exists($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '.png')
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_2_' . $dir . '.png')
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '_template.png')
					|| !file_exists($outfitPath . $outfit . '/1_'. $mount .'_2_' . $dir . '_template.png'))
					return;
			}
				
			$addon1 = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_2_' . $dir . '.png');
			$addon1t = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_2_' . $dir . '_template.png');
			
			$ioutfit = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '.png');
			$ioutfit_template = imagecreatefrompng($outfitPath . $outfit . '/1_'. $mount .'_1_' . $dir . '_template.png');
			
			$this->alphaOverlay($ioutfit, $addon1, 64, 64);
			$this->alphaOverlay($ioutfit_template, $addon1t, 64, 64);
			
		}
		else
		{
			if(file_exists($outfitPath . $outfit . '/1_' . $mount . '_1_' . $dir . '_template.png'))
			{
				$ioutfit = imagecreatefrompng($outfitPath . $outfit . '/1_' . $mount . '_1_' . $dir . '.png');
				$ioutfit_template = imagecreatefrompng($outfitPath . $outfit . '/1_' . $mount . '_1_' . $dir . '_template.png');
			}
			else
			{
				$tmpOutfit = null;
				if(!file_exists($outfitPath . $outfit . '/1_1_1_' . $dir . '.png')) 
				{
					$tmpOutfit = imagecreatefrompng($outfitPath . $outfit . '/1_1_1_1.png');
				}
				else
					$tmpOutfit = imagecreatefrompng($outfitPath . $outfit . '/1_1_1_' . $dir . '.png');
				imagealphablending($tmpOutfit, false);
				imagesavealpha($tmpOutfit, true);
				return $tmpOutfit;
			}
		}
		
		$this->colorize($ioutfit_template, $ioutfit, $head, $body, $legs, $feet);
		if($mount == 2 && file_exists($outfitPath . $mount_id . '/1_1_1_' . $dir . '.png')) 
		{
			$mount = imagecreatefrompng($outfitPath . $mount_id . '/1_1_1_' . $dir . '.png');
			$this->alphaOverlay($mount, $ioutfit, 64, 64);
			$ioutfit = $mount;
		}
		
		imagealphablending($ioutfit, false);
		imagesavealpha($ioutfit, true);
		imagedestroy($ioutfit_template);
		return $ioutfit;
	}

	public function render($outfit, $addons, $head, $body, $legs, $feet, $mount) {
		return imagepng($this->outfit($outfit, $addons, $head, $body, $legs, $feet, $mount));
	}

	public function save($outfit, $addons, $head, $body, $legs, $feet, $mount, $_file) {
		imagepng($this->outfit($outfit, $addons, $head, $body, $legs, $feet, $mount), $_file);
	}

	protected function colorizePixel($_color, &$_r, &$_g, &$_b) {
		if ($_color < count(self::$_outfit_lookup_table))
			$value = self::$_outfit_lookup_table[$_color];
		else
			$value = 0;
		$ro = ($value & 0xFF0000) >> 16; // rgb outfit
		$go = ($value & 0xFF00) >> 8;
		$bo = ($value & 0xFF);
		$_r = (int) ($_r * ($ro / 255));
		$_g = (int) ($_g * ($go / 255));
		$_b = (int) ($_b * ($bo / 255));
	}

	protected function colorize(&$_image_template, &$_image_outfit, $_head, $_body, $_legs, $_feet) {
		for ($i = 0; $i < imagesy($_image_template); $i++) {
			for ($j = 0; $j < imagesx($_image_template); $j++) {
				$templatepixel = imagecolorat($_image_template, $j, $i);
				$outfit = imagecolorat($_image_outfit, $j, $i);

				if ($templatepixel == $outfit)
					continue;

				$rt = ($templatepixel >> 16) & 0xFF;
				$gt = ($templatepixel >> 8) & 0xFF;
				$bt = $templatepixel & 0xFF;
				$ro = ($outfit >> 16) & 0xFF;
				$go = ($outfit >> 8) & 0xFF;
				$bo = $outfit & 0xFF;

				if ($rt && $gt && !$bt) { // yellow == head
					$this->colorizePixel($_head, $ro, $go, $bo);
				} else if ($rt && !$gt && !$bt) { // red == body
					$this->colorizePixel($_body, $ro, $go, $bo);
				} else if (!$rt && $gt && !$bt) { // green == legs
					$this->colorizePixel($_legs, $ro, $go, $bo);
				} else if (!$rt && !$gt && $bt) { // blue == feet
					$this->colorizePixel($_feet, $ro, $go, $bo);
				} else {
					continue; // if nothing changed, skip the change of pixel
				}

				imagesetpixel($_image_outfit, $j, $i, imagecolorallocate($_image_outfit, $ro, $go, $bo)); //do sprawdzenia
			}
		}
	}

}

header("Content-Type: image/png");
Outfiter::instance()->render($_GET['id'], $_GET['addons'], $_GET['head'], $_GET['body'], $_GET['legs'], $_GET['feet'], $_GET['mount']); 
?>