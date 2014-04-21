<?php

/**
 * 图像操作类库
 */
class Image {

    // 源的 X 坐标点
    public $srcX = 0;

    // 源的 Y 坐标点
    public $srcY = 0;

    // 目标宽度
    public $dstWidth = 200;

    // 目标高度
    public $dstHeight = 200;

    // 源的宽度
    public $cutWidth = 0;

    // 源的高度
    public $cutHeight = 0;

    // 水印的透明度
    public $alpha = 80;
    
    // 源图像信息
    public $imageInfo = null; 

    static private $session = null;
    
    static public function setSession($val){
        self::$session = $val;
    }
    
    /**
     * 取得图像信息
     * @static
     * @access public
     * @param string $image 图像文件名
     * @return mixed
     */
    static public function getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if ($imageInfo === false) {
            return false;
        }

        $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
        $imageSize = filesize($img);

        return array(
            "width" => $imageInfo[0],
            "height" => $imageInfo[1],
            "type" => $imageType,
            "size" => $imageSize,
            "mime" => $imageInfo['mime']
        );
    }

    /**
     * 显示图片
     * @static
     * @access public
     * @param string $image  原图
     * @return boolean|string
     */
    static public function showImg($image) {
        $info = self::getImageInfo($image);
        if ($info === false) {
            return false;
        }

        $createFun = 'imagecreatefrom' . $info['type'];
        $im = $createFun($image);

        self::output($im, $info['type']);
    }

    /**
     * 生成图像验证码
     * @static
     * @access public
     * @param string $length  位数
     * @param string $mode  类型
     * @param string $type 图像格式
     * @param string $width  宽度
     * @param string $height  高度
     * @return string
     */
    static public function buildImageVerify($length=4, $mode=1, $width=48, $height=22, $verifyName='verify') {

        $randval = String::randString($length, $mode);
        
        self::$session->set($verifyName, md5($randval));

        $width = ($length * 10 + 10) > $width ? $length * 10 + 10 : $width;
        if (function_exists('imagecreatetruecolor')) {
            $im = imagecreatetruecolor($width, $height);
        } else {
            $im = imagecreate($width, $height);
        }
        $r = Array(225, 255, 255, 223);
        $g = Array(225, 236, 237, 255);
        $b = Array(225, 236, 166, 125);
        $key = mt_rand(0, 3);

        $backColor   = imagecolorallocate($im, $r[$key], $g[$key], $b[$key]);    //背景色（随机）
        $borderColor = imagecolorallocate($im, 100, 100, 100);                    //边框色
        imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);
        imagerectangle($im, 0, 0, $width - 1, $height - 1, $borderColor);
        $stringColor = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
        // 干扰
        for ($i = 0; $i < 10; $i++) {
            imagearc($im, mt_rand(-10, $width), mt_rand(-10, $height), mt_rand(30, 300), mt_rand(20, 200), 55, 44, $stringColor);
        }
        for ($i = 0; $i < 25; $i++) {
            imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $stringColor);
        }
        for ($i = 0; $i < $length; $i++) {
            imagestring($im, 5, $i * 10 + 5, mt_rand(1, 8), $randval{$i}, $stringColor);
        }

        header('Content-type: image/png');
        imagepng($im);
        imagedestroy($im);
    }

    /**
     * 把图像转换成字符显示
     * @static
     * @access public
     * @param string $image  要显示的图像
     * @param string $type  图像类型，默认自动获取
     * @return string
     */
    static public function showASCIIImg($image, $string='', $type='') {
        $info = self::getImageInfo($image);
        if ($info === false) {
            return false;
        }
        
        $type = empty($type) ? $info['type'] : $type;
        unset($info);

        // 载入原图
        $createFun = 'ImageCreateFrom' . ($type == 'jpg' ? 'jpeg' : $type);
        $im = $createFun($image);
        $dx = imagesx($im);
        $dy = imagesy($im);
        $i = 0;

        $out = '<span style="padding:0px;margin:0;line-height:100%;font-size:1px;">';
        set_time_limit(0);
        for ($y = 0; $y < $dy; $y++) {
            for ($x = 0; $x < $dx; $x++) {
                $col = imagecolorat($im, $x, $y);
                $rgb = imagecolorsforindex($im, $col);
                $str = empty($string) ? '*' : $string[$i++];
                $out .= sprintf('<span style="margin:0px;color:#%02x%02x%02x">' . $str . '</span>', $rgb['red'], $rgb['green'], $rgb['blue']);
            }
            $out .= "<br>\n";
        }
        $out .= '</span>';

        imagedestroy($im);

        return $out;
    }

    /**
     * 生成UPC-A条形码
     * @static
     * @param string $type 图像格式
     * @param string $type 图像格式
     * @param string $lw   单元宽度
     * @param string $hi   条码高度
     * @return string
     */
    static public function UPCA($code, $type='png', $lw=2, $hi=100) {
        static $Lencode = array('0001101', '0011001', '0010011', '0111101', '0100011', '0110001', '0101111', '0111011', '0110111', '0001011');
        static $Rencode = array('1110010', '1100110', '1101100', '1000010', '1011100', '1001110', '1010000', '1000100', '1001000', '1110100');
        $ends = '101';
        $center = '01010';

        // UPC-A Must be 11 digits, we compute the checksum.
        if (strlen($code) != 11) {
            die("UPC-A Must be 11 digits.");
        }

        // Compute the EAN-13 Checksum digit
        $ncode = '0' . $code;
        $even = 0;
        $odd = 0;
        for ($x = 0; $x < 12; $x++) {
            if ($x % 2) {
                $odd += $ncode[$x];
            } else {
                $even += $ncode[$x];
            }
        }
        $code.= ( 10 - (($odd * 3 + $even) % 10)) % 10;

        // Create the bar encoding using a binary string
        $bars = $ends;
        $bars.=$Lencode[$code[0]];
        for ($x = 1; $x < 6; $x++) {
            $bars.=$Lencode[$code[$x]];
        }
        $bars.=$center;
        for ($x = 6; $x < 12; $x++) {
            $bars.=$Rencode[$code[$x]];
        }
        $bars.=$ends;

        // Generate the Barcode Image
        if ($type != 'gif' && function_exists('imagecreatetruecolor')) {
            $im = imagecreatetruecolor($lw * 95 + 30, $hi + 30);
        } else {
            $im = imagecreate($lw * 95 + 30, $hi + 30);
        }

        $fg = ImageColorAllocate($im, 0, 0, 0);
        $bg = ImageColorAllocate($im, 255, 255, 255);
        ImageFilledRectangle($im, 0, 0, $lw * 95 + 30, $hi + 30, $bg);

        for ($x = 0; $x < strlen($bars); $x++) {
            if (($x < 10) || ($x >= 45 && $x < 50) || ($x >= 85)) {
                $sh = 10;
            } else {
                $sh = 0;
            }
            if ($bars[$x] == '1') {
                $color = $fg;
            } else {
                $color = $bg;
            }
            ImageFilledRectangle($im, ($x * $lw) + 15, 5, ($x + 1) * $lw + 14, $hi + 5 + $sh, $color);
        }

        // Add the Human Readable Label
        ImageString($im, 4, 5, $hi - 5, $code[0], $fg);
        for ($x = 0; $x < 5; $x++) {
            ImageString($im, 5, $lw * (13 + $x * 6) + 15, $hi + 5, $code[$x + 1], $fg);
            ImageString($im, 5, $lw * (53 + $x * 6) + 15, $hi + 5, $code[$x + 6], $fg);
        }

        ImageString($im, 4, $lw * 95 + 17, $hi - 5, $code[11], $fg);

        // Output the Header and Content.
        self::output($im, $type);
    }
    
    /**
     * 输入图片
     * @static
     * @access private
     * @param string $image  原图
     * @return boolean|string
     */
    static private function output($im, $type='png') {
        header("Content-type: image/" . $type);
        $ImageFun = 'image' . $type;
        $ImageFun($im, null, 100);
        imagedestroy($im);
    }

    /**
     * 为图片添加水印
     * @access public
     * @param string $source 原文件名
     * @param string $water  水印图片
     * @param string $$savename  添加水印后的图片名
     * @param boolean $isCover  是否覆盖
     * @return string
     */
    public function water($source, $water, $savename=null, $isCover=false) {

        $sInfo = $this->getImageInfo($source);
        if ($sInfo === false){
            return false;
        }

        //建立图像
        $sCreateFun = 'imagecreatefrom' . $sInfo['type'];
        $sImage = $sCreateFun($source);

        if (is_file($water) && file_exists($water)) {//判断$text是否是图片路径
            // 取得水印信息
            $wInfo = $this->getImageInfo($water);

            //如果图片小于水印图片，不生成图片
            if ($sInfo['width'] < $wInfo['width'] || $sInfo['height'] < $wInfo['height']) {
                return false;
            } 

            $wCreateFun = 'imagecreatefrom' . $wInfo['type'];
            $wImage = $wCreateFun($water);

            //设定图像的混色模式
            imagealphablending($wImage, true);

            //设置水印的显示位置和透明度支持各种图片格式
            imagecopymerge($sImage, $wImage, $this->srcX, $this->srcY, 0, 0, $wInfo['width'], $wInfo['height'], $this->alpha);

        } else {
            $black = imagecolorallocate($sImage, 0, 0, 0);
            imagestring($sImage, 5, $this->srcX, $this->srcY, $water, $black);
        }

        //如果没有给出保存文件名，默认为原图像名
        if ($isCover) {
            $savename = $source;
            @unlink($source);
        }

        if(!$savename){
            header('Content-type: ' . $sInfo['mime']);
        }

        //输出图像
        $ImageFun = 'image' . $sInfo['type'];
        $ImageFun($sImage, $savename, 100);
        imagedestroy($sImage);

        return $savename;
    }

    /**
     * 生成特定尺寸缩略图 解决原版缩略图不能满足特定尺寸的问题 PS：会裁掉图片不符合缩略图比例的部分
     * @access public
     * @param string $image  原图
     * @param string $thumbname 缩略图文件名
     * @param string $uploadPath 缩略图文件上传路径
     * @param boolean $delete 是否删除原文件
     * @return string 缩略图文件名
     */
    public function thumb($image, $thumbName, $uploadPath, $delete=true) {
        
        if(!$this->imageInfo){
            $this->imageInfo = $this->getImageInfo($image);
        }
        
        if ($this->imageInfo === false) {
            return false;
        }

        if($this->dstWidth > $this->imageInfo['width'] && $this->dstHeight > $this->imageInfo['height']){
            $thumbName .= '.' . $this->imageInfo['type'];
            @rename($image, $uploadPath . $thumbName);

            return $thumbName;
        }else{

            $imgName = $this->crupImg($image, $thumbName, $uploadPath);
            if( $imgName && $delete ){

                @unlink($image);
            }

            return $imgName;
        }
    }
    
    /**
     * 以浏览器方式输入缩略图
     * @access public
     * @param string $image  原图
     * @return void
     */
    public function showThumb($image) {
        if(!$this->imageInfo){
            $this->imageInfo = $this->getImageInfo($image);
        }
        
        if ($this->imageInfo === false) {
            return false;
        }

        $this->crupImg($image);
    }

    /**
     * 生成特定尺寸缩略图 解决原版缩略图不能满足特定尺寸的问题 PS：会裁掉图片不符合缩略图比例的部分
     * @access private
     * @param string $image  原图
     * @param string $thumbname 缩略图文件名
     * @param string $uploadPath 缩略图文件上传路径
     * @return void
     */
    private function crupImg($image, $thumbName=null, $uploadPath=''){
        
        // 获取原图信息
        $info = $this->imageInfo;
        
        if( $this->cutWidth == 0 || $this->cutHeight == 0 ){

            //判断原图和缩略图比例 如原图宽于缩略图则裁掉两边 反之..
            $wScale = $this->dstWidth / $info['width'];
            $hScale = $this->dstHeight / $info['height'];
            $scale = max($wScale, $hScale); // 计算缩放比例

            if($wScale > $hScale){ //高于
                $this->cutWidth  = $info['width'];
                $this->cutHeight = $this->dstHeight / $scale;
                $this->srcX = 0;
                $this->srcY = ($info['height'] - $this->cutHeight) / 2 ;
            }else{ //宽于
                $this->cutWidth = $this->dstWidth / $scale;
                $this->cutHeight = $info['height'];
                $this->srcX = ($info['width'] - $this->cutWidth) / 2;
                $this->srcY = 0;
            }
        }
        
        // 载入原图
        $createFun = 'imagecreatefrom' . $info['type'];
        $srcImg = $createFun($image);

        //创建缩略图
        if ($info['type'] != 'gif' && function_exists('imagecreatetruecolor')){
            $imageCreate = 'imagecreatetruecolor';
        } else {
            $imageCreate = 'imagecreate';
        }

        $dstImg = $imageCreate($this->dstWidth, $this->dstHeight);

        // 复制图片
        if (function_exists('imagecopyresampled')){
            $imageCopy = 'imagecopyresampled';
        } else {
            $imageCopy = 'imagecopyresized';
        }

        $imageCopy($dstImg, $srcImg, 0, 0, $this->srcX, $this->srcY, $this->dstWidth, $this->dstHeight, $this->cutWidth, $this->cutHeight);
            
        if ('gif' == $info['type'] || 'png' == $info['type']) {
            $background_color = imagecolorallocate($dstImg, 0, 255, 0); //指派一个绿色
            imagecolortransparent($dstImg, $background_color); //设置为透明色，若注释掉该行则输出绿色的图

        } else if ('jpg' == $info['type']) {
            // 对jpeg图形设置隔行扫描
            imageinterlace($dstImg, 1);
        }

        if(!$thumbName){
            header('Content-type: image/' . $info['type']);
            $thumbFile = null;
        }else{
            $thumbName .= '.' .$info['type'];

            if(strrchr($uploadPath, "/") !== '/'){
                $uploadPath .= '/';
            }

            $thumbFile = $uploadPath . $thumbName;
        }

        // 生成图片
        $imageFun = 'image' . $info['type'];
        $imageFun($dstImg, $thumbFile, 100);

        imagedestroy($dstImg);
        imagedestroy($srcImg);
        
        return $thumbName;
    }
}
