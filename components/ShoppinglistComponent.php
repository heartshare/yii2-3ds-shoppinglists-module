<?php
namespace yii3ds\shoppinglists\components;

use Yii;
use Kinglozzer\TinyPng\Compressor;
use Kinglozzer\TinyPng\Exception\AuthorizationException;
use Kinglozzer\TinyPng\Exception\InputException;
use Kinglozzer\TinyPng\Exception\LogicException;



class ShoppinglistsComponent
{
	public function isEmpty($value = '')
	{
		return empty($value);
	}

	public function isLanguageEqualTh($language = '')
	{
		$result = false;
		if( $language == 'th' )
		{
			$result =  true;
		}
		return $result;
	}

	public function fullPathImage($imagePath)
	{
		return 'full/path/image.jpg';
	}


	public function saveToS3($imagePath, $imageName)
	{
		$storage = Yii::$app->storage;
 		$url = $storage->uploadFile($imagePath, $imageName);
 		return $url;
	}

	public function compressFileByTinyPNG($imagePath)
	{
		$compressor = new Compressor('YQMspKmQ30INeu-Evv1d0IWaxoiq4RNc');

		try {
			$result = $compressor->compress($imagePath);
		    $result->writeTo( Yii::getAlias($imagePath)); // Write the returned image

		    /* ResponseData 
		    array(2) { ["input"]=> array(2) 
		    { ["size"]=> int(845755)
		      ["type"]=> string(10) "image/jpeg" }
		       ["output"]=> array(4) 
		       { ["size"]=> int(157338) 
		       ["type"]=> string(10) "image/jpeg" 
		       ["ratio"]=> float(0.186) 
		       ["url"]=> string(51) "https://api.tinypng.com/output/mqul8o8drnupuksn.jpg" } 
		     } 
		    */
		    // var_dump($result->getResponseData()); // array containing JSON-decoded response data


		} catch (AuthorizationException $e) {
		    // Invalid credentials or requests per month exceeded
		} catch (InputException $e) {
		    // Not a valid PNG or JPEG
		} catch (Exception $e) {
		    // Unknown error
		}
		return true;
	}

	

	public function saveOriginalFile($imagePath, $imageName)
	{
		$file=Yii::getAlias($imagePath); 
		$image=Yii::$app->image->load($file);

		$path = Yii::getAlias('@statics/web/shoppinglists/{folderPath}/' . $imageName);
		$originalPath = str_replace('{folderPath}', 'originals', $path);
		$image->save($originalPath);
	}

	public function resizeImageThumbSize($imagePath, $imageName)
	{
		$file=Yii::getAlias($imagePath); 
		$image=Yii::$app->image->load($file);

		
		$path = Yii::getAlias('@statics/web/shoppinglists/{folderPath}/' . $imageName);
		$thumbnailPath = str_replace('{folderPath}', 'thumbnails', $path);
		$image->resize(260, 260)->save($thumbnailPath);
		$this->compressFileByTinyPNG($thumbnailPath);
		$s3Url = $this->saveToS3($thumbnailPath, 'thumbnails/' . $imageName);
		unlink($thumbnailPath);
		return $s3Url;

	}

	public function resizeImageFullsize($imagePath, $imageName)
	{
		$file=Yii::getAlias($imagePath); 
		$image=Yii::$app->image->load($file);

		
		$path = Yii::getAlias('@statics/web/shoppinglists/{folderPath}/' . $imageName );
		$fullsizePath = str_replace('{folderPath}', 'fullsize', $path);
		$image->resize(640, 640)->save($fullsizePath);
		$this->compressFileByTinyPNG($fullsizePath);
		$s3Url = $this->saveToS3($fullsizePath, 'fullsize/' . $imageName);
		unlink($fullsizePath);
		return $s3Url;
	}

		
}